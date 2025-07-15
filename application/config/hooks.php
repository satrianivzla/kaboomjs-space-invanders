<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/userguide3/general/hooks.html
|
*/

$hook['post_controller'][] = array(
    'class'    => 'Visitor_stats_hook',
    'function' => 'log_visitor',
    'filename' => 'Visitor_stats_hook.php',
    'filepath' => 'hooks'
);
