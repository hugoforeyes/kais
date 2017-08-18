<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Kais</title>
	<?php echo Asset::css('bootstrap.css'); ?>
	<?php echo Asset::css('style.css'); ?>
	<?php echo Asset::js('jquery.min.js'); ?>
	<?php echo Asset::js('storage.js'); ?>
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
				local_storage.set('history', msg);
			} else if (e.keyCode == 38) {
				var pre_message = local_storage.get('history') || "";
				if(pre_message)
					$(this).val(pre_message); 
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
			success: function(response, textStatus, jqXHR)
			{
				add_message(response.data.message, "you");
				read_message(response.data.link);
				create_info_box(response.data);
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('error');
			}
		});
	}

	function read_message(link, audio, repeat_count) {
		if ( ! repeat_count)
			repeat_count = 1;
		if (repeat_count == 3)
			return;
		if ( ! audio) {
			audio = document.createElement('audio');
	    	audio.setAttribute('src', link);
	    	audio.addEventListener("loadeddata",function() {
	    		audio.play();
	    	});
		}
	}

	function create_info_box(data) {
		switch(data.type) {
			case 1: return; //Normal message
			case 2: //Movie list
				var html = "<div class='msg-movie-list info-box'>";
				html += '<div class="row">';
				for (var i in data.data) {
					html += '<div class="col-md-3">';
					html += '<div class="movie-box" onclick="auto_message(\'Xem phim số '+(parseInt(i) + 1)+'\')">';
					html += '<div class="movie-box-img">';
					html += '<img src="'+data.data[i].img+'"/>';
					html += '<div class="movie-box-release">'+data.data[i].release_date+'</div>';
					html += '<div class="movie-box-number">#'+(parseInt(i) + 1)+'</div>';
					html += '</div>';
					html += '<div class="movie-box-name">'+data.data[i].name+'</div>';
					html += '</div>';
					html += '</div>';
					if((parseInt(i)+1)%4 == 0) {
						html += '</div>';
						html += '<div class="row">';
					}
				}
				html += "</div>";
				html += "</div>";
				$("#chatbox").append(html);
				$("#chatbox").scrollTop($("#chatbox")[0].scrollHeight);
				return;
			case 3: //Detail film
				var html = "<div class='movie-detail info-box'>";
				html += '<div class="row">';
				html += '<div class="col-md-4">';
				html += '<div class="movie-info">';
				html += '<div class="movie-detail-name-vi">'+data.data.vi_name+'</div>';
				html += '<div class="movie-detail-name-en">'+data.data.en_name+'</div>';
				html += '<div class="movie-detail-info">'+data.data.info+'</div>';
				html += '<div class="movie-detail-des">'+data.data.description+'</div>';
				html += '<div class="movie-detail-date">'+data.data.publish_date+'</div>';
				html += '</div>';
				html += '</div>';
				html += '<div class="col-md-8" align="center">';
				html += "<img src='"+data.data.poster+"' class='img-thumbnail movie-detail-poster'/>"
				html += "</div>";
				html += "</div>";
				$("#chatbox").append(html);
				$("#chatbox").scrollTop($("#chatbox")[0].scrollHeight);
				return;
			case 4: //youtube
				html = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'+data.data+'?autoplay=1" frameborder="0" allowfullscreen></iframe>';
				$("#chatbox").append(html);
				$("#chatbox").scrollTop($("#chatbox")[0].scrollHeight);
				return;
			case 5: //Vietlott
				html = '<div style="margin-top:20px">';
				data = JSON.parse(data.data);
				for (var i = 1; i < 7; i++) {
					html += '<span class="vietlott-num">'+data["num_"+i]+'</span>';
				}
				html += '</div>';
				$("#chatbox").append(html);
				return;
		}
	}

	function auto_message(msg) {
		add_message(msg, "me");
		send_message(msg);
	}
</script>
</html>
