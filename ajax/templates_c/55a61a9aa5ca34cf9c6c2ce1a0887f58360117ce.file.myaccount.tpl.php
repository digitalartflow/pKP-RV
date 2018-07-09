<?php /* Smarty version Smarty3-b7, created on 2015-07-27 06:33:10
         compiled from "../templates/myaccount/myaccount.tpl" */ ?>
<?php /*%%SmartyHeaderCode:211569749955b63316ca8ce4-08312024%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '55a61a9aa5ca34cf9c6c2ce1a0887f58360117ce' => 
    array (
      0 => '../templates/myaccount/myaccount.tpl',
      1 => 1438003865,
    ),
  ),
  'nocache_hash' => '211569749955b63316ca8ce4-08312024',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Welcome <?php echo $_SESSION['logged']['Name'];?>
</h1>
This is your php Kitchen Planner account. With this account you will be able to plan, save and checkout interior designs.

<h1><a href="<?php echo @WEBSITE_URL;?>
choose-state.html">Start a new design?</a></h1>