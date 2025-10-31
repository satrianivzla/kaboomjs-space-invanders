<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DailyEntry extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('post_model');
        $this->load->model('category_model');
        $this->load->library('form_validation');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            $this->session->set_flashdata('error', 'You must be an administrator to view this page.');
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['title'] = 'Create Daily Entries from Text';
        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/daily_entry/form', $data); // We'll create this view next
        $this->load->view('admin/common/footer');
    }

    public function store()
    {
        $this->form_validation->set_rules('daily_text', 'Daily Text', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->index();
        } else {
            $text = $this->input->post('daily_text');
            $lines = explode("\n", $text);

            $categories_map = $this->get_categories_map();
            $current_category_id = null;
            $posts_created = 0;

            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;

                // Check if the line is a category header (e.g., "Nacimientos: (18)")
                $is_category = false;
                foreach ($categories_map as $cat_name => $cat_id) {
                    if (strpos(strtolower($line), strtolower($cat_name)) !== false) {
                        $current_category_id = $cat_id;
                        $is_category = true;
                        break;
                    }
                }

                if ($is_category || strpos($line, '****************') !== false) {
                    continue; // Skip category headers and separator lines
                }

                // This is an entry, create a post for it
                if ($current_category_id) {
                    $title = $this->generate_title_from_line($line);
                    $slug = url_title($title, 'dash', TRUE) . '-' . time(); // Add timestamp for uniqueness

                    $post_data = [
                        'author_id' => $this->ion_auth->user()->row()->id,
                        'title' => $title,
                        'slug' => $slug,
                        'content' => $line,
                        'status' => 'published',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    if ($this->post_model->create_post($post_data, [$current_category_id], [])) {
                        $posts_created++;
                    }
                }
            }

            $this->session->set_flashdata('message', "Successfully created {$posts_created} posts from the provided text.");
            redirect('admin/posts');
        }
    }

    private function get_categories_map()
    {
        $categories = $this->category_model->get_all_categories();
        $map = [];
        foreach ($categories as $category) {
            $map[$category['name']] = $category['id'];
        }
        return $map;
    }

    private function generate_title_from_line($line)
    {
        // Simple title generation: take the first 10 words
        return word_limiter($line, 10);
    }
}
