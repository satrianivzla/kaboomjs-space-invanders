<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visitor_stats_hook {

    public function log_visitor()
    {
        $CI =& get_instance();

        // Don't log requests to the admin panel or for assets
        if ($CI->uri->segment(1) == 'admin' || $CI->uri->segment(1) == 'assets') {
            return;
        }

        $CI->load->model('stat_model');

        $ip_address = $CI->input->ip_address();
        $ip_address_hash = hash('sha256', $ip_address); // Hash for privacy
        $page_visited = uri_string();
        if(empty($page_visited)) {
            $page_visited = '/';
        }

        $CI->stat_model->log_visitor($ip_address_hash, $page_visited);
    }
}
