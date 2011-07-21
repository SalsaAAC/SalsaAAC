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

abstract class Controller_Admin extends Controller {

	protected static $theme_data = array();

	public function before()
	{
		parent::before();

		\Config::load('config', true);	
		\Config::load('salsa', true);
		\Config::load('db', true);		
		self::$theme_data['baseurl']   = \Config::get('config.base_url');
		self::$theme_data['site_name'] = \Config::get('salsa.site_name');
		self::$theme_data['script']    = '';

		$uri_string = Uri::segments();
		if (count($uri_string) != 1 OR $uri_string[0] != 'administration')
		{
			if(\Auth::check())
			{
				$user = \Auth::instance()->get_user_array(array(1 => 'user_id'));
				self::$theme_data['user']['username']     = $user['screen_name'];
				self::$theme_data['user']['email']        = $user['email'];
				self::$theme_data['user']['id']           = $user['user_id'];
				self::$theme_data['user']['is_logged_in'] = true;
			}
			else
			{
				\Response::redirect('/administration');
			}
		}

		require_once(APPPATH.'vendor'.DS.'POT'.DS.'OTS.php');

		switch (\Config::get('db.otserv.driver', 'POT::DB_MYSQL'))
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
			'prefix'   => \Config::get('db.otserv.table_prefix', ''),
			'host'     => \Config::get('db.otserv.connection.hostname', 'localhost'),
			'user'     => \Config::get('db.otserv.connection.username', 'root'),
			'password' => \Config::get('db.otserv.connection.password', ''),
			'database' => \Config::get('db.otserv.connection.database', 'otserv'),
		);
		POT::connect(null, $config);
	}
}

/* End of file admin.php */
