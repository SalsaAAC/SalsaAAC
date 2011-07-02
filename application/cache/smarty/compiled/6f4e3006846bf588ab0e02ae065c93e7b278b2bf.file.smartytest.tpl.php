<?php /* Smarty version Smarty-3.0.7, created on 2011-07-01 16:01:40
         compiled from "/opt/lampp/htdocs/themes/frontend/default/smartytest.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8081326084e0dd34458cdd1-97874693%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6f4e3006846bf588ab0e02ae065c93e7b278b2bf' => 
    array (
      0 => '/opt/lampp/htdocs/themes/frontend/default/smartytest.tpl',
      1 => 1309528893,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8081326084e0dd34458cdd1-97874693',
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
	ststic<br>
    <?php echo $_smarty_tpl->getVariable('themeurl')->value;?>
<br>
    <img src="<?php echo $_smarty_tpl->getVariable('themeurl')->value;?>
images/shared/logo.png"/>
</body>
</html>
