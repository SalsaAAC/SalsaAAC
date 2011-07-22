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

class Model_Account extends Orm\Model {
	protected static $_connection = 'otserv';

	protected static $_properties = array('id', 'name', 'password', 'email', 'premend', 'blocked', 'warnings');

	protected static $_has_many = array(
		'player' => array(
			'key_from'       => 'id',
			'model_to'       => 'Model_Player',
			'key_to'         => 'account_id',
			'cascade_save'   => true,
			'cascade_delete' => false,
		)
	);

	protected static $_has_one = array(
		'ban' => array(
			'key_from'       => 'name',
			'model_to'       => 'Model_Ban',
			'key_to'         => 'value',
			'cascade_save'   => true,
			'cascade_delete' => false,
		)
	);
}

/* End of file account.php */ 
