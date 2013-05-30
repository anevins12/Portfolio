<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Categoriesmodel extends CI_Model {

	private $categories = array();

	public function __construct() {

		parent::__construct();

		$this->load->helper('url');
		$categories = simplexml_load_file( base_url() . "assets/xml/categories.xml" );

		foreach ( $categories as $k => $v ) {
			$this->categories[ ( string ) $v->attributes() ] = ( string ) $v;
		}

	}

	public function getCategoryName( $id ) {

		foreach ( $this->categories as $k => $v ) {

			if ( $id == $k ) {
				return $v;
			}

		}

	}

	public function getCategories( $simpleXML = false) {

		//Because you can't assign arrays to properties of a SimpleXMLObject,
		//You need to first convert that array to a SimpleXMLObject.
		//http://stackoverflow.com/questions/1397036/how-to-convert-array-to-simplexml
		if ( $simpleXML ) {

			$xml = new SimpleXMLElement('<root/>');
			array_walk_recursive($this->categories, array ($xml, 'addChild'));

			return $xml;

		}

		return $this->categories;
	}
}

?>
