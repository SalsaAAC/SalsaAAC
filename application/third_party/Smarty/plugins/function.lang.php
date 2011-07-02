<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {lang} plugin
 *
 * Type:     function<br>
 * Name:     lang<br>
 * Purpose:  returns string from language file
 *
 * Author: Vanitas aka Misiaczyna [OTFans]
 * @param array $params parameters
 * @param object $template template object
 * @return string|null if the assign parameter is passed, Smarty assigns the
 *                     result to a template variable
 */
function smarty_function_lang($params, $template)
{
	if (!isset($params['line']))
	{
		trigger_error("[plugin] lang parameter 'line' cannot be empty",E_USER_NOTICE);
		return;
	}
	$line = $params['line'];
	$config =& get_config();

	$deft_lang = ( ! isset($config['language'])) ? 'english' : $config['language'];
	$idiom = ($deft_lang == '') ? 'english' : $deft_lang;

	if (in_array($idiom, $smarty->is_loaded, TRUE))
	{
		return;
	}

	$type = $template->getTemplateVars('template_type');
	// Determine where the language file is and load it
	if (file_exists('themes/'.$config['frontend_theme'].'/language/'.$idiom.'.php'))
	{
		include('themes/'.$config['frontend_theme'].'/language/'.$idiom.'.php');
	}
	else
	{
		show_error('Unable to load the requested language file: themes/'.$config['frontend_theme'].'/language/'.$idiom.'.php');
		return;
	}

	if ( ! isset($lang))
	{
		log_message('error', 'Language file contains no data: themes/'.$config['frontend_theme'].'/language/'.$idiom.'.php');
		return;
	}
	log_message('debug', 'Language file loaded: themes/'.$config['frontend_theme'].'/language/'.$idiom.'.php');

	//here goes the magic
	$line = ($line == '' OR ! isset($lang[$line])) ? FALSE : $lang[$line];

	// Because killer robots like unicorns!
	if ($line === FALSE)
	{
		log_message('error', 'Could not find the language line "'.$line.'"');
	}

	return $line;
}

?>
