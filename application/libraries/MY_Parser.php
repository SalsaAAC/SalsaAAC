<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @name CI Smarty
* @copyright Dwayne Charrington, 2011.
* @author Dwayne Charrington and other Github contributors
* @license (DWYWALAYAM) 
           Do What You Want As Long As You Attribute Me Licence
* @version 1.2
* @link http://ilikekillnerds.com
*
* Added awesomeness by Vanitas aka Misiaczyna [OTFans] ;)
*
*/

class MY_Parser extends CI_Parser {

    protected $CI;
    protected $theme_location;
    protected $config;
    
    public function __construct()
    {
        $this->CI = get_instance();
	$this->config =& get_config();
        $this->CI->load->library('smarty');   
	$this->CI->load->helper('file');
	$this->CI->load->helper('url');
    }
    
    /**
    * Parse
    * Parses a template using Smarty 3 engine
    * 
    * @param string $template
    * @param array $data
    * @param boolean $return
    * @param mixed $use_theme
    */
    public function parse($template, $data = array(), $return = FALSE)
    {
        // Make sure we have a template, yo.
        if (empty($template))
        {
            return FALSE;
        }
        
	/**
	 * Custom variables
	 **/
	$theme      = $this->config['frontend_theme'];
	$theme_path = 'themes/'.$theme.'/';
	$jses       = get_filenames($theme_path.'js/');
	$csses      = get_filenames($theme_path.'css/');

	$data['baseurl']  = base_url();
	$data['themeurl'] = $data['baseurl'].$theme_path;
	$data['js']  = '';
	$data['css'] = '';

	if (is_array($jses))
	{
		foreach ($jses as $js)
		{
			$data['js'] .= "\t<script src=\"".$data['themeurl'].'js/'.$js."\" type=\"text/javascript\"></script>\n";
		}
		$data['js'] = substr($data['js'],0,-1);
	}
	
	if (is_array($csses))
	{
		foreach ($csses as $css)
		{
			$data['css'] .= "\t<link rel=\"stylesheet\" href=\"".$data['themeurl'].'css/'.$css."\" type=\"text/css\" />\n";
		}
	}

	//$data['logged_in'] = $this->ion_auth->logged_in();
	//if(!isset($data['script']))$data['script'] = '';

        // If no file extension dot has been found default to .php for view extensions
        if ( !stripos($template, '.') ) 
        {
            $template = $template.".".$this->CI->smarty->template_ext;
        }

        //merge the data array with global cached vars
        
        $data = array_merge($data, $this->CI->load->_ci_cached_vars);
        
        // If we have variables to assign, lets assign them
        if (!empty($data))
        {
            foreach ($data as $key => $val)
            {
                $this->CI->smarty->assign($key, $val);
            }
        }
        
        // Get our template data as a string
        $template_string = $this->CI->smarty->fetch($theme.'/'.$template);
        
        // If we're returning the templates contents, we're displaying the template
        if ($return == FALSE)
        {
            $this->CI->output->append_output($template_string);
        }
        
        // We're returning the contents, fo'' shizzle
        return $template_string;
    }
    
    /**
    * String Parse
    * Parses a string using Smarty 3
    * 
    * @param string $template
    * @param array $data
    * @param boolean $return
    * @param mixed $is_include
    */
    function string_parse($template, $data = array(), $return = FALSE, $is_include = FALSE)
    {
        return $this->CI->smarty->fetch('string:'.$template, $data);
    }
    
    /**
    * Parse String
    * Parses a string using Smarty 3. Never understood why there
    * was two identical functions in Codeigniter that did the same.
    * 
    * @param string $template
    * @param array $data
    * @param boolean $return
    * @param mixed $is_include
    */
    function parse_string($template, $data = array(), $return = FALSE, $is_include = false)
    {
        return $this->CI->smarty->fetch('string:'.$template, $data);
    }

    /**
    * Parse_admin
    * Parses an admin template using Smarty 3 engine
    * 
    * @param string $template
    * @param array $data
    * @param boolean $return
    * @param mixed $use_theme
    */
    public function parse_admin($template, $data = array(), $return = FALSE)
    {
        // Make sure we have a template, yo.
        if (empty($template))
        {
            return FALSE;
        }
        
	/**
	 * Custom variables
	 **/
	$data['baseurl']  = base_url();

	//$data['logged_in'] = $this->ion_auth->logged_in();
	//if(!isset($data['script']))$data['script'] = '';

        // If no file extension dot has been found default to .php for view extensions
        if ( !stripos($template, '.') ) 
        {
            $template = $template.".".$this->CI->smarty->template_ext;
        }

        //merge the data array with global cached vars
        $data = array_merge($data, $this->CI->load->_ci_cached_vars);

	$this->CI->smarty->setTemplateDir(APPPATH.'views/');
        
        // If we have variables to assign, lets assign them
        if (!empty($data))
        {
            foreach ($data as $key => $val)
            {
                $this->CI->smarty->assign($key, $val);
            }
        }
        
        // Get our template data as a string
        $template_string = $this->CI->smarty->fetch($template);
        
        // If we're returning the templates contents, we're displaying the template
        if ($return == FALSE)
        {
            $this->CI->output->append_output($template_string);
        }
        
        // We're returning the contents, fo'' shizzle
        return $template_string;
    }

}
