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

/**
 * Autoload function for dynamic library load
 * @param string $className namespaced classname that will be loaded
 */
function __autoload($className)
{
  //Change to the root path
  set_include_path('../');
  
  $className = str_replace('\\', '/', $className);
  //Core
  $className = str_replace('Kiwwito/TuentiAPI', 'Core', $className);
  
  //Kiwwito libs
  $className = str_replace('Kiwwito', 'Core/Lib', $className);
  
  //Class load
  $className = $className . '.class.php';
  
  include_once $className;
}
