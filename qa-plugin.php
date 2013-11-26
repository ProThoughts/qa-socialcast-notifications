<?php

/*
	Plugin Name: Socialcast Notifications
	Plugin URI: https://github.com/luxbet/qa-socialcast-notifications
	Plugin Description: Sends Socialcast notification for new questions.
	Plugin Version: 0.1
	Plugin Date: 2013-11-26
	Plugin Author: Wei Feng
	Plugin Author URI: https://github.com/windix
	Plugin License: The BSD 3 clause License License
	Plugin Minimum Question2Answer Version: 1.5
	Plugin Update Check URI: 
*/

if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
	header('Location: ../../');
	exit;
}

qa_register_plugin_module('event', 'qa-socialcast-notifications-event.php', 'qa_socicalcast_notifications_event', 'Socialcast Notifications');
