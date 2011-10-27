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

class getRelated {
    /* @var modX $modx */
    public $modx;
    public $config = array();
    public $stopwords = array();

    /* @var modResource $resource */
    public $resource;
    public $fields = array();
    public $weight = array();
    public $tvs = array();
    public $matchData = array();
    public $related = array();
    public $chunks = array();

    /**
     * Constructs the getRelated class.
     * 
     * @param \modX $modx
     * @param array $config
     * @return \getRelated
     */
    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;
        $this->modx->lexicon->load('getrelated:default');

        $this->stopwords = explode(',',$this->modx->lexicon('getrelated.stopwords'));

        $basePath = $this->modx->getOption('getrelated.core_path',$config,$this->modx->getOption('core_path').'components/getrelated/');
        $this->config = array_merge(array(
            'base_bath' => $basePath,
            'core_path' => $basePath,
            'model_path' => $basePath.'model/',
            'elements_path' => $basePath.'elements/',
        ),$config);

        $this->config['returnFields'] = explode(',',$this->config['returnFields']);
        $this->config['parents'] = !empty($this->config['parents']) ? explode(',',$this->config['parents']) : array();
        $this->config['contexts'] = !empty($this->config['contexts']) ? explode(',',$this->config['contexts']) : array($this->modx->context->get('key'));
        if (count($this->config['parents']) > 0) {
            $a = array();
            foreach ($this->config['parents'] as $prnt) {
                foreach ($this->config['contexts'] as $ctx)
                $a = array_merge($a,$this->modx->getChildIds($prnt, $this->config['parentsDepth'],array('context' => $ctx)));
            }
        }
        if (isset($a) && count($a) > 0) $this->config['parents'] = $a;

        $fields = explode(',',$this->config['fields']);
        foreach ($fields as $fld) {
            $tmp = explode(':',$fld);
            if (substr($tmp[0],0,3) == 'tv.') {
                $this->tvs[] = substr($tmp[0],3);
                $tmp[0] = substr($tmp[0],3);
            } else {
                $this->fields[] = $tmp[0];
            }
            $this->weight[$tmp[0]] = (is_numeric($tmp[1])) ? (int)$tmp[1] : $this->config['defaultWeight'];
        }

        if (empty($this->config['resource']) || ($this->config['resource'] == $this->modx->resource->get('id')) || ($this->config['resource'] == 'current'))
            $this->resource = $this->modx->resource;
        else {
            $this->resource = $this->modx->getObject('modResource',$this->config['resource']);
        }
    }

    /**
    * Gets a Chunk and caches it; also falls back to file-based templates
    * for easier debugging.
    *
    * @author Shaun McCormick
    * @access public
    * @param string $name The name of the Chunk
    * @param array $properties The properties for the Chunk
    * @return string The processed content of the Chunk
    */
    public function getChunk($name,$properties = array()) {
        $chunk = null;
        if (!isset($this->chunks[$name])) {
            $chunk = $this->modx->getObject('modChunk',array('name' => $name),true);
            if ($chunk == false) {
                $chunk = $this->_getTplChunk($name);
                if ($chunk == false) return false;
            }
            $this->chunks[$name] = $chunk->getContent();
        } else {
            $o = $this->chunks[$name];
            $chunk = $this->modx->newObject('modChunk');
            $chunk->setContent($o);
        }
        $chunk->setCacheable(false);
        return $chunk->process($properties);
    }

    /**
    * Returns a modChunk object from a template file.
    *
    * @author Shaun McCormick
    * @access private
    * @param string $name The name of the Chunk. Will parse to name.chunk.tpl
    * @param string $postFix The postfix to append to the name
    * @return modChunk/boolean Returns the modChunk object if found, otherwise
    * false.
    */
    private function _getTplChunk($name,$postFix = '.tpl') {
        $chunk = false;
        $f = $this->config['elements_path'].'chunks/'.strtolower($name).$postFix;
        if (file_exists($f)) {
            $o = file_get_contents($f);
            /* @var modChunk $chunk */
            $chunk = $this->modx->newObject('modChunk');
            $chunk->set('name',$name);
            $chunk->setContent($o);
        }
        return $chunk;
    }

    /**
     * Checks the resource specified by the $resid property for the fields (and TVs)
     * in the $fields property and parses it into individual words.
     *
     * This method also filters out duplicates, non alpha numeric signs and stop words.
     *
     * @return bool
     */
    public function getMatchData() {
        if (!($this->resource instanceof modResource)) return false;

        /* Fetch TV data */
        $values = array();
        foreach ($this->tvs as $tvname) {
            $tvvalue = $this->resource->getTVValue($tvname);
            $values1 = explode('||',$tvvalue);
            foreach ($values1 as $key => $value) {
                $values1 = array_merge($values1,explode(',',$value));
                unset ($values1[$key]);
            }
            $values = array_merge($values,$values1);
        }

        /* Fetch resource data */
        $resValues = $this->resource->get($this->fields);
        $resValues = implode(' ',$resValues);
        $resValues = explode(' ',trim($resValues));

        /* Combine the data and filter out duplicates, non-alphanum and stop words. */
        $values = array_merge($values,$resValues);
        $filteredValues = array();
        foreach ($values as $v) {
            $v = preg_replace('/[^a-z0-9\s]/', '', strtolower($v));
            if (!in_array(strtolower($v),$this->stopwords) &&
                !in_array(strtolower($v),$filteredValues) &&
                !empty($v) &&
                (strlen($v) > 0))
                $filteredValues[] = strtolower($v);
        }

        $this->matchData = $filteredValues;
        return true;
    }

    /**
     * Gets related resources based on fields and TVs.
     * Sorts data based on the weights and results.
     * Returns a multi-dimensional array with results (not a collection of objects).
     *
     * Calls _getFieldRelated(), _getTVRelated() and _calculateRelatedRank().
     *
     * @return array|string
     */
    public function getRelated() {
        if (empty($this->fields) && empty($this->tvs)) return $this->modx->lexicon('getrelated.error.nofields');
        if (!$this->getMatchData()) { return $this->modx->lexicon('getrelated.error.invalidresource'); }
        if (count($this->matchData) < 1) { return $this->modx->lexicon('getrelated.error.nodistinctivedata'); }

        $this->_getFieldRelated();
        if (count($this->tvs) > 0) { $this->_getTVRelated(); }
        $this->_calculateRelatedRank();

        return true;
    }

    /**
     * Get resources that are related based on resource field values.
     *
     * @return array
     */
    private function _getFieldRelated() {
        $c = $this->modx->newQuery('modResource');
        $selectFields = array('id');
        foreach (array_merge($this->config['returnFields'],$this->fields) as $fld) {
            if (!in_array($fld,$selectFields))
                $selectFields[] = $fld;
        }

        $c->select($selectFields);
        $fldMtch = array();
        foreach ($this->fields as $fld) {
            foreach ($this->matchData as $data)
                $fldMtch[] = array($fld.':LIKE' => "%$data%");
        }
        $c->where($fldMtch,xPDOQuery::SQL_OR);
        $c->andCondition(
            array(
                'modResource.id:!=' => $this->resource->get('id'),
                'context_key:IN' => $this->config['contexts'],
            )
        );
        if (!empty($this->config['parents']))
            $c->andCondition(array('parent:IN' => $this->config['parents']));

        $c->sortby($this->config['fieldSort'],$this->config['fieldSortDir']);
        $c->limit($this->config['fieldSample']);
        
        if ($this->config['debug']) {
            $c->prepare();
            echo $c->toSQL();
        }

        $col = $this->modx->getCollection('modResource',$c);
        /* @var modResource $item */
        foreach ($col as $item) {
            if ($item instanceof modResource) {
                $array = $item->toArray('',false,true);
                if (empty($this->related[$array['id']]))
                    $this->related[$array['id']] = $array;
            }
        }
        return true;
    }

    /**
     * Get resources that are related based on TV values.
     *
     * @return array
     */
    private function _getTVRelated() {
        /* get TV values */
        $c = $this->modx->newQuery('modTemplateVarResource');
        $c->innerJoin('modTemplateVar','TemplateVar');
        $c->innerJoin('modResource','Resource');

        $selectFields = array('tvid' => 'modTemplateVarResource.id', 'Resource.id','value','name');
        foreach ($this->config['returnFields'] as $fld) {
            if (!in_array($fld,$selectFields))
                $selectFields = array_merge($selectFields,array($fld => 'Resource.'.$fld));
        }
        $c->select($selectFields);

        $useTVs = array();
        /* Make sure we don't have duplicates */
        foreach ($this->tvs as $tv) {
            if (!in_array($tv,$useTVs))
                $useTVs[] = $tv;
        }
        /* Set up the sources */
        $tvSelect = array();
        foreach ($useTVs as $tv) {
            $tvSelect[] = array('`TemplateVar`.`name`' => $tv);
        }

        $c->where($tvSelect,xPDOQuery::SQL_OR);

        $fldMtch = array();
        foreach ($this->matchData as $data)
            $fldMtch[] = array('value:LIKE' => "%$data%");

        $c->where($fldMtch,xPDOQuery::SQL_OR);

        $c->sortby($this->config['tvSort'],$this->config['tvSortDir']);
        $c->limit($this->config['tvSample']);

        $c->andCondition(
            array(
                'Resource.id:!=' => $this->resource->get('id'),
                'Resource.context_key:IN' => $this->config['contexts'],
            )
        );
        if (!empty($this->config['parents']))
            $c->andCondition(array('Resource.parent:IN' => $this->config['parents']));

        if (!$this->config['includeUnpublished']) {
            $c->where(array('Resource.published' => 1));
        }
        if (!$this->config['includeHidden']) {
            $c->where(array('Resource.hidemenu' => 1));
        }

        if ($this->config['debug']) {
            $c->prepare();
            echo $c->toSQL();
        }

        $col = $this->modx->getCollection('modTemplateVarResource',$c);
        /* @var modTemplateVarResource $item */
        foreach ($col as $item) {
            if ($item instanceof modTemplateVarResource) {
                $array = $item->toArray('',false,true);
                foreach ($array as $key => $fld) {
                    if ($key == 'value' || $key == 'name') continue;
                    $this->related[$array['id']][$key] = $fld;
                }
                $this->related[$array['id']][$array['name']] = $array['value'];
            }
        }
        return true;
    }

    /**
     * Calculates a rank for every related resource based on individual field rankings.
     *
     * @return array
     */
    private function _calculateRelatedRank() {
        $tmpArray = array();

        /* loop through related resources */
        foreach ($this->related as $array) {
            $rank = 0;
            /* Loop through fields & TVs and each fields' value */
            foreach (array_merge($this->fields,$this->tvs) as $fld) {
                foreach ($this->matchData as $match) {
                    /* Calculate a rank and add it to the total resource rank */
                    if ((strlen($array[$fld]) > 0) && !empty($match)) {
                        $count = substr_count(strtolower($array[$fld]),$match);
                        if ($count > 0) $rank += $count * $this->weight[$fld];
                    }
                }
            }
            $tmpArray[] = array_merge(array(
                'rank' => $rank,
            ),$array);
        }

        /* Sort on rank (hi>lo) and if equal on ID (hi>lo) */
        uasort(
            $tmpArray,
            array($this, 'mysort')
        );

        $this->related = $tmpArray;
        return true;
    }

    /**
     * Simple custom sort function to sort on rank first, and when equal on ID (assuming the highest ID is the most recent resource).
     * @param $a
     * @param $b
     * @return int
     */
    function mysort ($a, $b) {
        if ($a['rank'] == $b['rank'])
            return $a['id'] < $b['id'] ? 1 : -1;
        return $a['rank'] < $b['rank'] ? 1 : -1;
    }
}

?>