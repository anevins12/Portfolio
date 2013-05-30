<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Categoriesmodel extends CI_Model {

	private $categories;

	public function __construct() {

		parent::__construct();

		$this->load->helper('url');
		$categories = simplexml_load_file( base_url() . "assets/xml/categories.xml" );

		foreach ( $categories->category as $k => $v ) {
			$this->categories[] = array( $k => $v );
		}
		
	}

	public function getCategoryName( $id ) {

		foreach ( $this->categories as $k => $v ) {

			if ( $id == $k ) {
				return $v;
			}

		}

	}

	public function getCategories( $sub = false ) {

		foreach ( $this->categories as $category ) {

			$attributes = $category['category']->attributes();

			if ( empty( $attributes->parent ) ) {
				$mainCategories[ (string) $attributes->id ] = (string) $attributes->name;
			}
			else { 
				$subCategories[] = array( 'id' => (string) $attributes->id,
										  'name' => (string) $attributes->name,
										  'parentCategory' => (string) $attributes->parent
										);
			}

		}

		if ( $sub ) {
			return $subCategories;
		}
		
		return $mainCategories;
		
	}


}

?>
