<?php /* Smarty version Smarty-3.0.7, created on 2011-07-01 15:28:12
         compiled from "themes/frontend/default/smartytest.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17698942764e0dcb6c54b965-61368253%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5a55776d2b699cc0141b097c5f0df10df2cdd3e7' => 
    array (
      0 => 'themes/frontend/default/smartytest.tpl',
      1 => 1309526865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17698942764e0dcb6c54b965-61368253',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_lang')) include '/opt/lampp/htdocs/application/third_party/Smarty/plugins/function.lang.php';
?><?php $_smarty_tpl->tpl_vars['template_type'] = new Smarty_variable('frontend', null, null);?>
<?php echo (($tmp = @$_smarty_tpl->getVariable('articleTitle')->value)===null||$tmp==='' ? 'no title' : $tmp);?>

<html>
<head>
    <title><?php echo $_smarty_tpl->getVariable('title')->value;?>
</title>
    <?php echo $_smarty_tpl->getVariable('css')->value;?>

    <?php echo $_smarty_tpl->getVariable('js')->value;?>

</head>
<body>
    <?php echo $_smarty_tpl->getVariable('body')->value;?>
<br>
    <?php echo smarty_function_lang(array('line'=>"dupa"),$_smarty_tpl);?>
<br>
    <?php echo smarty_function_lang(array('line'=>"dupa"),$_smarty_tpl);?>
<br>
    <?php echo smarty_function_lang(array('line'=>"dupa"),$_smarty_tpl);?>
<br>
    <?php echo $_smarty_tpl->getVariable('themeurl')->value;?>
<br>
    <img src="<?php echo $_smarty_tpl->getVariable('themeurl')->value;?>
images/shared/logo.jpg">
</body>
</html>
