<?php

// Builds eldor combinations tree with an empty arrays at the end
//					  [1 => ...]
//		[2 => []]					[3 => []]			
//
function combo_builder($combo, $start_index = 0) {
	$next_level = [];
	
	$left = array_slice($combo,
		0, $start_index);
	$right = array_slice($combo,
		$start_index + 1, count($combo) - $start_index + 1);
	
	foreach (array_diff([1, 2, 3], [$combo[$start_index]]) as $mod) {
		$next_level[] = array_merge($left, [$mod], $right);
	}

	if ($start_index === count($combo) - 1) { // last level
		$next_next_level = [];

		foreach ($next_level as $comb) {
			 $next_next_level[implode("", $comb)] = [];
		}

		return $next_next_level;
	} else { // dig deeper
		$next_next_level = [];

		foreach ($next_level as $comb) {
			 $next_next_level[implode("", $comb)] = 
			 	combo_builder($comb, $start_index + 1);
		}

		return $next_next_level;
	}
}

// Flatten combinations from the tree to 1D array
function flatten_tree($tree) {
	$keys = array_keys($tree);

	if ($tree[$keys[0]] === []) { // edge node
		return $keys;
	}
	else {
		if (count($tree) === 1) {
			return array_merge($keys,
				flatten_tree($tree[$keys[0]]));	
		} else {
			return array_merge($keys,
				flatten_tree($tree[$keys[0]]), 
				flatten_tree($tree[$keys[1]]));
		}
	}
}

// Prettifying json representation of input parameter
function enc($toJson) {
	return json_encode($toJson, JSON_PRETTY_PRINT);
}

// Print stat of combo generations
function echo_stat($input, $combos_flt) {
	echo "Total combos num from " . implode("", $input) . ": " . count($combos_flt) . "\n";
	echo "Unique combos num from " . implode("", $input) . ": " . count(array_unique($combos_flt)) . "\n";
}

/* Start */

$input1 = [1, 1, 1, 1, 1, 1];
$combos1 = combo_builder($input1);
$combos_flt1 = flatten_tree($combos1);
// echo enc($combos1) . "\n";
// echo enc($combos_flt1) . "\n";
echo_stat($input1, $combos_flt1);

$input2 = [2, 2, 2, 2, 2, 2];
$combos2 = combo_builder($input2);
$combos_flt2 = flatten_tree($combos2);
// echo enc($combos1) . "\n";
// echo enc($combos_flt1) . "\n";
echo_stat($input2, $combos_flt2);

$input3 = [3, 3, 3, 3, 3, 3];
$combos3 = combo_builder($input3);
$combos_flt3 = flatten_tree($combos3);
// echo enc($combos1) . "\n";
// echo enc($combos_flt1) . "\n";
echo_stat($input3, $combos_flt3);

echo_stat([1, 2, 3], array_merge($combos_flt1, $combos_flt2, $combos_flt3));