<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  CodeIgniter POT Library
* 
* Author: Vanitas aka Misiaczyna [OTFans]
*          
* Created:  25.07.2011 
*
* Description:  Config file for CodeIgniter OTServ Library
* 
*/

/*
| -------------------------------------------------------------------
|  OTServ database settings
| -------------------------------------------------------------------
| Prototype:
|
|  $config['driver']   : POT::DB_MYSQL || POT::DB_SQLITE || POT::DB_PGSQL || POT::DB_ODBC
|  $config['prefix']   : database prefix (optional)
|  $config['host']     : database host
|  $config['user']     : database user
|  $config['password'] : database user password
|  $config['database'] : database name
|
*/
$config['driver']   = POT::DB_MYSQL;
$config['prefix']   = '';
$config['host']     = 'localhost';
$config['user']     = 'root';
$config['password'] = '';
$config['database'] = 'otserv';


/* End of file pot.php */
/* Location: ./application/config/pot.php */
