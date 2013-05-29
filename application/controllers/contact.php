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
		$this->form_validation->set_rules( 'name', 'name', 'required' );
		$this->form_validation->set_rules( 'email', 'email', 'required' );
		$this->form_validation->set_rules( 'msg', 'message', 'required' );

		$data['success'] = false;
		$data['bozo'] = false;
		$data['title'] = 'Contact Andrew Nevins'; 
		$this->load->view( 'header', $data );
		$this->load->view( 'contact', $data );

	}

	public function send() {

		$name = '';
		$email = '';
		$msg = '';
		extract( $_POST );

		$data[ 'errors' ] = array();
		$data[ 'success' ] = false;
		$data[ 'bozo' ] = false;

		if ( $name == 'Your name' || empty( $name ) ) {
			$data['errors'][] = "Your name is empty";
		}

		if ( $email == 'Your contact email' || empty( $email ) ) {
			$data['errors'][] = "Your contact email is empty";
		}

		if ( $msg == 'Your message' || empty( $msg ) ) {
			$data['errors'][] = "Your message is empty";
		}

		if ( empty( $data['errors'] ) ) {

			$send_email = 'andrew2.nevins@live.uwe.ac.uk';
			$subject = "$name has entered your contact form";
			$subject_ip = $this->input->ip_address();
			$message = " Name: $name \n Email: $email \n IP: $subject_ip \n Message: $msg";
			$badIPs = array('145.62.32.129','');

			if ( !in_array($subject_ip, $badIPs) ) {

				mail( $send_email, $subject, $message);
				$data[ 'success' ] = true;

			}

			else {

				$data[ 'success' ] = false;
				$data[ 'bozo' ] = true;
				mail( 'andrew2.nevins@live.uwe.ac.uk', 'Someone received your BOZO message', 'On your contact form, someone received your BOZO message for the IP of: ' . $subject_ip );
				
			}

		}

		$data['title'] = 'Message sent to Andrew Nevins';
		$this->load->view('header', $data);
		$this->load->view('contact', $data);

	}



}
