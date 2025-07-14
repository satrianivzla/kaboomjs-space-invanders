<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ad_model extends CI_Model {

    public function get_all_ads() {
        $query = $this->db->get('advertisements');
        return $query->result_array();
    }

    public function create_ad($data) {
        return $this->db->insert('advertisements', $data);
    }

    public function get_ad($id) {
        $query = $this->db->get_where('advertisements', ['id' => $id]);
        return $query->row_array();
    }

    public function update_ad($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('advertisements', $data);
    }

    public function delete_ad($id) {
        return $this->db->delete('advertisements', ['id' => $id]);
    }

    public function get_ad_by_location($location) {
        $this->db->where('location', $location);
        $this->db->where('is_active', 1);
        $this->db->order_by('RAND()');
        $this->db->limit(1);
        $query = $this->db->get('advertisements');
        return $query->row_array();
    }
}
