<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* @name CI Smarty
* @copyright Dwayne Charrington, 2011.
* @author Dwayne Charrington and other Github contributors
* @license (DWYWALAYAM) 
           Do What You Want As Long As You Attribute Me Licence
* @version 1.2
* @link http://ilikekillnerds.com
*/

class Smartytest extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Ideally you would autoload the parser
        $this->load->library('parser');
    }

    public function index()
    {    
	echo 'index';
    }
    
    /**
     * Showing off Smarty 3 template inheritance features
     *
     */
    public function inheritance()
    {
        // Some example data
        $data['title'] = "The Smarty parser works with template inheritance!";
        $data['body']  = "This is body text to show that Smarty 3 template inheritance works with Smarty Parser.";
        
        // Load the template from the views directory
        $this->parser->parse("inheritancetest.tpl", $data);
    }

    public function xss()
    {
        $this->load->library('htmlpurifier');
	$url = base_url().'themes/frontend/default/images/shared/cal_top_bg.jpg';
        $dirty_html = '<a href="javascript:alert(\'test\')">ds</a><p>test<br /><img src="'.$url.'">';

        $config = HTMLPurifier_Config::createDefault();
        $clean_html = $this->htmlpurifier->purify($dirty_html , $config);
        echo $clean_html;
    }

    public function pas()
    {
	$this->load->helper('string');
        $this->load->library('htmlpurifier');
        $config = HTMLPurifier_Config::createDefault();
	$pool = 'aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPrRsStTuUwWqQaxXyYzZ1234567890`~!@#$%^&*()-_=+[]{}\\|;:\'",.<>/?';

	
	    //$validCharacters = "abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ+-*#&@!?";
	    $validCharNumber = strlen($pool);

	for ($i = 0; $i < 10000; $i++)
	{
		$length = mt_rand(4, 17);	 
		$result = "";

		for ($j = 0; $j < $length; $j++) 
		{
			$index = mt_rand(0, $validCharNumber - 1);
			$result .= $pool[$index];
		}
		$clean_pass =$this->htmlpurifier->purify($result , $config);
		if (strcmp($result, $clean_pass) != 0 && strcasecmp($result , $clean_pass) != 0)
		{
			echo $result.' :|: '.$clean_pass.'<br>';
		}
	}
	echo 'dome';
    }

    public function smart()
    {    
        // Some example data
        $data['title'] = "The Smarty parser works!";
        $data['body']  = "This is body text to show that the Smarty Parser works!";
        
        // Load the template from the views directory
        $this->parser->parse("login.tpl", $data);
    }

    public function admin()
    {
	$this->parser->parse_admin("admin.tpl");
    }

}
