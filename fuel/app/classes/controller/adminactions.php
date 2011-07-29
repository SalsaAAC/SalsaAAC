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
                //parent::before();

                if( ! \Auth::check() OR Input::method() != 'POST')
                {
                        $this->response(array(
                            'result'  => 'error',
                            'message' => 'not_authorized',
                        ));
                }

                \Config::load('config', true);
                \Config::load('db', true);
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

        public function post_saveconfigs()
        {
                //'Classes declarations cannot be nested fool!' - that's why so many $temps

                \Config::load('salsa', true);
                \Config::load('db', true);
                \Config::load('config', true);

                $environment     = Config::get('config.environment');
                $data['result']  = 'success';
                $data['message'] = '<br><ul style="list-style-type: none">';
                $messages        = array();

                $val1 = Validation::factory('admin_email');
                $val2 = Validation::factory('site_email');
                $val3 = Validation::factory('site_address');
                $val1->add_field('admin_email', 'Admin email', 'required|valid_email');
                $val2->add_field('site_email', 'Site email', 'required|valid_email');
                $val3->add_field('site_address', 'Site address', 'required|valid_url');
                
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
                if ($val3->run(array('site_address' => $temp)))
                {
                        \Config::set('config.base_url', $temp);
                }
                else
                {
                        $data['result'] = 'fail';
                        $messages[]     = 'Site address is not valid ['.$temp.']';
                }
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
                        \Config::set('db.salsa.connection.hostname', $temp1);
                        \Config::set('db.salsa.connection.database', $temp4);
                        \Config::set('db.salsa.connection.username', $temp2);
                        \Config::set('db.salsa.connection.password', $temp3);
                        \Config::set('db.salsa.type', $temp5);
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
                        \Config::set('db.otserv.connection.hostname', $temp1);
                        \Config::set('db.otserv.connection.database', $temp4);
                        \Config::set('db.otserv.connection.username', $temp2);
                        \Config::set('db.otserv.connection.password', $temp3);
                        \Config::set('db.otserv.driver', $temp5);
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

        public function post_getplayerslist()
        {
                $page            = Input::post('page');
                $sort            = Input::post('sortby');
                $order           = Input::post('order');
                $page           -= 1;
                $per_page        = 15;
                $start           = $page * $per_page;
                $filtered        = false;
                $data['message'] = '';
                $players         = new OTS_Players_List();
                $filter          = new OTS_SQLFilter();

                for ($i = 1; $i < 6; $i++)
                {
                        $where     = Input::post('field'.$i);
                        $where_op  = Input::post('operator'.$i);
                        $where_val = Input::post('filter_val'.$i);
                        $criterium = Input::post('criterium'.$i);
                        if ( ! empty($where) AND ! empty($where_op) AND ! empty($where_val))
                        {
                                $criterium = $criterium == 'OR' ? self::getPotConstant('OR') : self::getPotConstant('AND');

                                $where_op = self::getPotConstant($where_op);
                                if ($where == 'account')
                                {
                                        $filter->addFilter(new OTS_SQLField('name', 'accounts'), $where_val, $where_op, $criterium);
                                }
                                else
                                {
                                        if ($where == 'lastlogin') $where_val = strtotime($where_val);
                                        $filter->addFilter(new OTS_SQLField($where), $where_val, $where_op, $criterium);
                                }
                                $filtered = true;
                        }
                }
                if ($filtered) $players->setFilter($filter);
                $players_num = count($players);

                $order = self::getPotConstant($order);
                $players->orderBy(new OTS_SQLField($sort, 'players'), $order);
                $players->setLimit($per_page);
                $players->setOffset($start);

                if ($players_num <= 0 OR $start >= $players_num)
                {
                        $data['message'] = '<h4 class="alert_info" style="margin: 5px 0 5px 5px">Nothing found</h4>';
                        $data['menu']    = '';
                }
                else
                {
                        $baseurl = \Config::get('config.base_url', '/');
                        foreach ($players as $player)
                        {
                                $account = $player->getAccount();
                                $group   = $player->getGroup();
                                $flags   = '';
                                if ($player->isOnline()) $flags .= '<img src="'.$baseurl.'resources/admin/img/icons/online.png" alt="online" title="Online"></img>';
                                if ($account->getWarnings() > 0) $flags .= '<img src="'.$baseurl.'resources/admin/img/icons/warned.png" alt="warned" title="Warned"></img>';
                                if ($account->isBlocked()) $flags .= '<a href="/administration/ban/'.$account_ban->id.'"><img src="'.$baseurl.'resources/admin/img/icons/banned.png" alt="banned" title="Banned"></img></a>';
                                if (empty($flags)) $flags = '-';

                                $data['message'] .= '<tr><td><a href="/administration/player/'.$player->getId().'">'.$player->getName().'</a></td>
                                        <td><a href="/administration/account/'.$account->getId().'">'.$account->getName().'</a></td>
                                        <td>'.date("jS F Y", $player->getLastLogin()).'</td>
                                        <td>'.$player->getLevel().'</td>
                                        <td>'.$group->getName().'</td>
                                        <td>'.$flags.'</td></tr>';
                        }
                        $start        = ceil($players_num / $per_page);
                        $data['menu'] = self::pagination($start, $page, $per_page, $players_num);
                }

                $data['max'] = $start;
                $this->response($data);
        }

        public function post_getgroupslist()
        {
                $number = Input::post('number');
                $output['select'] = '<select id="filter_val'.$number.'" style="width:45%;float:right;margin-top:2px">';
                $groups = new OTS_Groups_List();
                foreach ($groups as $group)
                {
                        $output['select'] .= '<option value="'.$group->getId().'">'.$group->getName().'</option>';
                }
                $output['select'] .= '</select>';
                $this->response($output);
        }

        private function getPotConstant($string = null)
        {
                switch ($string)
                {
                        case '=':
                                return OTS_SQLFilter::OPERATOR_EQUAL;
                                break;
                        case '!=':
                                return OTS_SQLFilter::OPERATOR_NEQUAL;
                                break;
                        case '>':
                                return OTS_SQLFilter::OPERATOR_GREATER;
                                break;
                        case '<':
                                return OTS_SQLFilter::OPERATOR_LOWER;
                                break;
                        case 'AND':
                                return OTS_SQLFilter::CRITERIUM_AND;
                                break;
                        case 'OR':
                                return OTS_SQLFilter::CRITERIUM_OR;
                                break;
                        case 'asc':
                                return POT::ORDER_ASC;
                                break;
                        case 'desc':
                                return POT::ORDER_DESC;
                                break;
                        default:
                                return null;
                }
        }

        private function pagination($start, $page, $per_page, $items_num)
        {
                $menu = '<ul id="pagination">';

                if ($page + 1 <= 1)
                {
                        $menu .= '<li class="previous-off">«First</li>';
                        $menu .= '<li class="previous-off">«Prev</li>';
                }
                else
                {
                        $prev = $page;
                        $menu .= '<li p="1" class="previous"><a href="#">«First</a></li>';
                        $menu .= '<li p="'.$prev.'" class="previous"><a href="#">«Prev</a></li>';
                }

                if ($start < 7)
                {
                        for ($i = 1; $i < $start + 1; $i++)
                        {
                                $menu .= $page + 1 == $i ? '<li class="active">'.$i.'</li>' : '<li p="'.$i.'"><a href="#">'.$i.'</a></li>';
                        }
                }
                elseif ($page < 4)
                {
                        for ($i = 1; $i < 8; $i++)
                        {
                                $menu .= $page + 1 == $i ? '<li class="active">'.$i.'</li>' : '<li p="'.$i.'"><a href="#">'.$i.'</a></li>';
                        }
                }
                elseif (($page + 3)*$per_page > $items_num)
                {
                        for ($i = 6; $i > -1; $i--)
                        {
                                $current = $start - $i;
                                $menu .= $page + 1 == $current ? '<li class="active">'.$current.'</li>' : '<li p="'.$current.'"><a href="#">'.$current.'</a></li>';
                        }
                }
                else
                {
                        $begin = $page - 3;
                        for ($i = 1; $i < 8; $i++)
                        {
                                $current = $begin + $i;
                                $menu .= $page + 1 == $current ? '<li class="active">'.$current.'</li>' : '<li p="'.$current.'"><a href="#">'.$current.'</a></li>';
                        }
                }

                if ($page + 1 == $start)
                {
                        $menu .= '<li class="next-off">Next»</li>';
                        $menu .= '<li class="next-off">Last»</li>';
                }
                else
                {
                        $next = $page + 2;
                        $last = $start;
                        $menu .= '<li p="'.$next.'" class="next"><a href="#">Next»</a></li>';
                        $menu .= '<li p="'.$last.'" class="next"><a href="#">Last»</a></li>';
                }
                $menu  .= '</ul>';
                return $menu;
        }

}

/* End of file adminactions.php */
