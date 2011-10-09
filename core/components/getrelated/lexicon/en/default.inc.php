<?php

$_lang['getrelated'] = 'getRelated';
$_lang['getrelated.desc'] = 'List related pages.';
$_lang['getrelated.pagesfound'] = 'The following [[+count]] pages may interest you as well:';
$_lang['getrelated.error.loadingclass'] = 'Error loading class getRelated from [[+path]].';
$_lang['getrelated.error.nofields'] = 'No fields or template variables found to search in.';
$_lang['getrelated.error.nodistinctivedata'] = 'Error collecting distinctive data from the resource to match against.';
$_lang['getrelated.error.invalidresource'] = 'The specified or default resource is invalid.';

$_lang['getrelated.prop_desc.resource'] = 'Either the Resource ID to find related resources for or "current" or empty to find related for the current resource.';
$_lang['getrelated.prop_desc.fields'] = 'Comma separated list of fieldname:weight to use in the comparison. Prefix TVs with "tv.". Don\'t use the content unless you want to kill performance. Example of use: pagetitle:3,tv.MyTags:7,tv.MySubjects:15,introtext:2';
$_lang['getrelated.prop_desc.returnFields'] = 'Resource Fields (no TVs as of yet) to include in the eventual output.';
$_lang['getrelated.prop_desc.parents'] = 'Comma separated list of parents to use in finding related resources.';
$_lang['getrelated.prop_desc.parentsDepth'] = 'The depth to search parents for.';
$_lang['getrelated.prop_desc.contexts'] = 'Comma separated list of Contexts to search in.';
$_lang['getrelated.prop_desc.includeUnpublished'] = 'Also use unpublished resources in the result set.';
$_lang['getrelated.prop_desc.includeHidden'] = 'Also use resources marked as hidden in menus in the result set.';
$_lang['getrelated.prop_desc.limit'] = 'Number of results to output.';
$_lang['getrelated.prop_desc.fieldSample'] = 'Number of resources to use in comparing based on resource fields. Can have a huge impact on performance so if you\'re experiencing long load times, try decreasing this number.';
$_lang['getrelated.prop_desc.fieldSort'] = 'Resource field to sort by, used in conjunction with the fieldSample property.';
$_lang['getrelated.prop_desc.fieldSortDir'] = 'Sort direction for the fieldSort property.';
$_lang['getrelated.prop_desc.tvSample'] = 'Number of TV results to include (note: one resource can have more than one result depending on your fields property) when comparing against TV values.';
$_lang['getrelated.prop_desc.tvSort'] = 'Resource field to sort by in the TV query, used in conjunction with the tvSample property.';
$_lang['getrelated.prop_desc.tvSortDir'] = 'Sort direction for the tvSort property.';
$_lang['getrelated.prop_desc.tplOuter'] = 'Chunk name to as outer template, see default in core/components/getrelated/elements/snippets/chunks/.';
$_lang['getrelated.prop_desc.tplRow'] = 'Chunk name to as row template, see default in core/components/getrelated/elements/snippets/chunks/.';
$_lang['getrelated.prop_desc.noResults'] = 'Text or output when there are no related resources found.';
$_lang['getrelated.prop_desc.toPlaceholder'] = 'To output the results to a placeholder instead of directly, define the name of the placeholder here.';
$_lang['getrelated.prop_desc.rowSeparator'] = 'String to use as separator between rows.';
$_lang['getrelated.prop_desc.defaultWeight'] = 'Weight to assign to fields that don\'t have a weight set specifically.';
$_lang['getrelated.prop_desc.debug'] = 'Enable/disable debug mode. When enabled it will dump lots of information on screen.';

?>