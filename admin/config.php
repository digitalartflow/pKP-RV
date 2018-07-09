<?php
    //db settings 
	$host     = "[Type your details - Follow manual.pdf]";  // type your database host
    $user     = "[Type your details - Follow manual.pdf]"; // type your database user
    $pass     = '[Type your details - Follow manual.pdf]';  // type your database password
    mysql_connect  ( $host, $user, $pass ) or die ( "Error: ".mysql_error() );
    mysql_select_db("[Type your details - Follow manual.pdf]"); // type your database name
	mysql_query("SET NAMES utf8");
	
	############### SETEAZA EMAILUL ##########################
	$config_mail = array(
		'MailSMTPAuth'	=> false,
		'MailHost'		=> "localhost",
		'MailPort'		=> 25,
		'MailUsername'	=> "[Type your details - Follow manual.pdf]",
		'MailPassword'	=> '[Type your details - Follow manual.pdf]',
		'MailFrom'		=> "[Type your details - Follow manual.pdf]",
		'MailFromName'	=> "[Type your details - Follow manual.pdf]"		
	);
	
	################# SETARI #########################
	$server = array(
		/*'server_path' => dirname(__FILE__).'/',	*/	
		'server_path' => '[Type your details - Follow manual.pdf]'	// type server path example: /home/content/87/6034387/html/demo/
	);
	$config = array(
		'siteurl' => '[Type your details - Follow manual.pdf]',  // type url
		'site_url' => '[Type your details - Follow manual.pdf]',  // type URL with www
		'site_name' => '[Type your details - Follow manual.pdf]', // type your site name
		'secret_phrase' => 'WINTEROUD',
		'server_path' => '[Type your details - Follow manual.pdf]', // type server path, example: /home/content/87/6056787/html/demo/
		'adminurl' => '[Type your details - Follow manual.pdf]/admin/',  // type your admin url path, example: http://mysite.com/demo/admin/
		'admin_url' => '[Type your details - Follow manual.pdf]/admin/',  // // type your admin url path with wwww
		'static_admin' => array(
			'css' => '[Type your details - Follow manual.pdf]/admin/static/css/', // URL
			'js' => '[Type your details - Follow manual.pdf]/admin/static/js/',  // URL
			'img' => '[Type your details - Follow manual.pdf]/admin/static/img/'  // URL
		),
	);
?>