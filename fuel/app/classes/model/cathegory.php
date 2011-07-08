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

class Model_Cathegory extends Orm\Model {
	protected static $_properties = array('id', 'description', 'name');

	protected static $_has_many = array(
		'articles' => array(
			'key_from'       => 'id',
			'model_to'       => 'Model_Article',
			'key_to'         => 'cathegory',
			'cascade_save'   => true,
			'cascade_delete' => false,
		)
	);
}

/* End of file cathegory.php */ 
