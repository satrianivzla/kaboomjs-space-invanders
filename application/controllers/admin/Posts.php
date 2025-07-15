<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load necessary models, libraries, helpers
        $this->load->model('post_model');
        $this->load->model('audit_model');
        $this->load->library('form_validation');
        // Autoloading should handle ion_auth, database, session, url, etc.

        // Protect this controller, only admin and members should be able to access it
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            $this->session->set_flashdata('error', 'You must be an administrator to view this page.');
            redirect('auth/login');
        }
    }

    /**
     * List all posts
     */
    public function index()
    {
        $data['title'] = 'Manage Posts';
        $data['posts'] = $this->post_model->get_all_posts();

        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/posts/index', $data);
        $this->load->view('admin/common/footer');
    }

    /**
     * Show the form for creating a new post
     */
    public function create()
    {
        $data['title'] = 'Add New Post';
        $this->load->model('category_model');
        $this->load->model('tag_model');
        $data['categories'] = $this->category_model->get_all_categories();
        $data['tags'] = $this->tag_model->get_all_tags();

        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/posts/form', $data);
        $this->load->view('admin/common/footer');
    }

    /**
     * Store a newly created post in storage.
     */
    public function store()
    {
        $this->form_validation->set_rules('title_en', 'English Title', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            $slug = url_title($this->input->post('title_en'), 'dash', TRUE);

            $post_data = [
                'author_id' => $this->ion_auth->user()->row()->id,
                'title_en' => $this->input->post('title_en'),
                'title_es' => $this->input->post('title_es'),
                'slug' => $slug,
                'content_en' => $this->input->post('content_en'),
                'content_es' => $this->input->post('content_es'),
                'seo_title_en' => $this->input->post('seo_title_en'),
                'seo_title_es' => $this->input->post('seo_title_es'),
                'seo_description_en' => $this->input->post('seo_description_en'),
                'seo_description_es' => $this->input->post('seo_description_es'),
                'status' => $this->input->post('status'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Handle file upload and WebP conversion
            if (!empty($_FILES['featured_image']['name'])) {
                $year = date('Y');
                $month = date('m');
                $day = date('d');
                $upload_path = "./uploads/images/{$year}/{$month}/{$day}/";
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, TRUE);
                }

                // Find the next available filename
                $i = 1;
                $base_filename = "{$year}-{$month}-{$day}";
                $new_filename = $base_filename;
                while (file_exists($upload_path . $new_filename . '.webp')) {
                    $new_filename = $base_filename . '-' . str_pad($i++, 4, '0', STR_PAD_LEFT);
                }

                $config['upload_path'] = $upload_path;
                $config['file_name'] = $new_filename; // Set the filename before upload
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('featured_image')) {
                    $upload_data = $this->upload->data();

                    // Configure image lib for WebP conversion
                    $this->load->library('image_lib');
                    $img_config['image_library'] = 'gd2';
                    $img_config['source_image'] = $upload_data['full_path'];
                    $img_config['new_image'] = $upload_path . $upload_data['raw_name'] . '.webp';
                    $img_config['create_thumb'] = FALSE;
                    $img_config['maintain_ratio'] = TRUE;
                    $img_config['quality'] = '80%';

                    $this->image_lib->initialize($img_config);

                    if ($this->image_lib->convert('webp')) {
                         $post_data['featured_image'] = $upload_data['raw_name'] . '.webp';
                         unlink($upload_data['full_path']); // Delete original
                    } else {
                         $this->session->set_flashdata('error', 'WebP conversion failed: ' . $this->image_lib->display_errors());
                         // Decide: use original or fail? For now, fail.
                         redirect('admin/posts/create');
                         return;
                    }
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->create();
                    return;
                }
            }

            $categories = $this->input->post('categories');
            $tags_string = $this->input->post('tags');
            $tags = !empty($tags_string) ? array_map('trim', explode(',', $tags_string)) : [];

            $post_id = $this->post_model->create_post($post_data, $categories, $tags);
            if ($post_id) {
                $this->audit_model->log_action('created_post', $post_id, 'Title: ' . $post_data['title_en']);
                $this->session->set_flashdata('message', 'Post created successfully.');
                redirect('admin/posts');
            } else {
                $this->session->set_flashdata('error', 'Error creating post.');
                $this->create();
            }
        }
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit($id)
    {
        $data['title'] = 'Edit Post';
        $this->load->model('category_model');
        $this->load->model('tag_model');

        $data['post'] = $this->post_model->get_post($id);
        if (empty($data['post'])) {
            show_404();
        }

        $data['categories'] = $this->category_model->get_all_categories();
        $data['tags'] = $this->tag_model->get_all_tags();
        $data['post_categories'] = $this->post_model->get_post_categories($id);
        $data['post_tags'] = $this->post_model->get_post_tags($id);

        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/posts/form', $data);
        $this->load->view('admin/common/footer');
    }

    /**
     * Update the specified post in storage.
     */
    public function update($id)
    {
        $this->form_validation->set_rules('title_en', 'English Title', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
        } else {
            $slug = url_title($this->input->post('title_en'), 'dash', TRUE);

            $post_data = [
                'title_en' => $this->input->post('title_en'),
                'title_es' => $this->input->post('title_es'),
                'slug' => $slug,
                'content_en' => $this->input->post('content_en'),
                'content_es' => $this->input->post('content_es'),
                'seo_title_en' => $this->input->post('seo_title_en'),
                'seo_title_es' => $this->input->post('seo_title_es'),
                'seo_description_en' => $this->input->post('seo_description_en'),
                'seo_description_es' => $this->input->post('seo_description_es'),
                'status' => $this->input->post('status'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Handle file upload
            if (!empty($_FILES['featured_image']['name'])) {
                // Same upload and WebP conversion logic as store()
                $year = date('Y');
                $month = date('m');
                $day = date('d');
                $upload_path = "./uploads/images/{$year}/{$month}/{$day}/";
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, TRUE);
                }

                $i = 1;
                $base_filename = "{$year}-{$month}-{$day}";
                $new_filename = $base_filename;
                while (file_exists($upload_path . $new_filename . '.webp')) {
                    $new_filename = $base_filename . '-' . str_pad($i++, 4, '0', STR_PAD_LEFT);
                }

                $config['upload_path'] = $upload_path;
                $config['file_name'] = $new_filename;
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('featured_image')) {
                    $upload_data = $this->upload->data();

                    $this->load->library('image_lib');
                    $img_config['image_library'] = 'gd2';
                    $img_config['source_image'] = $upload_data['full_path'];
                    $img_config['new_image'] = $upload_path . $upload_data['raw_name'] . '.webp';
                    $img_config['create_thumb'] = FALSE;
                    $img_config['maintain_ratio'] = TRUE;
                    $img_config['quality'] = '80%';

                    $this->image_lib->initialize($img_config);

                    if ($this->image_lib->convert('webp')) {
                         $post_data['featured_image'] = $upload_data['raw_name'] . '.webp';
                         unlink($upload_data['full_path']);
                    } else {
                         $this->session->set_flashdata('error', 'WebP conversion failed: ' . $this->image_lib->display_errors());
                         redirect('admin/posts/edit/' . $id);
                         return;
                    }
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->edit($id);
                    return;
                }
            }

            $categories = $this->input->post('categories');
            $tags_string = $this->input->post('tags');
            $tags = !empty($tags_string) ? array_map('trim', explode(',', $tags_string)) : [];

            if ($this->post_model->update_post($id, $post_data, $categories, $tags)) {
                $this->audit_model->log_action('updated_post', $id, 'Title: ' . $post_data['title_en']);
                $this->session->set_flashdata('message', 'Post updated successfully.');
                redirect('admin/posts');
            } else {
                $this->session->set_flashdata('error', 'Error updating post.');
                $this->edit($id);
            }
        }
    }

    /**
     * Remove the specified post from storage.
     */
    public function delete($id)
    {
        $post = $this->post_model->get_post($id); // Get post details before deleting
        if ($this->post_model->delete_post($id)) {
            $this->audit_model->log_action('deleted_post', $id, 'Title: ' . $post['title_en']);
            $this->session->set_flashdata('message', 'Post deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Error deleting post.');
        }
        redirect('admin/posts');
    }
}
