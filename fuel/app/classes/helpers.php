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

class Helpers {
   
	public static function repair_url($address)
	{
		if ( ! empty($address))
		{
			$address = explode('/', $address);
			$keys = array_keys($address, '..');

			foreach($keys AS $keypos => $key) array_splice($address, $key - ($keypos * 2 + 1), 2);

			$address = implode('/', $address);
			$address = str_replace('./', '', $address);

			$scheme = parse_url($address);

			if (empty($scheme['scheme'])) $address = 'http://' . $address;

			$parts = parse_url($address);
			$address = strtolower($parts['scheme']) . '://';

			if ( ! empty($parts['host']))
			{
				$host = str_replace(',', '.', strtolower($parts['host']));
				$address .= $host;
			}

			$address .= '/';

			if ( ! empty($parts['path']))
			{
				$path = trim($parts['path'], ' /\\');
				if ( ! empty($path) AND strpos($path, '.') === FALSE) $path .= '/';                
				$address .= $path;
			}

			$address = str_replace("www.localhost", "localhost", $address);
			return $address;
		}
		return $address;
	}
  
}

/* End of file helpers.php */
