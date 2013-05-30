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
	private $category = array();

	public function __construct() {
		parent::__construct();
		$this->load->model('portfoliomodel');
		$this->load->model('categoriesmodel');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->items = $this->portfoliomodel->getPortfolioItems();
		$this->category = $this->categoriesmodel->getCategories();
	}

	public function index() {
		$data['items'] = $this->items;
		$data['category'] = $this->category;
		$this->load->view( 'admin/editItems', $data );
	}

	private function loadFile( $file ) {
		$xml = $this->portfoliomodel->checkFile( $file );
		return $xml;
	}

	public function updateItem() {

		extract( $_POST );
		htmlentities($title);
		htmlentities($description);
		htmlentities($url);

		$data['items'] = $this->items;
		$data['category'] = $this->category;
		
		if ( $this->portfoliomodel->updateItem( $_POST ) ) { 
			$this->load->view( 'admin/editItems', $data );
		}


	}

}

?>
