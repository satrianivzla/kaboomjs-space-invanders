<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('display_ad'))
{
    function display_ad($location)
    {
        // Get a reference to the controller object
        $CI =& get_instance();

        // Load the ad model
        $CI->load->model('ad_model');

        // Get an active ad for the specified location
        $ad = $CI->ad_model->get_ad_by_location($location);

        if ($ad) {
            // Return the ad code to be displayed in the view
            return $ad['ad_code'];
        }

        // Return an empty string or a placeholder if no ad is found
        return '';
    }
}
