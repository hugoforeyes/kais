<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
	<title>Phim</title>
	<link type="text/css" rel="stylesheet" href="<?php echo Uri::create('/', array(), array(), true)."assets/css/bootstrap.css"; ?>">
	<link type="text/css" rel="stylesheet" href="<?php echo Uri::create('/', array(), array(), true)."assets/css/style.css"; ?>">
	<script type="text/javascript" src="<?php echo Uri::create('/', array(), array(), true)."assets/js/jquery.min.js"; ?>"></script>
</head>
<body>
<script>
(function(d, s, id){
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.com/en_US/messenger.Extensions.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'Messenger'));


window.extAsyncInit = function() {
    $("#testbtn").click(function() {
    	$("#abc").html("123");
    	// MessengerExtensions.requestCloseBrowser(function success() {
  			$.post("<?php echo Uri::create('/api/fb_message/', array(), array(), true)?>",
		    {
		        msg: "Xem phim số 1",
		        sender: "<?php echo $sender; ?>"
		    },
		    function(data, status) {
		    	MessengerExtensions.requestCloseBrowser(function success() {
		        }, function error(err) {
		  
		        });
		    });
    });
};

</script>


	<div class="container">
		<div class="row msg-movie-list">
			


			<?php foreach ($films as $index => $film) { ?>
				<div class="col-xs-6">
					<div class="movie-box" style="max-width: 150px; max-height: 277px;">
						<div class="movie-box-img">
							<img src="<?php echo $film['img'] ?>" style="max-width: 136px;">
						</div>
						<div class="movie-box-release"><?php echo $film['release_date'] ?></div>
						<div class="movie-box-number">#<?php echo $index + 1; ?></div>
						<div class="movie-box-name"><?php echo $film['name'] ?></div>
					</div>
				</div>
			<?php } ?>
		</div>
		<div>		
			<button class="btn btn-default" id="testbtn"">Send</button>
			<span id="abc"></span>
		</div>
	</div>
</body>
</html>
