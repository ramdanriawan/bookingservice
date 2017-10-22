<?php require_once('Connections/localhost.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO reservations (booking_id, booking_timestamp, booking_first_name, booking_last_name, booking_email, booking_contact, booking_status, booking_products, booking_series, booking_addons, booking_mindate, booking_maxdate, booking_notes) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['booking_id'], "int"),
                       GetSQLValueString($_POST['booking_timestamp'], "date"),
                       GetSQLValueString($_POST['booking_first_name'], "text"),
                       GetSQLValueString($_POST['booking_last_name'], "text"),
                       GetSQLValueString($_POST['booking_email'], "text"),
                       GetSQLValueString($_POST['booking_contact'], "text"),
                       GetSQLValueString($_POST['booking_status'], "text"),
                       GetSQLValueString($_POST['booking_products'], "text"),
                       GetSQLValueString($_POST['booking_series'], "text"),
                       GetSQLValueString($_POST['booking_addons'], "int"),
                       GetSQLValueString($_POST['booking_mindate'], "date"),
                       GetSQLValueString($_POST['booking_maxdate'], "date"),
                       GetSQLValueString($_POST['booking_notes'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "reservation/thank-you.php?rsrv_id=$_POST[rsrv_id]";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    	<title>PT. Putra Mutiara Jaya (Printmate)</title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="includes/jquery/jquery-ui-custom.css" />
<script src="includes/jquery/jquery-1.10.2.js"></script>
<script src="includes/jquery/jquery-ui-custom.js"></script>
<script src="includes/jquery/maskedinput.js"></script>
<script src="includes/bootstrap/js/bootstrap.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script>
  jQuery(document).ready(function($) {var dateToday = new Date();
var dates = $("#dateStart, #dateEnd").datepicker({
    defaultDate: "+1w",
	dateFormat: 'yy-mm-dd',
    changeMonth: true,
    numberOfMonths: 1,
    minDate: dateToday,
    onSelect: function(selectedDate) {
        var option = this.id == "dateStart" ? "minDate" : "maxDate",
            instance = $(this).data("datepicker"),
            date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker.settings.dateFormat, selectedDate, instance.settings);
        dates.not(this).datepicker("option", option, date);
   	 }
	});
});
  </script>
<script type="text/javascript">
	jQuery(function($){
   $("#rsrv_contact").mask("99999999999");
	});
	</script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="main_container" >
        <a href="index.php"><img src="images/logoprintmate.png" align="left" /></a>
            <div id="headr_img">
                <span id="main_nav"> 
                	   	<a href="index.php">Home</a> |  
						<a href="catalogue.php">Gallery</a> |  
                        <a href="reserve.php">Booking Service</a> |  
                        <a href="contact.php">Contact Us</a>
	            </span>
            </div>
   <div id="content_container">
  
            <div id="content_left">
<h2 id="home_header"><i>Booking Service Form</i></h2>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="booking_form">
                <label>First Name</label><br />
<span id="sprytextfield1">
                <input type="text" name="booking_first_name" value="" size="30" placeholder="Type here" />
      <span class="textfieldRequiredMsg">This field is required</span></span><br/>
                <label>Last Name</label><br />
<span id="sprytextfield2">
                <input type="text" name="booking_last_name" value="" size="30" placeholder="Type here" />
                <span class="textfieldRequiredMsg">This field is required</span></span><br /><label>Email</label><br />
<input type="Email" name="booking_email" value="" size="30" placeholder="Type here" /><br />
                <label>Contact Number</label><br />
                <span id="sprytextfield3">
                <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="booking_contact" value="" size="30" id="booking_contact" placeholder="Type here" />
<span class="textfieldRequiredMsg">This field is required</span></span><br />
                <label>Status</label></br>
                  <select name="booking_status" style="width: 210px" size="1" id="select" placeholder="Select">
                    <option value="Member">Member</option>
                    <option value="Non Member">Non Member</option>
                    <values>
                  </select>
                  <br /><br />
                  <label>Your Products</label>
                      <fieldset><label>
                        <input name="booking_products" type="radio" id="booking_products1" value="Unit Printer" checked="checked" />
                        Unit Printer (Service Fee Rp. 500.000)</label><br/>
                      <label>
                        <input type="radio" name="booking_products" value="Outdoor" id="booking_products2" />
                        Outdoor (Service Fee Rp. 1.500.000)</label><br/>
                      <label>
                        <input type="radio" name="booking_products" value="Indoor" id="booking_products3" />
                        Indoor (Service Fee Rp. 1.000.000)</label><br/>
                        </fieldset>
                <label>Your Series Product / Serial Number of Product</label><br />
                <span id="sprytextfield3">
                <input type="text" name="booking_series" value="" size="30" id="booking_series" placeholder="Type here" />
<span class="textfieldRequiredMsg">This field is required</span></span><br />
                      <label>Addons</label>
                      <fieldset>
                        <label>Ink Package (Rp. 100.000)
                          <select name="booking_addons" id="booking_addons">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <values>
                          </select>
                        </label><br/>
                      </fieldset>
<label>Booking Dates:</label><br />
<fieldset>
				<label>Minimal :</label>
<span id="sprytextfield4">
				<input type="date" name="booking_mindate" value="" size="15" id="booking_mindate" placeholder="Service a Date"  />
	  <span class="textfieldRequiredMsg">Please select a date.</span></span><br />
        <label>Maximal :</label>
    <span id="sprytextfield5">
        <input type="date" name="booking_maxdate" value="" size="15" id="booking_maxdate" placeholder="Service a Date" />         
      <span class="textfieldRequiredMsg">Please select a date.</span></span><br/>
     <!-- <div class="check_avail"><a href="">Check Availability</a></div> --></fieldset>
                <label>Additional Notes For Technician:</label><br />
<textarea name="booking_notes" cols="40" rows="5"></textarea><br />
                <input type="submit" value="Submit" /> <input name="Reset" type="reset" value="Clear Form" />
      <input type="hidden" name="booking_id" value="" />
                <input type="hidden" name="rsrv_timestamp" />
                <input type="hidden" name="MM_insert" value="form1" />
</form>
     </div>
     <div id="content_right">
     </div>
   </div>
         <div id="footer_container">
         	Copyright © 2017 Toni Wahyudi - TA_MI Piksi Ganesha
         </div>
	</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
</script>
</body>
</html>