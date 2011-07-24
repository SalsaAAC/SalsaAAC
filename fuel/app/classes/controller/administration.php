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

class Controller_Administration extends Controller_Admin {

	protected static $theme_data = array();

	public function before()
	{
		parent::before();
		self::$theme_data = parent::$theme_data;
	}

	public function action_index()
	{
		if(\Auth::check()) \Response::redirect('/administration/dashboard');

		if(Input::method() == 'POST')
		{

			$val = Validation::factory();
			$val->add_field('username', 'Username', 'required|min_length[3]|max_length[20]');
			$val->add_field('password', 'Password', 'required|min_length[3]|max_length[20]');
			if($val->run())
			{
				$auth = Auth::instance();
				if($auth->login($val->validated('username'), $val->validated('password')))
				{
					\Response::redirect('/administration/dashboard');
				}
				else
				{
					self::$theme_data['error'] = 'Wrong username or password.';
				}
			}
			else
			{
				self::$theme_data['error'] = 'Username or password is not valid.';
			}
		}
		$this->response->body = View::factory('login.twig', self::$theme_data);
	}

	public function action_dashboard()
	{
		\Config::load('salsa', true);
	
		$info = new OTS_ServerInfo(\Config::get('salsa.otserv.ip', '127.0.0.1'), \Config::get('salsa.otserv.port', 7171));
		$status = $info->status();
		if(!$status)
		{
			self::$theme_data['alert']['message'] = 'The server is offline!';
			self::$theme_data['alert']['type']    = 'warning';
			self::$theme_data['players_online']   = 'OFF';
			self::$theme_data['monsters']         = 'OFF';
		}
		else
		{
			self::$theme_data['players_online'] = $status->getOnlinePlayers();
			self::$theme_data['monsters']       = $status->getMonstersCount();
		}

		$now        = time();
		$secs_today = $now - mktime(date("H", $now+3600), date("i", $now), date("s", $now), date("n", 1), date("j", 1), date("Y", 1970));
		$players    = new OTS_Players_List();
		$filter     = new OTS_SQLFilter();	
		$filter->compareField('lastlogin', $secs_today, OTS_SQLFilter::OPERATOR_NLOWER);
		$players->setFilter($filter);
		self::$theme_data['players_today'] = count($players);

		$query = Model_Article::find('all', array(
			'order_by' => array('date' => 'desc'),
			'limit'    => 7
		));
	
		$i = 0;
		foreach ($query as $q)
		{
			self::$theme_data['articles'][$i]['title']     = $q->title;
			self::$theme_data['articles'][$i]['date']      = date("jS F Y", $q->date);
			self::$theme_data['articles'][$i]['cathegory'] = Model_Cathegory::find($q->cathegory)->name;
			$i++;
		}

		$this->response->body = View::factory('dashboard.twig', self::$theme_data);
	}

	public function action_configuration()
	{
		\Config::load('salsa', true);
		\Config::load('db', true);
		$error = 'Config value cannot be readed.';
		$environment = Config::get('config.environment');

		self::$theme_data['site']['name']            = \Config::get('salsa.site_name', $error);
		self::$theme_data['site']['offline']         = \Config::get('salsa.offline', false) ? ' checked="yes"' : '';
		self::$theme_data['site']['offline_message'] = \Config::get('salsa.offline_message', $error);
		self::$theme_data['site']['meta_desc']       = \Config::get('salsa.meta_description', $error);
		self::$theme_data['site']['meta_keywords']   = \Config::get('salsa.meta_keywords', $error);
		self::$theme_data['site']['address']         = \Config::get('config.base_url', $error);
		self::$theme_data['site']['admin_email']     = \Config::get('salsa.admin_email', $error);
		self::$theme_data['site']['site_email']      = \Config::get('salsa.site_email', $error);
		self::$theme_data['site']['timezone']        = '';
		self::$theme_data['site']['date_format']     = \Config::get('salsa.date_format', $error);
		self::$theme_data['site']['time_format']     = \Config::get('salsa.time_format', $error);

		self::$theme_data['db']['type']     = '';
		self::$theme_data['db']['host']     = \Config::get('db.salsa.connection.hostname', $error);
		self::$theme_data['db']['name']     = \Config::get('db.salsa.connection.database', $error);
		self::$theme_data['db']['user']     = \Config::get('db.salsa.connection.username', $error);
		self::$theme_data['db']['password'] = \Config::get('db.salsa.connection.password', $error);

		self::$theme_data['otserv']['db_type']     = '';
		self::$theme_data['otserv']['db_host']     = \Config::get('db.otserv.connection.hostname', $error);
		self::$theme_data['otserv']['db_name']     = \Config::get('db.otserv.connection.database', $error);
		self::$theme_data['otserv']['db_user']     = \Config::get('db.otserv.connection.username', $error);
		self::$theme_data['otserv']['db_password'] = \Config::get('db.otserv.connection.password', $error);
		self::$theme_data['otserv']['ip']          = \Config::get('salsa.otserv.ip', $error);
		self::$theme_data['otserv']['port']        = \Config::get('salsa.otserv.port', $error);

		$this->response->body = View::factory('configuration.twig', self::$theme_data);
	}

	public function action_players()
	{
		
		$this->response->body = View::factory('players.twig', self::$theme_data);
	}

	public function action_accounts()
	{		
		$this->response->body = View::factory('accounts.twig', self::$theme_data);
	}
	

	public function action_name()
	{
		for ($i = 1; $i< 16; $i++)
		{
			$n = rand(10e16, 10e20);
			echo base_convert($n, 10, 36).'<br>';
		}
	}		

	public function action_logout()
	{
		Auth::instance()->logout();
		Response::redirect('/');
	}

	public function action_404()
	{
		$messages = array('Aw, crap!', 'Bloody Hell!', 'Uh Oh!', 'Nope, not here.', 'Huh?');
		$data['title'] = $messages[array_rand($messages)];

		// Set a HTTP 404 output header
		$this->response->status = 404;
		$this->response->body = View::factory('dashboard.twig', $data);
	}
}

/* End of file administration.php */
