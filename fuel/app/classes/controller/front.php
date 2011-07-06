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

abstract class Controller_Front extends Controller {

	public function before()
	{
		parent::before();
		require_once(APPPATH.'vendor'.DS.'POT'.DS.'OTS.php');

		\Config::load('salsa', true);		
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
		$data = array(
			'driver'   => $driver,
			'prefix'   => \Config::get('salsa.otserv.prefix', ''),
			'host'     => \Config::get('salsa.otserv.host', 'localhost'),
			'user'     => \Config::get('salsa.otserv.user', 'root'),
			'password' => \Config::get('salsa.otserv.password', ''),
			'database' => \Config::get('salsa.otserv.database', 'otserv'),
		);
		POT::connect(null, $data);	
	}
}

/* End of file front.php */
