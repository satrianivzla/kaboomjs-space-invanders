<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ads extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ad_model'); // We will create this model
        $this->load->library('form_validation');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            $this->session->set_flashdata('error', 'You must be an administrator to view this page.');
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['title'] = 'Manage Advertisements';
        $data['ads'] = $this->ad_model->get_all_ads();

        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/ads/index', $data);
        $this->load->view('admin/common/footer');
    }

    public function create()
    {
        $data['title'] = 'Add New Advertisement';
        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/ads/form', $data);
        $this->load->view('admin/common/footer');
    }

    public function store()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('location', 'Location', 'required|trim');
        $this->form_validation->set_rules('ad_code', 'Ad Code', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'location' => $this->input->post('location'),
                'ad_code' => $this->input->post('ad_code'),
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s')
            ];
            if ($this->ad_model->create_ad($data)) {
                $this->session->set_flashdata('message', 'Advertisement created successfully.');
                redirect('admin/ads');
            } else {
                $this->session->set_flashdata('error', 'Error creating advertisement.');
                $this->create();
            }
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Advertisement';
        $data['ad'] = $this->ad_model->get_ad($id);
        if (empty($data['ad'])) {
            show_404();
        }
        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/ads/form', $data);
        $this->load->view('admin/common/footer');
    }

    public function update($id)
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('location', 'Location', 'required|trim');
        $this->form_validation->set_rules('ad_code', 'Ad Code', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'location' => $this->input->post('location'),
                'ad_code' => $this->input->post('ad_code'),
                'is_active' => $this->input->post('is_active') ? 1 : 0
            ];
            if ($this->ad_model->update_ad($id, $data)) {
                $this->session->set_flashdata('message', 'Advertisement updated successfully.');
                redirect('admin/ads');
            } else {
                $this->session->set_flashdata('error', 'Error updating advertisement.');
                $this->edit($id);
            }
        }
    }

    public function delete($id)
    {
        if ($this->ad_model->delete_ad($id)) {
            $this->session->set_flashdata('message', 'Advertisement deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Error deleting advertisement.');
        }
        redirect('admin/ads');
    }
}
