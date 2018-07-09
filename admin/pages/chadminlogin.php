<?php
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'modify' )
	{
		if( md5($_POST['old_admin_user']) == $config['ofd']['admin_user'] && md5($_POST['old_admin_pass']) == $config['ofd']['admin_pass'] )
		{
			if( $_POST['admin_pass'] == $_POST['re_admin_pass'] ){
				DbList::ExecNoneQuery('update options set `value`="'.md5($_POST['admin_user']).'" where `var`="admin_user"');
				DbList::ExecNoneQuery('update options set `value`="'.md5($_POST['admin_pass']).'" where `var`="admin_pass"');
				alert::add_ok('Admin login changed');
				Util::Redirect();
			}
			else
			{
				alert::add_error('New passwords do not match');
				Util::Redirect();
				die();
			}
		}
		else
		{
			alert::add_error('Old username and/or password incorrect');
			Util::Redirect();
			die();
		}
		
	}
	
	
	$core['template'] = "chadminlogin.tpl";
?>