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
		// Helpers and libraries are now autoloaded, so we can remove manual loads here
		// if they were present. 'ion_auth' library, 'url' and 'form' helpers are key.
	}

	public function index()
	{
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else
		{
			// User is logged in, proceed to show the anniversaries
			$data['anniversaries'] = $this->anniversary_model->get_all_anniversaries();
			$data['title'] = "Music Anniversaries";

			// Get user info to display in the view
			$data['user'] = $this->ion_auth->user()->row();

			if (empty($data['anniversaries'])) {
				log_message('info', 'Welcome_controller: No anniversaries returned from model for the main page.');
			} else {
				log_message('info', 'Welcome_controller: Found ' . count($data['anniversaries']) . ' anniversaries.');
			}

			$this->load->view('welcome_message', $data);
		}
	}
}
?>
