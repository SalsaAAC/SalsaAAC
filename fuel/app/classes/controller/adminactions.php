<?php
/**
 *  Copyright (C) 2011  SalsaAAC
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class Controller_Adminactions extends Controller_Rest {

	public function before()
	{
		parent::before();

		if( ! \Auth::check() OR Input::method() != 'POST')
		{
			$this->response(array(
			    'result'  => 'error',
			    'message' => 'not_authorized',
			));
		}

		\Config::load('salsa', true);
		require_once(APPPATH.'vendor'.DS.'POT'.DS.'OTS.php');

		switch (\Config::get('salsa.otserv.driver', 'POT::DB_MYSQL'))
		{
			case 'POT::DB_SQLITE':
				$driver = POT::DB_SQLITE;
				break;
			case 'POT::DB_PGSQL':
				$driver = POT::DB_PGSQL;
				break;
			case 'POT::DB_ODBC':
				$driver = POT::DB_ODBC;
				break;
			default:
				$driver = POT::DB_MYSQL;	
		}
		$config = array(
			'driver'   => $driver,
			'prefix'   => \Config::get('salsa.otserv.prefix', ''),
			'host'     => \Config::get('salsa.otserv.host', 'localhost'),
			'user'     => \Config::get('salsa.otserv.user', 'root'),
			'password' => \Config::get('salsa.otserv.password', ''),
			'database' => \Config::get('salsa.otserv.database', 'otserv'),
		);
		POT::connect(null, $config);
	}

	public function post_saveconfigs()
	{
		//'Classes declarations cannot be nested fool!' - that's why so many $temp's

		\Config::load('salsa', true);
		\Config::load('db', true);
		\Config::load('config', true);

		$environment     = Config::get('config.environment');
		$data['result']  = 'success';
		$data['message'] = '<br><ul style="list-style-type: none">';
		$messages        = array();

		$val1 = Validation::factory('admin_email');
		$val2 = Validation::factory('site_email');
		$val1->add_field('admin_email', 'Admin email', 'required|valid_email');
		$val2->add_field('site_email', 'Site email', 'required|valid_email');
		
		$temp =  Input::post('site_name');
			\Config::set('salsa.site_name', $temp);
		$temp = (bool)Input::post('site_offline');
		$temp = isset($temp) ? $temp : false;
			\Config::set('salsa.offline', $temp);
		$temp = Input::post('offline_message');
			\Config::set('salsa.offline_message', $temp);
		$temp = Input::post('meta_desc');
			\Config::set('salsa.meta_description', $temp);
		$temp = Input::post('meta_keys');
			\Config::set('salsa.meta_keywords', $temp);
		$temp = Input::post('site_address');
		$temp = Helpers::repair_url($temp);
			\Config::set('config.base_url', $temp);
		if ($val1->run())
		{
			\Config::set('salsa.admin_email', Input::post('admin_email'));
		}
		else
		{
			$data['result'] = 'fail';
			$messages[]     = 'Admin email is not valid';
		}
		if ($val2->run())
		{
			\Config::set('salsa.site_email', Input::post('site_email'));
		}
		else
		{
			$data['result'] = 'fail';
			$messages[]     = 'Site email is not valid';
		}
		//timezone
		$temp = Input::post('date_format');
		if (empty($temp))
		{
			$data['result'] = 'fail';
			$messages[]     = 'Date format cannot be empty';
		}
		else
		{
			\Config::set('salsa.date_format', $temp);
		}
		$temp = Input::post('time_format');
		if (empty($temp))
		{
			$data['result'] = 'fail';
			$messages[]     = 'Time format cannot be empty';
		}
		else
		{
			\Config::set('salsa.time_format', $temp);
		}

		$temp5 = Input::post('db_type');
		$temp1 = Input::post('db_host');
		$temp2 = Input::post('db_user');
		$temp3 = Input::post('db_password');
		$temp4 = Input::post('db_name');
		$connection = mysql_connect($temp1, $temp2, $temp3);
		$database   = mysql_select_db($temp4);
		if ($connection AND $database)
		{
			mysql_close();
			\Config::set('db.'.$environment.'.connection.hostname', $temp1);
			\Config::set('db.'.$environment.'.connection.database', $temp4);
			\Config::set('db.'.$environment.'.connection.username', $temp2);
			\Config::set('db.'.$environment.'.connection.password', $temp3);
			\Config::set('db.'.$environment.'.type', $temp5);
		}
		else
		{
			$data['result'] = 'fail';
			$messages[]     = 'Could not connect AAC Database on specified configuration';
		}

		$temp5 = Input::post('ot_type');
		$temp1 = Input::post('ot_host');
		$temp2 = Input::post('ot_user');
		$temp3 = Input::post('ot_password');
		$temp4 = Input::post('ot_name');
		$connection = mysql_connect($temp1, $temp2, $temp3);
		$database   = mysql_select_db($temp4);
		if ($connection AND $database)
		{
			mysql_close();
			\Config::set('salsa.otserv.host', $temp1);
			\Config::set('salsa.otserv.database', $temp4);
			\Config::set('salsa.otserv.user', $temp2);
			\Config::set('salsa.otserv.password', $temp3);
			\Config::set('salsa.otserv.driver', $temp5);
		}
		else
		{
			$data['result'] = 'fail';
			$messages[]     = 'Could not connect OTServ Database on specified configuration';
		}
		$temp = Input::post('ot_ip');
			\Config::set('salsa.otserv.ip', $temp);
		$temp = Input::post('ot_port');
			\Config::set('salsa.otserv.port', $temp);

		if ($data['result'] == 'success')
		{
			$save1 = \Config::save('salsa', 'salsa');
			$save2 = \Config::save('db', 'db');
			$save3 = \Config::save('config', 'config');

			if( ! $save1 OR ! $save2 OR ! $save3)
			{
				$data['result'] = 'fail';
				$messages[]     = 'Could not save data to config files';
			}
		}

		foreach($messages as $message)
		{
			$data['message'] .= '<li>'.$message.'</li>';
		}
		$data['message'] .= '</ul>';

		$this->response($data);
	}
}
/* End of file adminactions.php */
