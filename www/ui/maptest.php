<!DOCTYPE html>
<html>
  <head>
    <link type="text/css" rel="stylesheet" href="bootstrap/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="bootstrap/css/stylesheet.css" />
    <meta charset="utf-8">
    <title>Geocoding service</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      #panel {
        position: absolute;
        top: 5px;
        left: 50%;
        margin-left: -180px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script type="text/javascript" src="js/maps/maps.js">

    </script>
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
    <br/><br/>

            
            
    <div id="map-canvas" class="container"></div>

    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    
    <script type="text/javascript">
    	$(function(){
    		//initialize();
    		//codeAddress('India');
            var urlParams;
            (window.onpopstate = function () {
                var match,
                    pl     = /\+/g,  // Regex for replacing addition symbol with a space
                    search = /([^&=]+)=?([^&]*)/g,
                    decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
                    query  = window.location.search.substring(1);

                    urlParams = {}; 
                    while (match = search.exec(query))
                    urlParams[decode(match[1])] = decode(match[2]);
            })();
            var source = (urlParams["source"]);
            var destination = (urlParams["destination"]);
      	
            initializeMapData(source,destination);

    	});
    </script>
    <!--Including the javascript files-->
    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
  </body>
</html>

