<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('post_model');
    }

    public function view($slug = NULL)
    {
        $data['post'] = $this->post_model->get_post_by_slug($slug);

        if (empty($data['post']))
        {
            show_404();
        }

        $data['title'] = $data['post']['seo_title'] ? $data['post']['seo_title'] : $data['post']['title'];

        if ($this->ion_auth->logged_in())
		{
			$data['user'] = $this->ion_auth->user()->row();
		}

        $this->load->view('common/header', $data);
        $this->load->view('posts/view', $data);
        $this->load->view('common/footer');
    }
}
