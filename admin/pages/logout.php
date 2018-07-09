<?php
	$_SESSION['admin_logged'] = false;
	Util::Redirect($config['adminurl']);
	die();
?>