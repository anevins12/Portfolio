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
	private $itemsAndCategories = array();

	public function __construct() {
		
		parent::__construct();
		$this->load->model('portfoliomodel');
		$this->load->model('categoriesmodel');
		$this->load->model('usersmodel');

		$this->load->library('form_validation');
		$this->load->library('phpass');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('image_lib');

		$this->load->helper('url');
		$this->load->helper('form');

		$this->items = $this->portfoliomodel->getPortfolioItems();
		$this->items = $this->portfoliomodel->resizeImages( $this->items );
		
		$this->mainCategories = $this->categoriesmodel->getCategories();
		
		foreach ( $this->mainCategories as $k => $v ) { 
			$this->subCategories[ $k ] = $this->categoriesmodel->getCategoryByParentID( $k );
		}

		$this->setItemsAndCategories();

	}

	private function setItemsAndCategories() {

		foreach ( $this->mainCategories as $k => $v ) {

			$this->itemsAndCategories[ $v ] = json_decode( $this->portfoliomodel->getPortfolioItemsFromCategory( $k ) );

		}
		
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
		$data['itemsAndCategories'] = $this->itemsAndCategories;
		
		$this->load->view( 'admin/allItems', $data );

	}

	public function item( $id ) {
		
		if( !$this->loggedIn() ) {
			$this->load->view( 'admin/login' );
			return false;
		}

		$sessionDetails = $this->getSessionDetails();

		$data[ 'loggedInUsername' ] = $sessionDetails[ 'username' ];
		$data[ 'item' ] = $this->portfoliomodel->getPortfolioItem( $id );
		$data[ 'mainCategories' ] = $this->mainCategories;
		$data[ 'subCategories' ] = $this->subCategories;
		$data[ 'itemsAndCategories' ] = $this->itemsAndCategories;
		
		$this->load->view( 'admin/editItem', $data );

	}

	private function loadFile( $file ) {
		$xml = $this->portfoliomodel->checkFile( $file );
		return $xml;
	}

	public function updateItem( $json = false ) {

		if( !$this->loggedIn() ) {
			$this->load->view( 'admin/login' );
			return false;
		}

		// If the page was refreshed on the 'updateItem' URL then just load the forms again
		if( !$this->input->post() ) {
			$this->index();
			return false;
		}

		$posted = $this->input->post();
		$id = $posted[ 'id' ];
		
		$sessionDetails = $this->getSessionDetails();

		$data[ 'item' ] = $this->portfoliomodel->getPortfolioItem( $id );
		$data[ 'loggedInUsername' ] = $sessionDetails[ 'username' ];
		$data[ 'mainCategories' ] = $this->mainCategories;
		$data[ 'subCategories' ] = $this->subCategories;

		if ( $this->portfoliomodel->updateItem() ) {

			//Have to set the items again because they have been updated
			$this->setItemsAndCategories();
			$data[ 'itemsAndCategories' ] = $this->itemsAndCategories;
			$data[ 'updated' ][ 'status' ] = true;
			$data[ 'updated' ][ 'message' ] = 'Successfully updated';

			$this->load->view( 'admin/editItem', $data );
		}

	}

	public function login( $data = false ) {

		if( $this->loggedIn() ) { 
			$this->load->view( 'admin/allItems' );
			return true;
		}
		
		$data[ 'username' ] = $this->input->post( 'username' );
		$this->load->view( 'admin/login', $data );

	}

	public function validate() {

		//if someone have gone to this function without submitting the form
		$posted = $this->input->post(); 
		if ( $posted ) {

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
		else {

			$this->index();
			return false;

		}

	}

	public function upload() {

		$this->portfoliomodel->upload();

	}

	public function loggedIn() {

		$loggedIn = $this->portfoliomodel->loggedIn(); 
		return $loggedIn;

	}


	private function getSessionDetails() {

		return $this->portfoliomodel->getSessionDetails();

	}

	public function logout() {
 
		$sessionDetails = $this->getSessionDetails();

		$this->session->unset_userdata($sessionDetails); 
		$this->login();

	}

	public function newItem() {
		
		$sessionDetails = $this->getSessionDetails();
		
		$data[ 'loggedInUsername' ] = $sessionDetails[ 'username' ];
		$data[ 'mainCategories' ] = $this->mainCategories;
		$data[ 'subCategories' ] = $this->subCategories;
		$data[ 'itemsAndCategories' ] = $this->itemsAndCategories;

		$this->load->view( 'admin/newItem', $data );

	}

	public function insertNewItem() {

		if( !$this->loggedIn() ) {
			$this->load->view( 'admin/login' );
			return false;
		}

		// If the page was refreshed on the 'updateItem' URL then just load the forms again
		if( !$this->input->post() ) {
			$this->index();
			return false;
		}

		if ( $this->portfoliomodel->updateItem( true ) ) {

			$sessionDetails = $this->getSessionDetails();
			$data[ 'loggedInUsername' ] = $sessionDetails[ 'username' ];
			$data[ 'updated' ][ 'status' ] = true;
			$data[ 'updated' ][ 'message' ] = 'Successfully updated';
			$data[ 'mainCategories' ] = $this->mainCategories;
			$data[ 'subCategories' ] = $this->subCategories;

		$this->setItemsAndCategories();
			$data[ 'itemsAndCategories' ] = $this->itemsAndCategories;

		}
		else {
			return false;
		}
		
		$this->load->view( 'admin/newItem', $data );
		
	}

	public function deleteItem( $id ) {

		if ( $this->portfoliomodel->deleteItem( $id ) ) {

			$this->items = $this->portfoliomodel->getPortfolioItems(); 
			$sessionDetails = $this->getSessionDetails();
			$this->setItemsAndCategories();
			
			$data[ 'loggedInUsername' ] = $sessionDetails[ 'username' ];
			$data[ 'updated' ][ 'status' ] = true;
			$data[ 'updated' ][ 'message' ] = 'Successfully deleted';
			$data[ 'mainCategories' ] = $this->mainCategories;
			$data[ 'subCategories' ] = $this->subCategories;
			$data[ 'itemsAndCategories' ] = $this->itemsAndCategories;

			$this->load->view( 'admin/allItems', $data );

		}
		else {

			return false;
		
		}

	}

}

?>
