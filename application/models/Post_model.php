<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Ensure database is loaded
    }

    /**
     * Get all posts from the database.
     * Joins with the users table to get the author's name.
     *
     * @return array
     */
    public function get_all_posts()
    {
        $this->db->select('posts.*, users.first_name, users.last_name');
        $this->db->from('posts');
        $this->db->join('users', 'users.id = posts.author_id');
        $this->db->order_by('posts.created_at', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function create_post($data, $categories, $tags)
    {
        $this->db->trans_start();

        // Insert post data
        $this->db->insert('posts', $data);
        $post_id = $this->db->insert_id();

        if ($post_id) {
            // Insert categories
        if (!empty($categories)) {
            $cat_batch = [];
            foreach ($categories as $category_id) {
                $cat_batch[] = [
                    'post_id' => $post_id,
                    'category_id' => $category_id
                ];
            }
            $this->db->insert_batch('post_categories', $cat_batch);
        }

        // Handle tags
        if (!empty($tags)) {
            $tag_batch = [];
            foreach ($tags as $tag_name) {
                // Check if tag exists
                $tag = $this->db->get_where('tags', ['name' => $tag_name])->row_array();
                if ($tag) {
                    $tag_id = $tag['id'];
                } else {
                    // Create new tag if it doesn't exist
                    $this->db->insert('tags', ['name' => $tag_name, 'slug' => url_title($tag_name, 'dash', TRUE)]);
                    $tag_id = $this->db->insert_id();
                }
                $tag_batch[] = [
                    'post_id' => $post_id,
                    'tag_id' => $tag_id
                ];
            }
            $this->db->insert_batch('post_tags', $tag_batch);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function get_post($id)
    {
        $query = $this->db->get_where('posts', ['id' => $id]);
        return $query->row_array();
    }

    public function get_post_categories($post_id)
    {
        $this->db->select('category_id');
        $query = $this->db->get_where('post_categories', ['post_id' => $post_id]);
        return array_column($query->result_array(), 'category_id');
    }

    public function get_post_tags($post_id)
    {
        $this->db->select('tags.name');
        $this->db->from('post_tags');
        $this->db->join('tags', 'tags.id = post_tags.tag_id');
        $this->db->where('post_tags.post_id', $post_id);
        $query = $this->db->get();
        return array_column($query->result_array(), 'name');
    }

    public function update_post($id, $data, $categories, $tags)
    {
        $this->db->trans_start();

        // Update post data
        $this->db->where('id', $id);
        $this->db->update('posts', $data);

        // Update categories
        $this->db->delete('post_categories', ['post_id' => $id]);
        if (!empty($categories)) {
            $cat_batch = [];
            foreach ($categories as $category_id) {
                $cat_batch[] = [
                    'post_id' => $id,
                    'category_id' => $category_id
                ];
            }
            $this->db->insert_batch('post_categories', $cat_batch);
        }

        // Update tags
        $this->db->delete('post_tags', ['post_id' => $id]);
        if (!empty($tags)) {
            $tag_batch = [];
            foreach ($tags as $tag_name) {
                $tag = $this->db->get_where('tags', ['name' => $tag_name])->row_array();
                if ($tag) {
                    $tag_id = $tag['id'];
                } else {
                    $this->db->insert('tags', ['name' => $tag_name, 'slug' => url_title($tag_name, 'dash', TRUE)]);
                    $tag_id = $this->db->insert_id();
                }
                $tag_batch[] = [
                    'post_id' => $id,
                    'tag_id' => $tag_id
                ];
            }
            $this->db->insert_batch('post_tags', $tag_batch);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function delete_post($id)
    {
        $this->db->trans_start();
        // Get image to delete it from server
        $post = $this->get_post($id);
        if ($post && $post['featured_image']) {
            $image_path = './uploads/images/' . $post['featured_image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        $this->db->delete('posts', ['id' => $id]);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_published_posts()
    {
        $this->db->select('posts.*, users.first_name, users.last_name');
        $this->db->from('posts');
        $this->db->join('users', 'users.id = posts.author_id');
        $this->db->where('posts.status', 'published');
        $this->db->order_by('posts.created_at', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_post_by_slug($slug)
    {
        $this->db->select('posts.*, users.first_name, users.last_name');
        $this->db->from('posts');
        $this->db->join('users', 'users.id = posts.author_id');
        $this->db->where('posts.slug', $slug);
        $this->db->where('posts.status', 'published');
        $query = $this->db->get();
        return $query->row_array();
    }
}
