<?php 

function pre_proccess(&$net) {
	$net['degree_sum'] = 0;
	foreach($net['nodes'] as $key => $node) {
		$net['nodes'][$key]['degree'] = 0;
	}
	foreach($net['edges'] as $edge) {
		$net['nodes'][$edge['from']]['degree']++;
		$net['nodes'][$edge['to']]['degree']++;
		$net['degree_sum'] += 2;
	}
	
	return $net;
}

// A(i, p)
function get_attr($net, $i, $p) {
	if (!isset($net['nodes'][$i]) && !isset($net['nodes'][$i]['attributes'])) {
		return null;
	}
	
	foreach($net['nodes'][$i]['attributes'] as $attribute) {
		if ($attribute['name'] == $p) {
			return $attribute['value'];
		}
	}
	
	return null;
}

// alpha(p)
function alpha($net, $p) {
	foreach($net['attributes'] as $attribute) {
		if ($attribute['name'] == $p) {
			return $attribute['weight'];
		}
	}
}

// m(i, j, p)
function match($net, $i, $j, $p) {
	if (get_attr($net, $i, $p) == get_attr($net, $j, $p)) {
		return alpha($net, $p);
	}
	
	return 0.0;
}

// I(i, j)
function initial_attractiveness($net, $i, $j) {
	$attr = 0;
	foreach($net['attributes'] as $attribute) {
		$attr += match($net, $i, $j, $attribute['name']);
	}
	
	return $attr;
}

// k(i)
function degree($net, $i) {
	return $net['nodes'][$i]['degree'];
}

// Sum(k(i)), p/ todo i
function degree_sum($net) {
	return $net['degree_sum'];
}

// P(i) - Barabasi-Albert pi function
function P($net, $i) {
	return degree($net, $i) / degree_sum($net);
}

// pi(i, j)
function pi_complex($net, $C, $i, $j) {
	$p = P($net, $i);
	$attr = initial_attractiveness($net, $i, $j) * $C;
	
	$total = $attr + $p;

	if ($total > 1) {
		return 1.0;
	} 
	return $total;
}

function add_edge(&$net, $i, $j) {
	$edge = array('from' => $i, 'to' => $j);
	array_push($net['edges'], $edge);
	$net['nodes'][$i]['degree']++;
	$net['nodes'][$j]['degree']++;
	$net['degree_sum'] += 2;
}

function add_node(&$net, $C, $m) {
	$n = count($net['nodes']);
	$currentIndex = $n;
	
	$attributes = array();
	
	foreach($net['attributes'] as $attribute) {
		$n_values = count($attribute['domain']);
		
		$attr_array = array('name' => $attribute['name'], 'value' => $attribute['domain'][rand(0, $n_values - 1)]);
		array_push($attributes, $attr_array);
	}
	
	$node = array('label' => 'Node ' . $currentIndex, 'attributes' => $attributes, 'degree' => 0);
	
	$net['nodes'][$currentIndex] = $node;

	$response_edges = array();
	
	$connected = 0;
	$nChecked = 0;
	$checkedArray = array();
	
	for($i = 0; $i < $n && $connected < $m; $i++) {
		$rand = rand(0, 100) / 100.0;
		$pi = pi_complex($net, $C, $i, $currentIndex);
			
		if ($rand < $pi) {
			add_edge($net, $currentIndex, $i);
			array_push($response_edges, $i);
			$connected++;
		}
	}
	
	$_SESSION['current_net'] = $net;
	
	$response = array('label' => "Node $currentIndex", 'edges' => $response_edges);
	
	return $response;
}

function aux_log($string) {
	$file = 'log.txt';
	$current = file_get_contents($file);
	$current .= $string;
	file_put_contents($file, $current);
}
?>