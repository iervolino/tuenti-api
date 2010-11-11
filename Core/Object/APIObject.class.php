<?php

// This file is part of Kiwwito's TuentiAPI
// Copyright (C) 2010 Keyvan Akbary
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

namespace Kiwwito\TuentiAPI\Object;

/**
 * Hydrated class that represents a user in the TuentiAPI
 *
 * @author     Keyvan Akbary <keyvan@kiwwito.com>
 * @copyright  Copyright (c) 2010, Keyvan Akbary
 * @package    TuentiAPI
 * @version    1.0.0
 */
class APIObject extends \Kiwwito\HydroObject\Bundle
{
  //Connection handler
  protected $connection = null;
  
  /**
   * Get connection of the object
   * @return \Kiwwito\TuentiAPI\Bundle connection
   */
  public function getConnection()
  {
    if (is_null($this->connection))
      throw new \Exception ('The connection is null, you can override it and implement a new connection method for this class');
    return $this->connection;
  }

  /**
   * Set the connection for the object
   */
  public function setConnection(\Kiwwito\TuentiAPI\Bundle $con)
  {
    $this->connection = $con;
  }
}
