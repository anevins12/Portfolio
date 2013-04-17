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
		$this->load->view('homepage');
	}

	public function getItems() {
		$this->setItems();
		echo $this->portfoliomodel->getPortfolioItems();
	}

	public function getItem() {
		echo $this->portfoliomodel->getPortfolioItem( 'Joe Tremlin Designs' );
	}

	public function setItems() {
		$items = simplexml_load_file( base_url() . 'assets/xml/portfolioitems.xml' );
		$config[ 'image_library' ] = 'gd2';
		$config[ 'create_thumb' ] = TRUE;
		$config[ 'maintain_ratio' ] = TRUE;
		$config[ 'width' ]	 = 252;
		$config[ 'height' ]	= 243;

		foreach ( $items as $item ) {

			$image_path = "assets/i/items/$item->image_url";


			if ( isset( $item->image_url ) ) {

				$config[ 'source_image' ] =  $image_path;
				$this->image_lib->initialize( $config );

				if ( !$this->image_lib->resize() ) {
					echo $this->image_lib->display_errors();
				}

				$name = str_replace('.png', '_thumb.png', $item->image_url);

				$item->thumb_url = base_url() . 'assets/i/items/' . $name;

			}

		}

		$this->portfoliomodel->setPortfolioItems($items);
	}

	public function getCategoryItems ( $category ) {

		$categoryItems = $this->portfoliomodel->getPortfolioItemsFromCategory( $category );
		echo $categoryItems;

	}

}
?>
