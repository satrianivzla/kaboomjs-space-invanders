<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $language = 'en'; // Default language

    public function __construct()
    {
        parent::__construct();

        // Get language from URL segment
        $lang_segment = $this->uri->segment(1);

        // Supported languages
        $supported_langs = ['en', 'es'];

        if (in_array($lang_segment, $supported_langs)) {
            $this->language = $lang_segment;
        }

        // Set the language for the profiler and other CI components
        $this->config->set_item('language', $this->language == 'es' ? 'spanish' : 'english');

        // Load language files if needed (e.g., for form validation errors)
        // Note: Ion Auth handles its own language loading.
        // $this->lang->load('site', $this->language == 'es' ? 'spanish' : 'english');

        // Make the language available to all views
        $this->load->vars(['current_lang' => $this->language]);
    }
}
