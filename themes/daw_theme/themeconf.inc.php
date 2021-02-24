<?php
/*
Theme Name: DAW Theme
Version: 1.0.0
Description: 
Theme URI:
Author: 
Author URI: 
*/
require_once(PHPWG_THEMES_PATH . 'daw_theme/include/themecontroller.php');
require_once(PHPWG_THEMES_PATH . 'daw_theme/include/config.php');

$themeconf = array(
    'name' => 'daw_theme',
    'parent' => 'default',
    'load_parent_css' => false,
    'load_parent_local_head' => true,
    'local_head' => 'local_head.tpl',
    'url' => ''
);

//debug
//$conf['template_combine_files'] = false;

// always show metadata initially
pwg_set_session_var('show_metadata', true);

// register video files
$video_ext = array('mp4','m4v');
$conf['file_ext'] = array_merge ($conf['file_ext'], $video_ext, array_map('strtoupper', $video_ext));

$controller = new \DawTheme\ThemeController();
$controller->init();
