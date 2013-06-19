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
class Usersmodel extends CI_Model {

	private $table;
	private $tablePath;
	private $users;

	public function __construct() {

		parent::__construct();

		$this->load->helper('url');
		$this->tablePath = "assets/xml/users.xml";
		$this->table = simplexml_load_file( realpath( $this->tablePath ) );

		foreach ( $this->table->user as $user ) {
			$this->users[] = $user;
		}

	}

	function getUser( $id = false ) {

		if ( $id ) {

			foreach ( $this->users as $k => $v ) {

				//Do the functionality to get a user by id

				return $something;

			}

		}
		
		return $this->users[ 0 ];

	}

	public function validate() {

		$user = $this->usersmodel->getUser();

		$username = $this->input->post( 'username' );
		$password = $this->input->post( 'password' );

		if ( isset( $username ) && isset( $password ) ) {

			if ( $this->phpass->check( $password, $user->password ) && $username == $user->name ) {

				$userData = array(
				   'username'  => $username,
				   'logged_in' => true
			    );

				$this->session->set_userdata($userData);
				
				return true;

			}
			
		}

		return false;

	}

}
?>