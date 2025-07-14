<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tags extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('tag_model');
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
        $this->form_validation->set_rules('name', 'Name', 'required|trim|is_unique[tags.name]');
        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            $slug = url_title($this->input->post('name'), 'dash', TRUE);
            $data = [
                'name' => $this->input->post('name'),
                'slug' => $slug
            ];
            if ($this->tag_model->create_tag($data)) {
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
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
        } else {
            $slug = url_title($this->input->post('name'), 'dash', TRUE);
            $data = [
                'name' => $this->input->post('name'),
                'slug' => $slug
            ];
            if ($this->tag_model->update_tag($id, $data)) {
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
        if ($this->tag_model->delete_tag($id)) {
            $this->session->set_flashdata('message', 'Tag deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Error deleting tag.');
        }
        redirect('admin/tags');
    }
}
