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

	private $items = array();

	public function __construct() {
		parent::__construct();
		$this->load->model('portfoliomodel');
		$this->load->helper('url');
		$this->load->library('image_lib');
		$this->items = $this->portfoliomodel->getPortfolioItems();
	}

	public function index() {
		$data['title'] = 'Front-End Developer Andrew Nevins';
		$this->load->view('header',  $data);
		$this->load->view('front-end');
	}

	public function ux() {
		$data['title'] = 'User Experience work from Andrew Nevins';
		$this->load->view('header', $data);
		$this->load->view('ux');
	}

	public function other() {
		$data['title'] = 'Other work from Andrew Nevins';
		$this->load->view('header', $data);
		$this->load->view('other');
	}

	public function getItem() {
		echo $this->portfoliomodel->getPortfolioItem( 'Joe Tremlin Designs' );
	}

	public function resizeImages() {
		$this->portfoliomodel->resizeImages( $this->items );
	}

	public function getCategoryItems ( $category ) {
		$this->resizeImages();
		$categoryItems = $this->portfoliomodel->getPortfolioItemsFromCategory( $category );
		echo $categoryItems;
	}

}
?>
