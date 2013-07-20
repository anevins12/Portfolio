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

		// By default keep them alphabetically sorted
		$this->items = $this->sort( $this->items, 'name' );
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

	public function getPortfolioItem( $id ) {

		foreach ( $this->items as $item ) {
			
			$item_id = (string) $item->attributes(); 

			if ( $item_id == $id ) { 
				return $item;
			}
		}

		return false;

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

	public function updateItem( $newItem = false ) {
		
		$sessionDetails = $this->getSessionDetails();
		$data[ 'loggedInUsername' ] = $sessionDetails[ 'username' ];

		$id			 = $this->input->post( 'id' );
		$title		 = $this->input->post( 'title' );
		$description = $this->input->post( 'description' );
		$url		 = $this->input->post( 'url' );
		$category    = $this->input->post( 'mainCategory' );
		$subCategory = $this->input->post( 'subCategory' );
		$featured    = $this->input->post( 'featured' );

		htmlentities($title);
		htmlentities($description);
		htmlentities($url);

		if ( $url == 'http://' ) {
			$url = '';
		}

		$item = array( 'id' => $id, 'title' => $title, 'description' => $description,
		   'url' => $url, 'mainCategory' => $category, 'subCategory' => $subCategory,
		   'featured' => $featured
		 );

		// Check if image is being uploaded
		if ( !empty( $_FILES['img']['name'] ) ) {

			$uploaded = $this->upload();

			if ( $uploaded[ 'status' ] == false ) {
				$data[ 'errors' ] = $uploaded[ 0 ][ 'error' ];
			}
			else {
				$item[ 'img' ] =  'uploads' . '/' . $uploaded[ 0 ][ 'upload_data' ][ 'file_name' ];
			}

		}

		if ( $newItem ) {

			$this->doInsertItem( $item );
			return true;

		}

		if ( $this->doUpdateItem( $item ) ) {

			return true;
			
		}

		return false;

	}

	private function doUpdateItem( $item ) {

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
			return false;
		}

		if ( count( $origItem ) > 0 ) {

			$image_directory = 'uploads';

			$origItem[ 0 ]->name          = $item[ 'title' ];
			$origItem[ 0 ]->desc          = $item[ 'description' ];
			$origItem[ 0 ]->site_url      = $item[ 'url' ];
			$origItem[ 0 ]->cat           = $item[ 'mainCategory' ];
			$origItem[ 0 ]->subCat        = $item[ 'subCategory' ];

			if ( isset( $item[ 'img' ] ) ) {
				$origItem[ 0 ]->image_url     = $item[ 'img' ];
			}

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

	private function doInsertItem( $item ) {

		$file = new DOMDocument();
		//load the XML file into the DOM, loading statically
		$file->load( $this->tablePath );

		//check if file has loaded
		if ( !$file ) {
			show_error('There was no XML file loaded');
			log_message('error', 'No XML file was loaded');
		}

		//if there is a root node
		if ( $file->getElementsByTagName( 'portfolioItems' ) ) {
			//get that root document
			$root = $this->table->xpath( "//portfolioItems" ); 
		}
		else {
			show_error( "The XML file contains no root node named 'portfolioItems'" );
			log_message( 'error', "XML file has no 'portfolioItems' node" );
			return false;
		}

		//Just getting out of the array (of 1 item)
		$root = $root[0];
		
		//count the current items
		$countedItems = count( $this->getPortfolioItems() );

		//start the new xml for the new item
		$rootItem = $root->addChild( 'item' );

		//set the ID to be one above the countedItems
		$rootItem->addAttribute( 'id', $countedItems + 1 );

		//add the item details as children elements to the "item" element
		$rootItem->addChild( 'name', $item[ 'title' ] );
		$rootItem->addChild( 'desc', $item[ 'description' ] );
		$rootItem->addChild( 'image_url', $item[ 'img' ] );
		$rootItem->addChild( 'site_url', $item[ 'url' ] );
		$rootItem->addChild( 'cat', $item[ 'mainCategory' ] );
		$rootItem->addChild( 'subCat', $item[ 'subCategory' ] );
		$rootItem->addChild( 'featured', $item[ 'featured' ] );

		$this->table->asXml( $this->tablePath );

		return true;

	}

	public function getSessionDetails() {

		if ( $this->loggedIn() ) {
			return $this->session->all_userdata();
		}

		return false;

	}

	public function loggedIn() {

		$sessionUserData = $this->session->all_userdata();

		if ( @$sessionUserData[ 'logged_in' ] == true ) {
			return true;
		}

		return false;
		
	}

	public function sort( $items, $type ) {

		if ( $type == 'name' ) {
			//sort the array by borrowedcount descending
			//inspired by a comment on http://php.net/manual/en/function.array-multisort.php
			foreach ( $items as $k => $v )  { 
					$itemsSort[ $k ] = $v->name;
			}

			array_multisort( $itemsSort, SORT_STRING, $items );

		}

		return $items;

	}

	public function upload() {

		$config['upload_path'] = './uploads';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '5000';
		$config['remove_spaces'] = true;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload( 'img' ) ) {

			$error = array('error' => $this->upload->display_errors());
			return array( 'status' => false, $error );

		}
		else {

			$data = array('upload_data' => $this->upload->data());
			return array( 'status' => true, $data );

		}

	}

}
?>
