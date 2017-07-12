<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Kais</title>
	<?php echo Asset::css('bootstrap.css'); ?>
	<?php echo Asset::css('style.css'); ?>
	<?php echo Asset::js('jquery.min.js'); ?>
</head>
<body>
	<br/><br/><br/>
	<div class="container">
		<div class="pull-right">
			<a class="btn btn-default" href="<?php echo Uri::create('crawler/create/') ?>">Create new one</a>
		</div>
		<table class="table table-hover">
			<thead>
				<th>ID</th>
				<th>Name</th>
				<th>Website</th>
				<th>Action</th>
			</thead>
			<tbody>
				<?php foreach ($data as $item) { ?>
					<tr>
						<td><?php echo $item->id; ?></td>
						<td><?php echo $item->name; ?></td>
						<td><?php echo $item->website; ?></td>
						<td>
							<a class="btn btn-primary" href="<?php echo Uri::create('crawler/get/').$item->id; ?>">Get data</a>
							<a class="btn btn-info" href="<?php echo Uri::create('crawler/create/').$item->id; ?>">Edit</a>
							<a class="btn btn-danger" href="<?php echo Uri::create('crawler/delete/').$item->id; ?>">Delete</a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</body>

</html>
