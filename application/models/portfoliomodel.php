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
    }

	public function setPortfolioItems( $items ) {

		foreach ( $items as $item ) {
			$this->portfolioItems[] = $item;
		}

	}

	public function getPortfolioItems() {

	   return json_encode( $this->portfolioItems );
		
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

}
?>
