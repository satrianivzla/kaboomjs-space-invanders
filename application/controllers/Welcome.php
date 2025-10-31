<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

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
		// The main page is now public, no login required.
		// We will show a list of posts from our database.
		$this->load->model('post_model');

		$data['title'] = "JulesBlog - Home";
		$data['posts'] = $this->post_model->get_published_posts(); // We will create this method

		// We still need user data for the navbar (Login/Logout button)
		if ($this->ion_auth->logged_in())
		{
			$data['user'] = $this->ion_auth->user()->row();
		}

		$this->load->view('welcome_message', $data);
	}
}
?>
