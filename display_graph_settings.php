<?php
	/*$n_attributes = count($net['attributes']);
	$n_nodes = count($net['nodes']);
	$n_edges = count($net['edges']);*/
?>
<!-- 
<div id="graphSettings">
	<h1>Your network</h1>
	<br />
	<h2><strong><?php //echo $n_attributes; ?></strong> Attributes</h2>
	<ul>
		<?php
			/*
			foreach($current_net['attributes'] as $attribute) {
				echo "<li><strong>" . $attribute['name'] . "</strong> (Weight = <strong>" . $attribute['weight'] . "</strong>)<ul>";
				foreach($attribute['domain'] as $domainValue) {
					echo "<li>$domainValue</li>";
				}
				echo "</ul></li>";
			}
			*/
		?>
	</ul>
	<br />
	<h2><strong><?php //echo $n_nodes; ?></strong> Nodes</h2>
	<div id="nodes">
		<?php
			/*
			foreach($current_net['nodes'] as $nodeIndex => $node) {
				echo "<div class='node'><h1>[" . $nodeIndex . "] " . $node['label'] . "</h1><ul>";
				foreach($node['attributes'] as $attribute) {
					echo "<li><strong>" . $attribute['name'] . "</strong>: " . $attribute['value'];
				}
				echo "</ul></div>";
			}
			*/
		?>
	</div>
	<br />
	<h2><strong><?php //echo $n_edges; ?></strong> Edges</h2>
	<ul>
		<?php
		/*
			foreach($current_net['edges'] as $edge) {
				echo "<li>" . $current_net['nodes'][$edge['from']]['label'] . " <-> " . $current_net['nodes'][$edge['to']]['label'] . "</li>";
			}
			*/ 
		?>
	</ul>
	
	<br /><br />
	<h2>Add Nodes</h2>
	<div id="addNodeForm">
		Label: <input type="text" name="label" />
		<br />
		<button type="button" id="addNodeButton">Add Node</button>
	</div>
	<br /><br />
	<h2>Add Edges</h2>
	<div id="addEdgeForm">
		From: <input type="text" name="from" />
		To: <input type="text" name="to" />
		<br />
		<button type="button" id="addEdgeButton">Add Edge</button>
	</div>
	<br /><br />
	<h2>Network JSON</h2>
	<textarea id="fileJson"><?php //echo $file_string; ?></textarea>
</div
 -->