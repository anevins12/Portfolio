<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of items
 *
 * @author andrew
 */
class Admin extends CI_Controller {

	private $items = array();
	private $mainCategories = array();
	private $subCategories = array();

	public function __construct() {
		parent::__construct();
		$this->load->model('portfoliomodel');
		$this->load->model('categoriesmodel');
		$this->load->model('usersmodel');

		$this->load->library('form_validation');
		$this->load->library('phpass');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->helper('url');
		$this->load->helper('form');

		$this->items = $this->portfoliomodel->getPortfolioItems();
		$this->mainCategories = $this->categoriesmodel->getCategories();
		$this->subCategories = $this->categoriesmodel->getCategories( $sub = true ); 
	}

	public function index() {

		if( !$this->loggedIn() ) {
			$this->load->view( 'admin/login' );
			return false;
		}

		$sessionDetails = $this->getSessionDetails();
		
		$data['loggedInUsername'] = $sessionDetails[ 'username' ];
		$data['items'] = $this->items;
		$data['mainCategories'] = $this->mainCategories;
		$data['subCategories'] = $this->subCategories; 
		$this->load->view( 'admin/editItems', $data );

	}

	private function loadFile( $file ) {
		$xml = $this->portfoliomodel->checkFile( $file );
		return $xml;
	}

	public function updateItem() {

		if( !$this->loggedIn() ) {
			$this->load->view( 'admin/login' );
			return false;
		}
		
		$id			 = $this->input->post( 'id' );
		$title		 = $this->input->post( 'title' );
		$description = $this->input->post( 'description' );
		$url		 = $this->input->post( 'url' );
		$category    = $this->input->post( 'mainCategory' );
		$subCategory = $this->input->post( 'subCategory' );
		$featured    = $this->input->post( 'featured' );
		$image       = $this->input->post( 'img' );

		htmlentities($title);
		htmlentities($description);
		htmlentities($url);

		if ( $url == 'http://' ) {
			$url = '';
		}

		if ( isset( $image ) ) {
			
			$uploaded = $this->upload();
			
			if ( $uploaded[ 'status' ] == false ) {

				$data[ 'errors' ] = $uploaded[0][ 'error' ];
 
			}

			else {
				
				$data[ 'img' ] = $uploaded[ 0 ][ 'upload_data' ][ 'file_name' ];

			}
			
		}

		$item = array( 'id' => $id, 'title' => $title, 'description' => $description,
					   'url' => $url, 'mainCategory' => $category, 'subCategory' => $subCategory,
					   'featured' => $featured
					 );

		$data[ 'items' ] = $this->items;
		$data[ 'mainCategories' ] = $this->mainCategories;
		$data[ 'subCategories' ] = $this->subCategories;
		
		if ( $this->portfoliomodel->updateItem( $item ) ) {
			$this->load->view( 'admin/editItems', $data );
		}

	}

	public function login( $data = false ) {

		if( $this->loggedIn() ) { 
			$this->load->view( 'admin/editItems' ); 
			return true;
		}
		
		$data[ 'username' ] = $this->input->post( 'username' );
	
		$this->load->view( 'admin/login', $data );

	}

	public function validate() {

		$username = $this->input->post( 'username' );
		
		if ( !$this->usersmodel->validate() ) {

			$data[ 'errors' ] = "Invalid username and/or password" ;

			if ( isset( $username ) ) {
				$data[ 'username' ] = $username;
			}
			
			else {
				$data[ 'username' ] = '';
			}
			
			$this->login( $data );
			
		}
		else {

			$this->index();

		}

	}

	public function upload() {

		$config['upload_path'] = './uploads';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '500';
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

	public function loggedIn() {

		$sessionUserData = $this->session->all_userdata();
		
		if ( @$sessionUserData[ 'logged_in' ] == true ) {
			return true;
		}

		return false;

	}

	private function getSessionDetails() {

		if ( $this->loggedIn() ) {
			return $this->session->all_userdata();
		}

		return false;

	}

	public function logout() {

		$sessionDetails = $this->getSessionDetails();

		$this->session->unset_userdata($sessionDetails); 
		$this->login();

	}


}

?>
