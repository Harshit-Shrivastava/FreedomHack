<!DOCTYPE>

<html>
<head>
	<title>
		GoGreen
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
	<link type="text/css" rel="stylesheet" href="bootstrap/css/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="bootstrap/css/stylesheet.css" />
	<script src="bootstrap/js/jquery.js"></script>
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
					<li><a href="mails.php">Mails</a></li>
					<li><a href="new_plans.php">New Plans</a></li>
					<li><a href="faqs.php">FAQs</a></li>
					
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
					Here 's your next travel plan
					<br/><br/>

					<script type="text/javascript">
						  var msg_date;
						  var arrival_time=new Array();
						  var departure_time = new Array();
						  var arrivals = new Array();
						  var departures = new Array();
						  $.getJSON("mailfetcher.php", function( data ) {
       							//initialize(data);
       							msg_date = data.flight_date;
       							for (var i = 0; i < 3; i++) {
       								arrival_time[i]=data.arrival_time[i];
       								departure_time[i]=data.departure_times[i];
       								arrivals[i] = data.arrivals[i];
       								departures[i]=data.departures[i];

       								var $flight_i = $('<div/>', {
       									'class': 'col-xs-12 col-md-12 box'
       								});

       								var $row = $('<div/>', {
       									'class': 'row'
       								});

       								var $dep = $('<div/>', {
       									'class': 'col-xs-4 col-md-4'
       								});

       								var $flight = $('<div/>', {
       									'class': 'col-xs-4 col-md-4'
       								});

       								var $arr = $('<div/>', {
       									'class': 'col-xs-4 col-md-4'
       								});


       								$dep.append("<h3>" + departures[i] + "</h3><br />");
       								$dep.append("<h4>" + departure_time[i] + "</h4><br />");

       								$flight.append("<br/><img src='images_ads/flight.png' class='img-responsive' alt='Travelling to'/>");

       								$arr.append("<h3>" + arrivals[i] + "</h3><br />");
       								$arr.append("<h4>" + arrival_time[i] + "</h4>");

       								$row.append($dep);
       								$row.append($flight);
       								$row.append($arr);

       								$row.trigger('create');
       								$arr.trigger('create');
       								$dep.trigger('create');
       								$flight.trigger('create');
       								$flight_i.append($row);
       								$flight_i.append("<br/>");

       								var $a = $('<a/>', {
       									'href': 'maptest.php?source=' + departures[i] + '&destination=' + arrivals[i]
       								});


       								$a.append($flight_i);

       								$('#map-data').append($a);
       								$flight_i.trigger('create');
									
									      								
       							};
   						});

					</script>
					<div id="map-data">
						
					</div>
					<br/>

				</div>
				<br/>
				<br/>
				<div class="row">
					
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
	
	<script src="bootstrap/js/bootstrap.js"></script>
</body>
</html>