<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_model extends CI_Model {

    public function log_action($action, $target_id = NULL, $details = NULL)
    {
        $user_id = ($this->ion_auth->logged_in()) ? $this->ion_auth->user()->row()->id : NULL;

        $data = [
            'user_id' => $user_id,
            'action' => $action,
            'target_id' => $target_id,
            'details' => $details,
            'created_at' => date('Y-m-d H:i:s')
        ];

        return $this->db->insert('audit_log', $data);
    }

    public function get_logs()
    {
        $this->db->select('audit_log.*, users.username');
        $this->db->from('audit_log');
        $this->db->join('users', 'users.id = audit_log.user_id', 'left');
        $this->db->order_by('audit_log.created_at', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
}
