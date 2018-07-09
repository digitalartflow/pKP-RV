<?php /* Smarty version Smarty3-b7, created on 2015-07-27 06:31:23
         compiled from "../templates/account/getLoginBar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:198329835455b632ab9e7b84-69915363%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bacbb3376c7c67e6e7899e5f7f068a125afa4ca8' => 
    array (
      0 => '../templates/account/getLoginBar.tpl',
      1 => 1438003865,
    ),
  ),
  'nocache_hash' => '198329835455b632ab9e7b84-69915363',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$_SESSION['logged']){?>
<a href="javascript:void(0)" onclick="showAccount('login')">Log In</a> | <a href="javascript:void(0)" onclick="showAccount('create_account')">Create an account</a>
<?php }else{ ?>
<a href="javascript:void(0)" onclick="showAccount('my_account')">My account</a> | <a href="javascript:void(0)" onclick="logout()">Log out</a>
<?php }?>
