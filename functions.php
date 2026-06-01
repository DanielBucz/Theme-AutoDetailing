<?php

if (!defined('ABSPATH')) {
    exit;
}

define('THEME_PATH', get_template_directory());
define('THEME_URI', get_template_directory_uri());

require_once THEME_PATH . '/inc/setup.php';
require_once THEME_PATH . '/inc/enqueue.php';

// 1
require_once THEME_PATH . '/inc/theme-support.php';

// 2
require_once THEME_PATH . '/inc/helpers.php';

// 3
require_once THEME_PATH . '/inc/template-tags.php';

// 4
require_once THEME_PATH . '/inc/seo.php';

// 5
require_once THEME_PATH . '/inc/cpt/realizacje.php';

//6
require_once THEME_PATH . '/inc/cpt/uslugi.php';

// 7
require_once THEME_PATH . '/inc/cpt/opinie.php';

// 8
require_once THEME_PATH . '/inc/taxonomies/realizacje-tax.php';

// 9
if (function_exists('acf_add_local_field_group')) {
    require_once THEME_PATH . '/inc/acf/fields-realizacje.php';
    require_once THEME_PATH . '/inc/acf/fields-home.php';
    require_once THEME_PATH . '/inc/acf/fields-options.php';
}