<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('post_model');
        $this->load->model('category_model');
        $this->load->model('tag_model');
        $this->load->helper('url');
    }

    public function index()
    {
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view('sitemap/index');
    }

    public function posts()
    {
        $data['posts'] = $this->post_model->get_all_posts(); // Get all, regardless of status for the sitemap
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view('sitemap/posts', $data);
    }

    public function categories()
    {
        $data['categories'] = $this->category_model->get_all_categories();
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view('sitemap/categories', $data);
    }

    public function tags()
    {
        $data['tags'] = $this->tag_model->get_all_tags();
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view('sitemap/tags', $data);
    }

    public function images()
    {
        $this->load->helper('directory');
        $map = directory_map('./uploads/images/', 1);
        $data['map'] = $map;
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view('sitemap/images', $data);
    }
}
