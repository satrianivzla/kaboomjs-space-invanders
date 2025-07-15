<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag_model extends CI_Model {

    public function get_all_tags() {
        $query = $this->db->get('tags');
        return $query->result_array();
    }

    public function create_tag($data) {
        $this->db->insert('tags', $data);
        return $this->db->insert_id();
    }

    public function get_tag($id) {
        $query = $this->db->get_where('tags', ['id' => $id]);
        return $query->row_array();
    }

    public function update_tag($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tags', $data);
    }

    public function delete_tag($id) {
        return $this->db->delete('tags', ['id' => $id]);
    }
}
