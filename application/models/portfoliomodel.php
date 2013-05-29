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

	private $portfolioItems = array();
	
	public function __construct() {
	    
		parent::__construct();
		
		$this->load->helper('url');
		$items = simplexml_load_file( base_url() . "assets/xml/portfolioitems.xml" );

		foreach ( $items->item as $item ) {
			$this->portfolioItems[] = $item;
		}

    }

	public function getPortfolioItems( $front = false ) {

		//Basically if being used on the front-end
		if ( $front ) {

			$this->load->model('categoriesmodel');
			$categories = $this->categoriesmodel->getCategories();				
			return json_encode( $this->portfolioItems );
			
		}

		return $this->portfolioItems;
		
	}

	public function getPortfolioItem( $name ) {

		foreach ( $this->portfolioItems as $item ) {
			
			if (  $item[ 'name' ] == $name ) {
				$portfolioItem = $item;
			}
		}

		return $portfolioItem;

	}

	public function getPortfolioItemsFromCategory( $category ) {

		$categoryItems = array();

		foreach ( $this->portfolioItems as $item ) {

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

			$image_path = "assets/i/items/$item->image_url";
			
			$name = str_replace('.png', '_thumb.png', $item->image_url);
			$thumb_file = 'assets/i/items/' . $name;

			if ( !file_exists( $thumb_file ) ) { 

				if( isset( $item->image_url ) ) {

					$config[ 'source_image' ] =  $image_path;
					$this->image_lib->initialize( $config );

					if ( !$this->image_lib->resize() ) {
						echo $this->image_lib->display_errors();
					}

					$name = str_replace('.png', '_thumb.png', $item->image_url);
					$thumb_file = base_url() . 'assets/i/items/' . $name;

					$item->thumb_url = $thumb_file;
				}
				
			}
			else {
				$item->thumb_url = base_url() . $thumb_file;
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

}
?>
