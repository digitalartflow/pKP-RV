<?php
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'login' )
	{
		if( md5($_POST['user']) == $config['ofd']['admin_user'] && md5($_POST['pass']) == $config['ofd']['admin_pass'] )
		{
			$_SESSION['admin_logged'] = true;
			Util::Redirect($config['adminurl']);
		}
		else
		{
			alert::add_error('Username and/or password incorrect');
			Util::Redirect();
			die();
		}
		
	}
	
	$core['template'] = "login.tpl";
?>