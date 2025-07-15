<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
        $this->load->model('audit_model');
        $this->load->library('form_validation');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            $this->session->set_flashdata('error', 'You must be an administrator to view this page.');
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['title'] = 'Manage Categories';
        $data['categories'] = $this->category_model->get_all_categories();

        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/categories/index', $data);
        $this->load->view('admin/common/footer');
    }

    public function create()
    {
        $data['title'] = 'Add New Category';
        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/categories/form', $data);
        $this->load->view('admin/common/footer');
    }

    public function store()
    {
        $this->form_validation->set_rules('name_en', 'English Name', 'required|trim|is_unique[categories.name_en]');
        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            $slug = url_title($this->input->post('name_en'), 'dash', TRUE);
            $data = [
                'name_en' => $this->input->post('name_en'),
                'name_es' => $this->input->post('name_es'),
                'slug' => $slug
            ];
            $category_id = $this->category_model->create_category($data);
            if ($category_id) {
                $this->audit_model->log_action('created_category', $category_id, 'Name: ' . $data['name_en']);
                $this->session->set_flashdata('message', 'Category created successfully.');
                redirect('admin/categories');
            } else {
                $this->session->set_flashdata('error', 'Error creating category.');
                $this->create();
            }
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Category';
        $data['category'] = $this->category_model->get_category($id);
        if (empty($data['category'])) {
            show_404();
        }
        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/categories/form', $data);
        $this->load->view('admin/common/footer');
    }

    public function update($id)
    {
        $this->form_validation->set_rules('name_en', 'English Name', 'required|trim');
        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
        } else {
            $slug = url_title($this->input->post('name_en'), 'dash', TRUE);
            $data = [
                'name_en' => $this->input->post('name_en'),
                'name_es' => $this->input->post('name_es'),
                'slug' => $slug
            ];
            if ($this->category_model->update_category($id, $data)) {
                $this->audit_model->log_action('updated_category', $id, 'Name: ' . $data['name_en']);
                $this->session->set_flashdata('message', 'Category updated successfully.');
                redirect('admin/categories');
            } else {
                $this->session->set_flashdata('error', 'Error updating category.');
                $this->edit($id);
            }
        }
    }

    public function delete($id)
    {
        $category = $this->category_model->get_category($id);
        if ($this->category_model->delete_category($id)) {
            $this->audit_model->log_action('deleted_category', $id, 'Name: ' . $category['name_en']);
            $this->session->set_flashdata('message', 'Category deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Error deleting category.');
        }
        redirect('admin/categories');
    }
}
