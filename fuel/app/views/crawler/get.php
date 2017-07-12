<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Kais</title>
	<?php echo Asset::css('bootstrap.css'); ?>
	<?php echo Asset::css('style.css'); ?>
	<?php echo Asset::css('pretty-json.css'); ?>
	<?php echo Asset::js('jquery.min.js'); ?>
	<?php echo Asset::js('underscore-min.js'); ?>
	<?php echo Asset::js('backbone-min.js'); ?>
	<?php echo Asset::js('pretty-json-min.js'); ?>
</head>
<body>
	<br/>
	<div class="container">
		<a class="btn btn-info" href="<?php echo Uri::create('crawler/'); ?>">Back</a>
		<br/><br/>
		<div class="row">
			<div class="col-md-6">
				<div class="well" id="source" style="height: 780px;overflow: auto;">

				</div>
			</div>
			<div class="col-md-6">
				<div class="well" id="result" style="height: 780px;overflow: auto;">

				</div>
			</div>
		</div>
	</div>
</body>

<script type="text/javascript">
var data_crawler = JSON.parse('<?php echo str_replace(array("\\n","\\r"),"",html_entity_decode(json_encode($data, JSON_UNESCAPED_UNICODE))); ?>');
var node = new PrettyJSON.view.Node({
  el:$('#result'),
  data: data_crawler
});
node.expandAll();

var data_source = JSON.parse('<?php echo html_entity_decode(json_encode($info, JSON_UNESCAPED_UNICODE)); ?>');
var node = new PrettyJSON.view.Node({
  el:$('#source'),
  data: data_source
});
node.expandAll();
</script>
</html>
