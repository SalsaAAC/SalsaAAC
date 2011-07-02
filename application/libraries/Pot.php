<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'third_party/POT/OTS.php';

/**
* Name:  CodeIgniter POT Library
* 
* Author: Vanitas aka Misiaczyna [OTFans]
*          
* Created:  25.07.2011 
* 
* Description:  Main CodeIgniter POT Library file
*
* Requirements: PHP 5.2 or above
*
*/

class CI_Pot extends POT
{
	/**
	 * CodeIgniter global
	 *
	 * @var string
	 */
	protected $ci;


	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->config('pot', TRUE);

		$config = array(
		    'driver'   => $this->ci->config->item('driver', 'pot'),
		    'prefix'   => $this->ci->config->item('prefix', 'pot'),
		    'host'     => $this->ci->config->item('host', 'pot'),
		    'user'     => $this->ci->config->item('user', 'pot'),
		    'password' => $this->ci->config->item('password', 'pot'),
		    'database' => $this->ci->config->item('database', 'pot')
		);
		POT::connect(null, $config);
		//POT::connect(POT::DB_MYSQL, $config);
	}

}

/* End of file Pot.php */
/* Location: ./application/libraries/Pot.php */
