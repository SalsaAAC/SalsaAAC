<?php /* Smarty version Smarty-3.0.7, created on 2011-07-01 15:13:14
         compiled from "/opt/lampp/htdocs/old/themes/frontend/default/smartytest.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9437180604e0dc7ea97a5a6-49808204%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '674b620d64beb8f08abb80e46cf147ada2ca05eb' => 
    array (
      0 => '/opt/lampp/htdocs/old/themes/frontend/default/smartytest.tpl',
      1 => 1309514832,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9437180604e0dc7ea97a5a6-49808204',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_lang')) include '/opt/lampp/htdocs/old/application/third_party/Smarty/plugins/function.lang.php';
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
images/shared/content_repeat.jpg">
</body>
</html>
