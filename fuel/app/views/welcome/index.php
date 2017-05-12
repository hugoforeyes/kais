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
		<div class="row">
			<div class="col-md-12 well chatbox" id="chatbox">
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<textarea class="form-control" rows="3" id="message-box"></textarea>
			</div>
		</div>
	</div>
</body>

<script type="text/javascript">
	$(document).ready(function() {
		$("#message-box").focus();
		$("#message-box").keyup(function(e) {
			if (e.keyCode == 13 && !e.shiftKey) {
				var msg = $(this).val().trim();
				$(this).val("");
				if(!msg)
					return;
				add_message(msg, "me");
				send_message(msg);
			}
		});
	});

	function add_message(msg, role) {
		if (! msg)
			return;
		var html = '<div class="message-container">';
		html += '<div class="message '+role+'">';
		html += msg;
		html += '</div>';
		html += '</div>';
		$("#chatbox").append(html);
		$("#chatbox").scrollTop($("#chatbox")[0].scrollHeight);
	}

	function send_message(msg) {
		if (! msg)
			return;
		var formData = {msg: msg};
		$.ajax({
			url : "/kais/public/api/listen",
			type: "POST",
			data : formData,
			success: function(data, textStatus, jqXHR)
			{
				add_message(data.message, "you");
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('error');
			}
		});
	}
</script>
</html>