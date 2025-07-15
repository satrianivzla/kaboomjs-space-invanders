<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stat_model extends CI_Model {

    public function log_visitor($ip_hash, $page)
    {
        $today = date('Y-m-d');

        // This query attempts to insert a new record. If a record for the same
        // IP hash, page, and date already exists, it updates the visit_count.
        $sql = "INSERT INTO visitor_stats (ip_address_hash, page_visited, visit_date, visit_count)
                VALUES (?, ?, ?, 1)
                ON DUPLICATE KEY UPDATE visit_count = visit_count + 1";

        $this->db->query($sql, array($ip_hash, $page, $today));
    }

    public function get_daily_visits($days = 30)
    {
        $this->db->select('visit_date, COUNT(DISTINCT ip_address_hash) as unique_visits');
        $this->db->from('visitor_stats');
        $this->db->where('visit_date >=', date('Y-m-d', strtotime("-$days days")));
        $this->db->group_by('visit_date');
        $this->db->order_by('visit_date', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_top_pages($limit = 10)
    {
        $this->db->select('page_visited, COUNT(id) as total_visits');
        $this->db->from('visitor_stats');
        $this->db->group_by('page_visited');
        $this->db->order_by('total_visits', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }
}
