<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('stat_model');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            $this->session->set_flashdata('error', 'You must be an administrator to view this page.');
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['title'] = 'Dashboard';

        // Get stats for the charts
        $data['daily_visits'] = $this->stat_model->get_daily_visits(30);
        $data['top_pages'] = $this->stat_model->get_top_pages(10);

        // Prepare data for Chart.js
        $data['chart_labels'] = json_encode(array_column($data['daily_visits'], 'visit_date'));
        $data['chart_data'] = json_encode(array_column($data['daily_visits'], 'unique_visits'));

        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/dashboard/index', $data);
        $this->load->view('admin/common/footer');
    }
}
