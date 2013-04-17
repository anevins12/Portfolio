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
class Contact extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
	}

	public function index() {
		$this->form_validation->set_rules('name', 'name', 'required');
		$this->form_validation->set_rules('email', 'email', 'required');
		$this->form_validation->set_rules('msg', 'message', 'required');

		$this->load->view('header');
		$this->load->view('contact');
	}

	public function send() {
		$name = '';
		$email = '';
		$msg = '';
		extract($_POST);

		$data['errors'] = array();

		if ( $name == 'Your name' || empty( $name ) ) {
			$data['errors'][] = "Your name is empty";
		}

		if ( $email == 'Your contact email' || empty( $email ) ) {
			$data['errors'][] = "Your contact email is empty";
		}

		if ( $msg == 'Your message' || empty( $msg ) ) {
			$data['errors'][] = "Your message is empty";
		}

		$this->load->view('header');
		$this->load->view('contact', $data);
	}

}
