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
    public $modx;
    public $config = array();
    public $stopwords = array('a','able','about','above','abroad','according','accordingly','across','actually','adj','after','afterwards','again','against','ago','ahead','ain\'t','all','allow','allows','almost','alone','along','alongside','already','also','although','always','am','amid','amidst','among','amongst','an','and','another','any','anybody','anyhow','anyone','anything','anyway','anyways','anywhere','apart','appear','appreciate','appropriate','are','aren\'t','around','as','a\'s','aside','ask','asking','associated','at','available','away','awfully','b','back','backward','backwards','be','became','because','become','becomes','becoming','been','before','beforehand','begin','behind','being','believe','below','beside','besides','best','better','between','beyond','both','brief','but','by','c','came','can','cannot','cant','can\'t','caption','cause','causes','certain','certainly','changes','clearly','c\'mon','co','co.','com','come','comes','concerning','consequently','consider','considering','contain','containing','contains','corresponding','could','couldn\'t','course','c\'s','currently','d','dare','daren\'t','definitely','described','despite','did','didn\'t','different','directly','do','does','doesn\'t','doing','done','don\'t','down','downwards','during','e','each','edu','eg','eight','eighty','either','else','elsewhere','end','ending','enough','entirely','especially','et','etc','even','ever','evermore','every','everybody','everyone','everything','everywhere','ex','exactly','example','except','f','fairly','far','farther','few','fewer','fifth','first','five','followed','following','follows','for','forever','former','formerly','forth','forward','found','four','from','further','furthermore','g','get','gets','getting','given','gives','go','goes','going','gone','got','gotten','greetings','h','had','hadn\'t','half','happens','hardly','has','hasn\'t','have','haven\'t','having','he','he\'d','he\'ll','hello','help','hence','her','here','hereafter','hereby','herein','here\'s','hereupon','hers','herself','he\'s','hi','him','himself','his','hither','hopefully','how','howbeit','however','hundred','i','i\'d','ie','if','ignored','i\'ll','i\'m','immediate','in','inasmuch','inc','inc.','indeed','indicate','indicated','indicates','inner','inside','insofar','instead','into','inward','is','isn\'t','it','it\'d','it\'ll','its','it\'s','itself','i\'ve','j','just','k','keep','keeps','kept','know','known','knows','l','last','lately','later','latter','latterly','least','less','lest','let','let\'s','like','liked','likely','likewise','little','look','looking','looks','low','lower','ltd','m','made','mainly','make','makes','many','may','maybe','mayn\'t','me','mean','meantime','meanwhile','merely','might','mightn\'t','mine','minus','miss','more','moreover','most','mostly','mr','mrs','much','must','mustn\'t','my','myself','n','name','namely','nd','near','nearly','necessary','need','needn\'t','needs','neither','never','neverf','neverless','nevertheless','new','next','nine','ninety','no','nobody','non','none','nonetheless','noone','no-one','nor','normally','not','nothing','notwithstanding','novel','now','nowhere','o','obviously','of','off','often','oh','ok','okay','old','on','once','one','ones','one\'s','only','onto','opposite','or','other','others','otherwise','ought','oughtn\'t','our','ours','ourselves','out','outside','over','overall','own','p','particular','particularly','past','per','perhaps','placed','please','plus','possible','presumably','probably','provided','provides','q','que','quite','qv','r','rather','rd','re','really','reasonably','recent','recently','regarding','regardless','regards','relatively','respectively','right','round','s','said','same','saw','say','saying','says','second','secondly','see','seeing','seem','seemed','seeming','seems','seen','self','selves','sensible','sent','serious','seriously','seven','several','shall','shan\'t','she','she\'d','she\'ll','she\'s','should','shouldn\'t','since','six','so','some','somebody','someday','somehow','someone','something','sometime','sometimes','somewhat','somewhere','soon','sorry','specified','specify','specifying','still','sub','such','sup','sure','t','take','taken','taking','tell','tends','th','than','thank','thanks','thanx','that','that\'ll','thats','that\'s','that\'ve','the','their','theirs','them','themselves','then','thence','there','thereafter','thereby','there\'d','therefore','therein','there\'ll','there\'re','theres','there\'s','thereupon','there\'ve','these','they','they\'d','they\'ll','they\'re','they\'ve','thing','things','think','third','thirty','this','thorough','thoroughly','those','though','three','through','throughout','thru','thus','till','to','together','too','took','toward','towards','tried','tries','truly','try','trying','t\'s','twice','two','u','un','under','underneath','undoing','unfortunately','unless','unlike','unlikely','until','unto','up','upon','upwards','us','use','used','useful','uses','using','usually','v','value','various','versus','very','via','viz','vs','w','want','wants','was','wasn\'t','way','we','we\'d','welcome','well','we\'ll','went','were','we\'re','weren\'t','we\'ve','what','whatever','what\'ll','what\'s','what\'ve','when','whence','whenever','where','whereafter','whereas','whereby','wherein','where\'s','whereupon','wherever','whether','which','whichever','while','whilst','whither','who','who\'d','whoever','whole','who\'ll','whom','whomever','who\'s','whose','why','will','willing','wish','with','within','without','wonder','won\'t','would','wouldn\'t','x','y','yes','yet','you','you\'d','you\'ll','your','you\'re','yours','yourself','yourselves','you\'ve','z','zero');

    /* @var modResource $resource */
    public $resource = null;
    public $fields = array();
    public $weight = array();
    public $tvs = array();
    public $matchData = array();
    public $related = array();

    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;
 
        $basePath = $this->modx->getOption('getrelated.core_path',$config,$this->modx->getOption('core_path').'components/getrelated/');
        $this->config = array_merge(array(
            'base_bath' => $basePath,
            'core_path' => $basePath,
            'model_path' => $basePath.'model/',
            'elements_path' => $basePath.'elements/',
        ),$config);

        $this->config['returnFields'] = explode(',',$this->config['returnFields']);
        $this->config['parents'] = !empty($this->config['parents']) ? explode(',',$this->config['parents']) : array();
        $this->config['contexts'] = !empty($this->config['contexts']) ? explode(',',$this->config['contexts']) : array();

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
    }

    /**
     * @param string $ctx Context name
     * @return bool
     */
    public function initialize($ctx = 'web') {
        switch ($ctx) {
            case 'mgr':
                $modelpath = $this->config['model_path'];
                $this->modx->addPackage('getrelated',$modelpath);
                $this->modx->lexicon->load('getrelated:default');
            break;
        }
        return true;
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
            $chunk = $this->_getTplChunk($name);
            if (empty($chunk)) {
                $chunk = $this->modx->getObject('modChunk',array('name' => $name),true);
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
     * @param int $resid
     * @param array $fields
     * @return array|false
     */
    public function getMatchData($resid = 0, $fields = array()) {
        if (!$this->resource) {
            if ($this->modx->resource->id == $resid) {
                $this->resource = $this->modx->resource;
            } else {
                $this->resource = $this->modx->getObject('modResource',$resid);
            }
        }
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
            if (!in_array(strtolower($v),$this->stopwords) && !in_array(strtolower($v),$filteredValues))
                $filteredValues[] = strtolower($v);
        }

        $this->matchData = $filteredValues;
        return $this->matchData;
    }

    public function getRelated() {
        if (empty($this->fields) && empty($this->tvs)) return 'No fields to search in.';
        if (empty($this->matchData)) return 'No data to match with';

        $this->_getFieldRelated();
        $this->_getTVRelated();
        $this->_calculateRelatedRank();

        return $this->related;
    }

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
        $c->andCondition(array('id:!=' => $this->resource->id ));
        $c->prepare();

        $col = $this->modx->getCollection('modResource',$c);
        foreach ($col as $item) {
            $array = $item->get($selectFields);
            if (!$this->related[$array['id']])
                $this->related[$array['id']] = $array;
        }

        return $this->related;
    }
    private function _getTVRelated() {
        /* get TV values */
        $c = $this->modx->newQuery('modTemplateVarResource');
        $c->innerJoin('modTemplateVar','TemplateVar');
        $c->innerJoin('modResource','Resource');
        $c->andCondition(array('contentid:!=' => $this->resource->id ));


        $selectFields = array('`Resource`.`id`','value','name');
        foreach ($this->config['returnFields'] as $fld) {
            if (!in_array($fld,$selectFields))
                $selectFields[] = $fld;
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
            $tvSelect[] = array('TemplateVar.name' => $tv);
        }

        $c->where($tvSelect,xPDOQuery::SQL_OR);

        $fldMtch = array();
        foreach ($this->fields as $fld) {
            foreach ($this->matchData as $data)
                $fldMtch[] = array('value:LIKE' => "%$data%");
        }
        $c->where($fldMtch,xPDOQuery::SQL_OR);

        if (!empty($this->config['parents'])) {
            $c->where(array(
                'Resource.parent:IN' => $this->config['parents'],
            ));
        }

        if (!$this->config['includeUnpublished']) {
            $c->where(array('Resource.published' => 1));
        }
        if (!$this->config['includeHidden']) {
            $c->where(array('Resource.hidemenu' => 1));
        }

        $returnFields = array('id','value','name');
        foreach ($this->config['returnFields'] as $fld) {
            if (!in_array($fld,$returnFields))
                $returnFields[] = $fld;
        }

        $col = $this->modx->getCollection('modTemplateVarResource',$c);
        foreach ($col as $item) {
            $array = $item->get($returnFields);
            foreach ($returnFields as $fld) {
                if ($fld == 'value' || $fld == 'name') continue;
                $this->related[$array['id']][$fld] = $array[$fld];
            }
            $this->related[$array['id']][$array['name']] = $array['value'];
        }
        return $this->related;
    }

    private function _calculateRelatedRank() {
        $tmpArray = array();

        /* loop through related resources */
        foreach ($this->related as $index => $array) {
            $rank = 0;
            /* Loop through fields & TVs and each fields' value */
            foreach (array_merge($this->fields,$this->tvs) as $fld) {
                foreach ($this->matchData as $match) {
                    /* Calculate a rank and add it to the total resource rank */
                    $count = substr_count(strtolower($array[$fld]),$match);
                    $rank += $count * $this->weight[$fld];
                }
            }
            $tmpArray[] = array_merge(array(
                'rank' => $rank,
            ),$array);
        }

        /* Sort on rank (hi>lo) and if equal on ID (hi>lo) */
        uasort(
            $tmpArray,
            function ($a, $b) {
                if ($a['rank'] == $b['rank'])
                    return $a['id'] < $b['id'] ? 1 : -1;
                return $a['rank'] < $b['rank'] ? 1 : -1;
            }
        );

        $this->related = $tmpArray;
        return $tmpArray;
    }
}

?>