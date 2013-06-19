<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of portfoliomodel
 *
 * @author andrew
 */
class Portfoliomodel extends CI_Model {

	private $items = array();
	private $table;
	private $tablePath;
	
	public function __construct() {
	    
		parent::__construct();
		
		$this->load->helper('url');
		$this->tablePath = "assets/xml/portfolioitems.xml";
		$this->table = simplexml_load_file( realpath( $this->tablePath ) );

		foreach ( $this->table->item as $item ) {
			$this->items[] = $item;
		} 

    }

	public function getPortfolioItems( $front = false ) {

		$this->load->model('categoriesmodel');
		$categories = $this->categoriesmodel->getCategories();
		
		//Basically if being used on the front-end
		if ( $front ) {
			return json_encode( $this->items );
		}

		return $this->items;
		
	}

	public function getPortfolioItem( $name ) {

		foreach ( $this->items as $item ) {
			
			if (  $item[ 'name' ] == $name ) {
				$portfolioItem = $item;
			}
		}

		return $portfolioItem;

	}

	public function getPortfolioItemsFromCategory( $category ) {

		$categoryItems = array();

		foreach ( $this->items as $item ) {

			if ( $item->cat == $category ) { 
				$categoryItems[] = $item;
			}

		}

		return json_encode( $categoryItems );

	}

	public function resizeImages( $items ) {

		$config[ 'image_library' ] = 'gd2';
		$config[ 'create_thumb' ] = TRUE;
		$config[ 'maintain_ratio' ] = TRUE;
		$config[ 'width' ]	 = 265;
		$config[ 'height' ]  = 250;

		foreach ( $items as $item ) {

			$source_image = $item->image_url;
			
			$thumb_name = str_replace( array( '.png', '.jpg', '.gif' ), '_thumb.png', $item->image_url);
			$thumb_file = $_SERVER[ 'DOCUMENT_ROOT' ] . $_SERVER[ 'HTTP_HOST' ] . '/' . $thumb_name;
			
			if ( !file_exists( $thumb_file ) ) { 

				if( isset( $item->image_url ) ) {

					$config[ 'source_image' ] = $source_image;
					$this->image_lib->initialize( $config );

					if ( !$this->image_lib->resize() ) {
						echo $this->image_lib->display_errors();
					}

					$thumb_name = str_replace('.png', '_thumb.png', $item->image_url);
					$thumb_file = base_url() . $thumb_name;

					$item->thumb_url = $thumb_file;
				}
				
			}
			else {
				$item->thumb_url = base_url() . $thumb_name;
			}

		}
		
	}
	
	public function checkFile( $file ) {
		if ( !$xml = simplexml_load_file( base_url() . $file ) ) {
			return "Accessed Denied";
		}
		return $xml;
	}
	
	private function backupFile( $file ) {
		$this->portfoliomodel->checkFile( $file );
		copy( realpath( $file ) , str_replace( '.xml', '', realpath( $file ) ) . '-' . date( "i-H-d-m-y" ) . '.xml' );
	}

	public function updateItem( $item ){

		$file = new DOMDocument();
		$itemId = $item[ 'id' ];
		
		//load the XML file into the DOM, loading statically
		$file->load( $this->tablePath );

		//check if file has loaded
		if ( !$file ) {
			show_error('There was no XML file loaded');
			log_message('error', 'No XML file was loaded');
		}

		//if there is a node named 'item'
		if ( $file->getElementsByTagName( 'item' ) ) {
			//get all book by book id
			$origItem = $this->table->xpath( "//*[@id='$itemId']" );
		} 
		else {
			show_error( "The XML file contains no nodes named 'item'" );
			log_message( 'error', "XML file has no 'item' nodes" );
		}

		if ( count( $origItem ) > 0 ) {

			$image_directory = 'uploads';

			$origItem[ 0 ]->name          = $item[ 'title' ];
			$origItem[ 0 ]->desc          = $item[ 'description' ];
			$origItem[ 0 ]->site_url      = $item[ 'url' ];
			$origItem[ 0 ]->cat           = $item[ 'mainCategory' ];
			$origItem[ 0 ]->subCat        = $item[ 'subCategory' ];
			$origItem[ 0 ]->image_url     = $item[ 'img' ];

			if ( $item[ 'featured' ]  === '' ) {
				$item[ 'featured' ] = true;
			}

			$origItem[ 0 ]->featured = $item[ 'featured' ];
			$this->table->asXml( $this->tablePath );

		}

		else {
			throw new Exception( "Invalid Item ID $itemId" );
		}

		return true;

	}

}
?>
