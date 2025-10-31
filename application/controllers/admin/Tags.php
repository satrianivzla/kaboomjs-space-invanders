<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tags extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('tag_model');
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
        $data['title'] = 'Manage Tags';
        $data['tags'] = $this->tag_model->get_all_tags();

        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/tags/index', $data);
        $this->load->view('admin/common/footer');
    }

    public function create()
    {
        $data['title'] = 'Add New Tag';
        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/tags/form', $data);
        $this->load->view('admin/common/footer');
    }

    public function store()
    {
        $this->form_validation->set_rules('name_en', 'English Name', 'required|trim|is_unique[tags.name_en]');
        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            $slug = url_title($this->input->post('name_en'), 'dash', TRUE);
            $data = [
                'name_en' => $this->input->post('name_en'),
                'name_es' => $this->input->post('name_es'),
                'slug' => $slug
            ];
            $tag_id = $this->tag_model->create_tag($data);
            if ($tag_id) {
                $this->audit_model->log_action('created_tag', $tag_id, 'Name: ' . $data['name_en']);
                $this->session->set_flashdata('message', 'Tag created successfully.');
                redirect('admin/tags');
            } else {
                $this->session->set_flashdata('error', 'Error creating tag.');
                $this->create();
            }
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Tag';
        $data['tag'] = $this->tag_model->get_tag($id);
        if (empty($data['tag'])) {
            show_404();
        }
        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/tags/form', $data);
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
            if ($this->tag_model->update_tag($id, $data)) {
                $this->audit_model->log_action('updated_tag', $id, 'Name: ' . $data['name_en']);
                $this->session->set_flashdata('message', 'Tag updated successfully.');
                redirect('admin/tags');
            } else {
                $this->session->set_flashdata('error', 'Error updating tag.');
                $this->edit($id);
            }
        }
    }

    public function delete($id)
    {
        $tag = $this->tag_model->get_tag($id);
        if ($this->tag_model->delete_tag($id)) {
            $this->audit_model->log_action('deleted_tag', $id, 'Name: ' . $tag['name_en']);
            $this->session->set_flashdata('message', 'Tag deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Error deleting tag.');
        }
        redirect('admin/tags');
    }
}
