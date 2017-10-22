
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/integral-core.css" rel="stylesheet">
<link href="assets/plugins/jvectormap/css/jquery-jvectormap-2.0.3.css" rel="stylesheet">
<link href="assets/css/integral-forms.css" rel="stylesheet">
<link href="assets/css/integral-forms.css" rel="stylesheet">
<link href="assets/plugins/datatables/css/jquery.dataTables.css" rel="stylesheet">
<link href="assets/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css" rel="stylesheet">
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "access_denied.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php require_once('../Connections/localhost.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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

mysql_select_db($database_localhost, $localhost);
$query_user = "SELECT * FROM `user`";
$user = mysql_query($query_user, $localhost) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);
$totalRows_user = mysql_num_rows($user);

$maxRows_records = 5;
$pageNum_records = 0;
if (isset($_GET['pageNum_records'])) {
  $pageNum_records = $_GET['pageNum_records'];
}
$startRow_records = $pageNum_records * $maxRows_records;

mysql_select_db($database_localhost, $localhost);
$query_records = "SELECT *,DATE_FORMAT(booking_timestamp, '%M-%e-%Y %r') AS timeStamp, DATE_FORMAT( booking_mindate, '%M %d, %Y') AS booking_mindate,  DATE_FORMAT(booking_maxdate, '%M %d, %Y') AS booking_maxdate FROM reservations ORDER BY reservations.booking_timestamp DESC";
$query_limit_records = sprintf("%s LIMIT %d, %d", $query_records, $startRow_records, $maxRows_records);
$records = mysql_query($query_limit_records, $localhost) or die(mysql_error());
$row_records = mysql_fetch_assoc($records);

if (isset($_GET['totalRows_records'])) {
  $totalRows_records = $_GET['totalRows_records'];
} else {
  $all_records = mysql_query($query_records);
  $totalRows_records = mysql_num_rows($all_records);
}
$totalPages_records = ceil($totalRows_records/$maxRows_records)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/stylesheet.css" />
<link rel="stylesheet" href="style/includes/jquery/jquery-ui-custom.css" />
<script src="style/includes/jquery/jquery-1.10.2.js"></script>
<script src="style/includes/jquery/jquery-ui-custom.js"></script>
<script src="includes/bootstrap/js/bootstrap.js"></script>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" />
 <script>
jQuery(function($) {
  $("#opens_window").click(function(e) {
      e.preventDefault();       
      $('#dialog').dialog();
  });
});
</script>
<title>:: Admin Panel :: PT. Putra Mutiara Jaya</title>
</head>
<body>
<div class="top_container">
    	<span id="panel_name">Admin Panel</span>
  <span id="user">Welcome, <?php echo $row_user['user_full']; ?><br/><a href="<?php echo $logoutAction ?>">Log out</a> </span></div>
<ul id="menu">
    	<li>
       	  <a href="admin_panel.php"><i class="fa fa-home"></i>  Home</a>
      </li>
    	<li>	
        	<a href="records.php"><i class="fa fa-list-alt"></i>  Data Booking Services</a>
      </li>
      <li>
        	<a href="users.php"><i class="fa fa-users"></i>  User Management</a>
      </li>
      <li>
          <a href="report.php"><i class="fa fa-folder-open"></i>  Monthly Report</a>
      </li>
</ul>
<br/>
<br/><br/>
<br/><br/>
<br/>
<div id="container fully">

 <h1><i class="fa fa-bars"></i> Data Booking Service</h2>
 <div class="main-content">
      
      </center>
      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <!-- <div class="panel-heading clearfix">
              <h4 class="panel-title">Basic Data Tables with responsive Plugin</h4>
              <ul class="panel-tool-options"> 
                <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
              </ul>
            </div> -->
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example" >
                  <thead>
   <tr>
     <td>No.</td>
     <td>Submitted</td>
     <td>First Name</td>
     <td>Last Name</td>
     <td>Email</td>
     <td>Contact Number</td>
     <td>Status</td>
     <td>Products</td>
     <td>Series</td>
     <td>Addons</td>
     <td>Min Date Service</td>
     <td>Max Date Service</td>
     <td>Notes</td>
     <td>Progress</td>
     <td>Technician</td>
     <td>Actions</td>
   </tr>
   </thead>
   <?php do { ?>
   <tbody>
     <tr class="gradeX">
     
       <td><?php echo $row_records['booking_id']; ?></td>
       <td><?php echo $row_records['booking_timestamp']; ?></td>
       <td><?php echo $row_records['booking_first_name']; ?></td>
       <td><?php echo $row_records['booking_last_name']; ?></td>
       <td><?php echo $row_records['booking_email']; ?></td>
       <td><?php echo $row_records['booking_contact']; ?></td>
       <td><?php echo $row_records['booking_status']; ?></td>
       <td><?php echo $row_records['booking_products']; ?></td>
       <td><?php echo $row_records['booking_series']; ?></td>
       <td><?php echo $row_records['booking_addons']; ?></td>
       <td><?php echo $row_records['booking_mindate']; ?></td>
       <td><?php echo $row_records['booking_maxdate']; ?></td>
       <td><?php echo $row_records['booking_notes']; ?></td>
       <td><?php echo $row_records['booking_finished']; ?></td>
       <td><?php echo $row_records['booking_technician']; ?></td>
       <td><a href="reservation_slip.php?id=<?php echo $row_records['booking_id']; ?>" class="btn btn-warning"><i class="fa fa-print"></i></a> <a href="edit_r.php?booking_id=<?php echo $row_records['booking_id']; ?>"  class="btn btn-primary"><i class="fa fa-edit"></i></a> <a href="delete_rsrv.php?booking_id=<?php echo $row_records['booking_id']; ?>"  class="btn btn-danger"><i class="fa fa-trash-o"></i></a></td>
     </tr>
     <?php } while ($row_records = mysql_fetch_assoc($records)); ?>
     </tbody>
 </table>
<!-- <div id="dialog">
 		<h3>Reservations for</h3> 
    </div> -->
 </div>
</body>
</html>
<?php
mysql_free_result($user);

mysql_free_result($records);
?>
<!--Load JQuery-->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/plugins/metismenu/js/jquery.metisMenu.js"></script>
<script src="assets/plugins/blockui-master/js/jquery-ui.js"></script>
<script src="assets/plugins/blockui-master/js/jquery.blockUI.js"></script>

<!--Knob Charts-->
<script src="assets/plugins/knob/js/jquery.knob.min.js"></script>

<!--Jvector Map-->
<script src="assets/plugins/jvectormap/js/jquery-jvectormap-2.0.3.min.js"></script>
<script src="assets/plugins/jvectormap/js/jquery-jvectormap-world-mill-en.js"></script>

<!--ChartJs-->
<script src="assets/plugins/chartjs/js/Chart.min.js"></script>

<!--Morris Charts-->
<script src="assets/plugins/morris/js/raphael-min.js"></script>
<script src="assets/plugins/morris/js/morris.min.js"></script>

<!--Float Charts-->
<script src="assets/plugins/flot/js/jquery.flot.min.js"></script>
<script src="assets/plugins/flot/js/jquery.flot.tooltip.min.js"></script>
<script src="assets/plugins/flot/js/jquery.flot.resize.min.js"></script>
<script src="assets/plugins/flot/js/jquery.flot.pie.min.js"></script>
<script src="assets/plugins/flot/js/jquery.flot.time.min.js"></script>

<!--Functions Js-->
<script src="assets/js/functions.js"></script>

<!--Dashboard Js-->
<script src="assets/js/dashboard.js"></script>

<script src="assets/js/loader.js"></script>

<script src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/plugins/datatables/js/jszip.min.js"></script>
<script src="assets/plugins/datatables/js/pdfmake.min.js"></script>
<script src="assets/plugins/datatables/js/vfs_fonts.js"></script>
<script src="assets/plugins/datatables/extensions/Buttons/js/buttons.html5.js"></script>
<script src="assets/plugins/datatables/extensions/Buttons/js/buttons.colVis.js"></script>
<script src="assets/plugins/datatables/js/dataTables-script.js"></script>
<script src="assets/js/loader.js"></script>
</body>
