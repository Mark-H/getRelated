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
/* @var modX $modx
 * @var getRelated $getRelated
 * @var array $scriptProperties
 */
$path = $modx->getOption('getrelated.core_path',null,$modx->getOption('core_path').'components/getrelated/');

$p = include $path.'elements/snippets/getrelated.properties.php';
$p = array_merge($p,$scriptProperties);

$getRelated = $modx->getService('getrelated','getRelated',$path.'model/');
$getRelated->setProperties($p);
if (!($getRelated instanceof getRelated)) return $modx->lexicon('getrelated.errorloadingclass',array('path' => $path.'model/'));

/* Get the possibly related resources based on the $matchData found. */
$success = $getRelated->getRelated();

if ($p['debug']) {
    echo '<br/><strong>Config:</strong>'; var_dump($getRelated->config);
    echo '<br/><strong>Fields:</strong>'; var_dump($getRelated->fields);
    echo '<br/><strong>TVs:</strong>'; var_dump($getRelated->tvs);
    echo '<br/><strong>Match Data:</strong>'; var_dump($getRelated->matchData);
    echo '<br/><strong>All Related Resources:</strong>'; var_dump($getRelated->related);
}

if ($success !== true) return $success;

if (count($getRelated->related) < 1) {
    return $getRelated->config['noResults'];
}

$output = $getRelated->returnRelated();
return $output;



