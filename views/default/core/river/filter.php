<?php
/**
 * Content filter for river
 *
 * @uses $vars[]
 */

$type = get_input('type', 'all');
$subtype = get_input('subtype', '');

if ($subtype) {
	$selector = "type=$type&subtype=$subtype";
} else {
	$selector = "type=$type";
}

// create selection array
$options = array();
$options['type=all'] = elgg_echo('river:select', array(elgg_echo('all')));
$registered_entities = elgg_get_config('registered_entities');

if (!empty($registered_entities)) {
	foreach ($registered_entities as $type => $subtypes) {
		// subtype will always be an array.
		if (!count($subtypes)) {
			$label = elgg_echo('river:select', array(elgg_echo("item:$type")));
			$options["type=$type"] = $label;
		} else {
			foreach ($subtypes as $subtype) {
				$label = elgg_echo('river:select', array(elgg_echo("item:$type:$subtype")));
				$options["type=$type&subtype=$subtype"] = $label;
			}
		}
	}
}

$params = array(
	'id' => 'elgg-river-selector',
	'options_values' => $options,
	'value' => $selector,
);

$select = elgg_view('input/select', $params);

$input = elgg_format_element([
	'#tag_name' => 'label',
	'class' => 'elgg-river-selector',
	'#text' => elgg_format_element('span', [], elgg_echo('filter')) . " $select",
]);

echo elgg_format_element('div', ['class' => 'clearfix'], $input);
