<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

    public function get_all_categories() {
        $query = $this->db->get('categories');
        return $query->result_array();
    }

    public function create_category($data) {
        $this->db->insert('categories', $data);
        return $this->db->insert_id();
    }

    public function get_category($id) {
        $query = $this->db->get_where('categories', ['id' => $id]);
        return $query->row_array();
    }

    public function update_category($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('categories', $data);
    }

    public function delete_category($id) {
        return $this->db->delete('categories', ['id' => $id]);
    }
}
