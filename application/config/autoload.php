<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which systems should be loaded by default.
|
*/

// -------------------------------------------------------------------
//  Auto-load Packages
// -------------------------------------------------------------------
$autoload['packages'] = array();


// -------------------------------------------------------------------
//  Auto-load Libraries
// -------------------------------------------------------------------
// Added 'database', 'session', and 'ion_auth' for authentication.
$autoload['libraries'] = array('database', 'session', 'form_validation', 'ion_auth');


// -------------------------------------------------------------------
//  Auto-load Drivers
// -------------------------------------------------------------------
$autoload['drivers'] = array();


// -------------------------------------------------------------------
//  Auto-load Helper Files
// -------------------------------------------------------------------
// Added 'url' for redirects and links.
$autoload['helper'] = array('url', 'form', 'html', 'text', 'advertisement');


// -------------------------------------------------------------------
//  Auto-load Config files
// -------------------------------------------------------------------
// Ion Auth config is loaded by its library, but if we had others, they'd go here.
$autoload['config'] = array();


// -------------------------------------------------------------------
//  Auto-load Language files
// -------------------------------------------------------------------
// Ion Auth language files are loaded by its library.
$autoload['language'] = array();


// -------------------------------------------------------------------
//  Auto-load Models
// -------------------------------------------------------------------
// Ion Auth model is loaded by its library.
$autoload['model'] = array();
