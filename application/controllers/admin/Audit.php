<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('audit_model');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            $this->session->set_flashdata('error', 'You must be an administrator to view this page.');
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['title'] = 'Audit Log';
        $data['logs'] = $this->audit_model->get_logs();

        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/audit/index', $data);
        $this->load->view('admin/common/footer');
    }
}
