<?php
/**
 * getRelated
 *
 * Copyright 2011 by Mark Hamstra <hello@markhamstra.com>
 *
 * This file is part of getRelated, a snippet that fetches related pages automatically.
 *
 * getRelated is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * getRelated is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * getRelated; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
*/

return array(
    'resource' => 'current',
    'fields' => 'pagetitle,tv.MyTags,introtext',
    'returnFields' => 'pagetitle,longtitle,introtext',
    'parents' => '',
    'contexts' => 'web',

    'start' => 0,
    'limit' => 3,

    'tplOuter' => 'relatedOuter',
    'tplRow' => 'relatedRow',

    'toPlaceholder' => '',
    'rowSeparator' => "\n",

);
?>