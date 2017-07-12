<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Kais</title>
	<?php echo Asset::css('bootstrap.css'); ?>
	<?php echo Asset::css('codeflask.css'); ?>
	<?php echo Asset::css('prism.css'); ?>
	<?php echo Asset::css('pretty-json.css'); ?>
	<?php echo Asset::js('jquery.min.js'); ?>
	<?php echo Asset::js('prism.js'); ?>
	<?php echo Asset::js('codeflask.js'); ?>
	<?php echo Asset::js('underscore-min.js'); ?>
	<?php echo Asset::js('backbone-min.js'); ?>
	<?php echo Asset::js('pretty-json-min.js'); ?>
	<style type="text/css">
		#editor {
			height: 300px;
			border: 1px solid gray;
			background-color: black;
			caret-color: white;
		}
	</style>
</head>
<body>
	<br/><br/><br/>
	<div class="container">
		<div class="panel panel-default">
		<!-- Default panel contents -->
		<div class="panel-heading">PHP Code</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<div id="editor"></div>
				</div>
				<br/>
				<div class="col-md-12">
					<pre id="php_result">
					</pre>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	var flask = new CodeFlask;
	flask.run('#editor', { language: 'php', lineNumbers: true });

	function run_php() {
		var formData = {code: flask.textarea.value};
		$.ajax({
			url : "/kais/public/test/run_php",
			type: "POST",
			data : formData,
			success: function(response, textStatus, jqXHR)
			{
				var data;
				try {
					response = JSON.parse(response);
					if(response.type == 'json') {
						var data_source = JSON.parse(response.data);
						var node = new PrettyJSON.view.Node({
						  el:$('#php_result'),
						  data: data_source
						});
						node.expandAll();
					} else {
						$("#php_result").text(response);
					}
				} catch(e) {
					$("#php_result").text(response);
				}
			},
			error: function (response, textStatus, errorThrown)
			{
				$("#php_result").text(response);
			}
		});
	}


	$(document).keydown(function(event) {
		// If Control or Command key is pressed and the S key is pressed
		// run save function. 83 is the key code for S.
		if((event.ctrlKey || event.metaKey) && event.which == 83) {
			// Save Function
			event.preventDefault();
			run_php();
			return false;
		}
	});
</script>
</html>
