<!DOCTYPE>

<html>
<head>
	<title>
		GoGreen
	</title>
	<link type="text/css" rel="stylesheet" href="bootstrap/css/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="bootstrap/css/stylesheet.css" />
</head>

<body>
	<!-- Fixed navigation bar with drop-down menu -->
	
	<!--Creates a fixed navigation bar at the top-->
	<div class="navbar navbar-default navbar-fixed-top sml-nav-shade">
		<!--This will place our navigation bar in the center-->
		<div class="container">
			<!--Navbar contains a header and button links-->
			<!--Header starts-->
			<div class="navbar-header" >
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="../index" class="navbar-brand" style="font-size:30px;font-family:'Trebuchet MS', Helvetica, sans-serif;">
					<b><font color="#CCCCCC">Go</font><font color="#9B9B9B">Green</font></b>
				</a>
			</div>
			<!--Header ends-->
			<!--Creating other links and button in navbar-->
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="mails">Mails</a></li>
					<li><a href="new_plans">New Plans</a></li>
					<li><a href="faqs">FAQs</a></li>
					<li><a href="settings">Settings</a></li>
				</ul>
			</div>
		</div>
	</div>

	<!--Navigation bar ends here-->
	<br/><br/><br/>

	<!--Body content starts here-->
	<div class="container">

		<div class="row">
			
			<div class="col-xs-12 col-md-9" style="min-height:500px;overflow:hidden">
				<div class="row">
					<br/>
					Plannig a new travel. Let 's help you &#128522; 
					<br/><br/>
					<div class="col-xs-12 col-md-12 box" style="min-height:200px">
						<div class="row">
							<br/>
							Please share your travel details with us
							<br/>
							<br/>
							<!--Starting place for the form-->
							<form class="form-inline" role="form" action="maptest" method="get">
  								<div class="form-group">
    								<label class="sr-only" for="source">Source</label>
    								<input type="text" class="form-control" id="source" placeholder="Enter Source">
  								</div>
  								<div class="form-group">
    								<label class="sr-only" for="destination">Destination</label>
    								<input type="text" class="form-control" id="destination" placeholder="Enter Destination">
  								</div>
  								<button type="submit" class="btn btn-primary">Find</button>
							</form>
							<!--Ending place for the form-->
							<br/>
							<br/>
						</div>
					</div>
					<br/>
				</div>
				<br/>
				<br/>
				<div class="row">
					<div class="col-xs-12 col-md-12" style="position:absolute; bottom:0px;">
						<center><img src="images_ads/horizontal.png" class="img-responsive" alt="ads" /></center>
					</div>
				</div>
			
			</div>
			<div class="col-md-2 pull-right hidden-xs" id="right-side pane" style="overflow:hidden">
				<div class="row">
					<div class="">
						<img src="images_ads/skyscraper.png" class="img-responsive" alt="ads" />
					</div>
					<br/><br/>

				</div>
			</div>
		</div>
			
	</div>

	<!--Body content ends here-->

	<!--Including the javascript files-->
	
	<script src="bootstrap/js/jquery.js"></script>
	<script src="bootstrap/js/bootstrap.js"></script>
	
</body>
</html>