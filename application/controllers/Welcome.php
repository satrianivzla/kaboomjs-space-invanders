<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('anniversary_model');
		$this->load->helper('url');
	}

	public function index()
	{
		$data['anniversaries'] = $this->anniversary_model->get_all_anniversaries();
		$data['title'] = "Music Anniversaries"; // You can pass a title to the view

		// Basic check for debugging - will remove or refine later
		if (empty($data['anniversaries'])) {
			log_message('info', 'Welcome_controller: No anniversaries returned from model for the main page.');
			// Optionally, you could set a message for the view
			// $data['error_message'] = "Could not retrieve anniversary data at this time.";
		} else {
			log_message('info', 'Welcome_controller: Found ' . count($data['anniversaries']) . ' anniversaries.');
		}

		$this->load->view('welcome_message', $data);
	}
}
?>
