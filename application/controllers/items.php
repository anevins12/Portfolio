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
class Items extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('portfoliomodel');
		$this->load->helper('url');
		$this->load->library('image_lib');
	}

	public function index() {
		$this->setItems();
		$this->load->view('header');
		$this->load->view('front-end');
	}

	public function ux() {
		$this->setItems();
		$this->load->view('header');
		$this->load->view('ux');
	}

	public function other() {
		$this->setItems();
		$this->load->view('header');
		$this->load->view('other');
	}

	public function getItem() {
		echo $this->portfoliomodel->getPortfolioItem( 'Joe Tremlin Designs' );
	}

	public function setItems() {
		$items = simplexml_load_file( base_url() . 'assets/xml/portfolioitems.xml' );
		$this->portfoliomodel->resizeImages( $items );
		$this->portfoliomodel->setPortfolioItems( $items );
	}

	public function getCategoryItems ( $category ) {
		$this->setItems();
		$categoryItems = $this->portfoliomodel->getPortfolioItemsFromCategory( $category );
		echo $categoryItems;
	}

}
?>
