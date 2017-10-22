<?php require_once('Connections/localhost.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    	<title>PT. Putra Mutiara Jaya (Printmate)</title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script src="includes/jquery/jquery-1.10.2.js"></script>
<script src="includes/jquery/jquery-ui-custom.js"></script>
<script src="includes/jquery/maskedinput.js"></script>
<script src="includes/bootstrap/js/bootstrap.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script>
function initialize() {
  var myLatlng = new google.maps.LatLng(9.9944167,122.8131111);
  var mapOptions = {
    zoom: 17,
    center: myLatlng
  }
  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Hello World!'
  });
}

google.maps.event.addDomListener(window, 'load', initialize);
    </script>
</head>
<body>
	<div class="main_container" >
        <a href="index.php"><img src="images/logoprintmate.png" align="left" /></a>
            <div id="headr_img">
                <span id="main_nav"> 
                	   	<a href="index.php">Home</a> |  
						<a href="catalogue.php">Galley</a> |  
                        <a href="reserve.php">Booking Service</a> |  
                        <a href="contact.php">Contact Us</a>
	            </span>
            </div>
   <div id="content_container">
  		<h2 id="home_header">Contact Us</h2>  
           <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.4761664504454!2d107.62141391449795!3d-6.953021694976641!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e85f2cf1d807%3A0xb7cb9a670db4c623!2sJl.+Batununggal+Indah+Raya%2C+Mengger%2C+Bandung+Kidul%2C+Kota+Bandung%2C+Jawa+Barat!5e0!3m2!1sid!2sid!4v1507604136385" width="900" height="450" frameborder="0" style="border:0" allowfullscreen></iframe></a>
    <div id="map-canvas"></div><br />
    <strong>Street Address:</strong><br />
Jalan Batununggal Indah, Mengger,<br/>
Bandung Kidul, Kota Bandung,<br/>
Jawa Barat 40266.<br/><br/>
<strong>For Inquiries, Please Call:</strong><br/>
<strong><i class="fa fa-phone-square"></i>:</strong> (+62 22) 7509191
   </div>
         <div id="footer_container">
         	Copyright © 2017 Toni Wahyudi - TA_MI Piksi Ganesha
         </div>
	</div>

</body>
</html>