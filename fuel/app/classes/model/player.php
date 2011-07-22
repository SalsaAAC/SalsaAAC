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

class Model_Player extends Orm\Model {
	protected static $_connection = 'otserv';

	protected static $_properties = array('id', 'name', 'account_id', 'group_id', 'sex', 'vocation', 'experience', 'level', 'maglevel', 'health', 'healthmax', 'mana', 'manamax', 'manaspent', 'soul', 'direction', 'lookbody', 'lookfeet', 'lookhead', 'looklegs', 'looktype', 'lookaddons', 'posx', 'posy', 'posz', 'cap', 'lastlogin', 'lastlogout', 'lastip', 'conditions', 'skull_type', 'skull_time', 'loss_experience', 'loss_mana', 'loss_skills', 'loss_items', 'loss_containers', 'town_id', 'balance', 'stamina', 'online', 'rank_id', 'guildnick');

	protected static $_belongs_to = array(
		'group' => array(
			'key_from'       => 'group_id',
			'model_to'       => 'Model_Group',
			'key_to'         => 'id',
			'cascade_save'   => true,
			'cascade_delete' => false,
		),
		'account' => array(
			'key_from'       => 'account_id',
			'model_to'       => 'Model_Account',
			'key_to'         => 'id',
			'cascade_save'   => true,
			'cascade_delete' => false,
		)
	);


	protected static $_has_one = array(
		'ban' => array(
			'key_from'       => 'id',
			'model_to'       => 'Model_Ban',
			'key_to'         => 'value',
			'cascade_save'   => true,
			'cascade_delete' => false,
		)
	);

	protected static $_has_many = array(
		'player_death' => array(
			'key_from'       => 'id',
			'model_to'       => 'Model_Playerdeath',
			'key_to'         => 'player_id',
			'cascade_save'   => true,
			'cascade_delete' => true,
		),
		'player_depotitem' => array(
			'key_from'       => 'id',
			'model_to'       => 'Model_Playerdepotitem',
			'key_to'         => 'player_id',
			'cascade_save'   => true,
			'cascade_delete' => true,
		),
		'player_item' => array(
			'key_from'       => 'id',
			'model_to'       => 'Model_Playeritem',
			'key_to'         => 'player_id',
			'cascade_save'   => true,
			'cascade_delete' => true,
		),
		'player_killer' => array(
			'key_from'       => 'id',
			'model_to'       => 'Model_Playerkiller',
			'key_to'         => 'player_id',
			'cascade_save'   => true,
			'cascade_delete' => false,
		),
		'player_skill' => array(
			'key_from'       => 'id',
			'model_to'       => 'Model_Playerskill',
			'key_to'         => 'player_id',
			'cascade_save'   => true,
			'cascade_delete' => true,
		),
		'player_spell' => array(
			'key_from'       => 'id',
			'model_to'       => 'Model_Playerspell',
			'key_to'         => 'player_id',
			'cascade_save'   => true,
			'cascade_delete' => true,
		),
		'player_storage' => array(
			'key_from'       => 'id',
			'model_to'       => 'Model_Playerstorage',
			'key_to'         => 'player_id',
			'cascade_save'   => true,
			'cascade_delete' => true,
		),
		'player_viplist' => array(
			'key_from'       => 'id',
			'model_to'       => 'Model_Playerviplist',
			'key_to'         => 'player_id',
			'cascade_save'   => true,
			'cascade_delete' => true,
		)
	);

}

/* End of file player.php */
