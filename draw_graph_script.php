<script>
	$(document).ready(function() {
		var nodes = {};

		var windowWidth = $(window).width();
		var graphHeight = $(window).height();
		var animationSpeed = parseInt($('#currentSpeedInput').val() );
		var newNodeColor = $('#newNodeColor').val();
		var m = parseInt($('#m').val() );
		var c = parseFloat($('#c').val() );
		var t = 0;
		
		var sigRoot = document.getElementById('sigma');
		var sigInst = sigma.init(sigRoot);
		
		sigInst.drawingProperties({
			defaultLabelColor: '#fff',
			defaultLabelBGColor: '#fff',
			defaultLabelSize: 12,
			defaultLabelHoverColor: '#000',
		    labelThreshold: 9,
			font: 'Arial',
			edgeColor: 'source',
			//defaultEdgeType: 'curve'
		});
		
		sigInst.graphProperties({
			minNodeSize: 2,
			maxNodeSize: 4
		});

		<?php foreach($current_net['nodes'] as $nodeIndex => $node) { ?>
				var x = Math.floor((Math.random() * windowWidth) + 0);
				var y = Math.floor((Math.random() * graphHeight) + 0);
				sigInst.addNode(<?php echo $nodeIndex; ?>, {
					label: <?php echo '"' . $node['label'] . '"'; ?>,
					color: '#' + <?php echo '"' . $initialColor . '"'; ?>,
					'x': x,
					'y': y,
					//color: 'rgb('+Math.round(Math.random()*256)+','+
	                    //Math.round(Math.random()*256)+','+
	                    //Math.round(Math.random()*256)+')'
				});
				//console.log('Adding X = ' + x + ' and Y = ' + y);
		<?php } ?>


		<?php foreach ($current_net['edges'] as $edge) { ?>
			addEdge(<?php echo $edge['from']; ?>, <?php echo $edge['to']; ?>);
		<?php } ?>
		sigInst.draw();

		var currentIndex = <?php echo count($current_net['nodes']); ?>;

		function addNode(label) {
			var x = Math.floor((Math.random() * windowWidth) + 0);
			var y = Math.floor((Math.random() * graphHeight) + 0);
			sigInst.addNode(currentIndex, {
				label: label,
				color: '#' + newNodeColor,
				'x': x,
				'y': y
			});
			var nodeIndex = currentIndex;
			currentIndex += 1;
			return nodeIndex;
		}

		function addEdge(from, to) {
			sigInst.addEdge(from + "_" + to, from, to);
		}

		$('#addNodeButton').click(function(e) {
			e.preventDefault();
			var form = $('#addNodeForm');
			var label = form.find('input[name="label"]').val();
			addNode(label);
			sigInst.draw();
		});

		$('#addEdgeButton').click(function(e) {
			e.preventDefault();
			var form = $('#addEdgeForm');
			var from = form.find('input[name="from"]').val();
			var to = form.find('input[name="to"]').val();
			addEdge(from, to);
			sigInst.draw();
		});

		function growNet() {
			var url = 'ajax_grow_net.php?m=' + m + "&c=" + c;
			console.log("Calling " + url);
			
			$.ajax({
	            type : "GET",
	            url : url,
	            async: false,
	            dataType : "json",
	            success : function(result) {
					var nodeIndex = addNode(result.label);

					$.each(result.edges, function(i, value) {
						addEdge(nodeIndex, value);	
					});
					
					sigInst.draw();
					refreshTime();
					setTimeout(growNet, animationSpeed);
	            }
	        });
		}

		function refreshTime() {
			t++;
			$('#t').html(t);
		}

		function increaseSpeed() {
			animationSpeed -= 50;
			if (animationSpeed <= 0) {
				animationSpeed = 50;
			} 
		}
		function decreaseSpeed() {
			animationSpeed += 50; 
		}

		$('#increaseSpeed').click(function(e) {
			e.preventDefault();
			increaseSpeed();
			$('#currentSpeed').html(animationSpeed);
			$('#currentSpeedInput').val(animationSpeed);
		});

		$('#decreaseSpeed').click(function(e) {
			e.preventDefault();
			decreaseSpeed();
			$('#currentSpeed').html(animationSpeed);
			$('#currentSpeedInput').val(animationSpeed);
		});

		$('#stopAnimation').click(function(e) {
			e.preventDefault();
			animationSpeed = 100000000;
		});

		$('#resumeAnimation').click(function(e) {
			e.preventDefault();
			animationSpeed = parseInt($('#currentSpeedInput').val() );
			growNet();
		});

		$('#layoutGraph').click(function(e) {
			e.preventDefault();
			sigInst.startForceAtlas2();
		});
		$('#stopLayoutGraph').click(function(e) {
			e.preventDefault();
			sigInst.stopForceAtlas2();
		});

		$('#changeNewNodeColor').click(function(e) {
			e.preventDefault();
			newNodeColor = $('#newNodeColor').val();	
		});
		
		setTimeout(growNet, animationSpeed);
	});
</script>