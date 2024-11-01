<?php

if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') && !current_user_can('delete_plugins'))
    exit();
    
require_once('viscats.class.php');
$viscats = new viscats_class();

if (is_dir($viscats->paths['uploads']))
	$viscats->rmdirr($viscats->paths['uploads']);
delete_option($viscats->plugin['short'].'_version');
delete_option($viscats->plugin['short'].'_settings');


?>