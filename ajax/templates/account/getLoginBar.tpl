{{if !$smarty.session.logged}}
<a href="javascript:void(0)" onclick="showAccount('login')">Log In</a> | <a href="javascript:void(0)" onclick="showAccount('create_account')">Create an account</a>
{{else}}
<a href="javascript:void(0)" onclick="showAccount('my_account')">My account</a> | <a href="javascript:void(0)" onclick="logout()">Log out</a>
{{/if}}
