<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
	<title>White List</title>
	<?php echo Asset::css('bootstrap.css'); ?>
	<?php echo Asset::js('jquery.min.js'); ?>
</head>
<body>
	<br/>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<form method="POST">
					<span style="display: inline-block;">Domain: </span>
					<input type="text" name="domain" class="form-control" style="display: inline-block; width: 80%;" />
					<button class="btn btn-default" name="submit" style="display: inline-block;" value="add">Add</button>
					<button class="btn btn-danger" name="submit" style="display: inline-block;" value="del">Delete</button>
				</form>
			</div>
		</div>
		<br/>

		<table class="table table-hover">
			<thead>
				<th>Domain</th>
			</thead>
			<tbody>
				<?php foreach ($data as $domain) { ?>
					<tr>
						<td><?php echo $domain ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</body>
</html>
