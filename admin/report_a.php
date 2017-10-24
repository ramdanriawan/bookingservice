<?php require_once('../Connections/localhost.php'); ?>
<?php require_once('../Connections/localhost.php'); ?>
<?php
require_once('../Connections/localhost.php');
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

$maxRows_report = 10;
$pageNum_report = 0;
if (isset($_GET['pageNum_report'])) {
  $pageNum_report = $_GET['pageNum_report'];
}
$startRow_report = $pageNum_report * $maxRows_report;

$colname_report = "-1";
if (isset($_POST['month'])) {
  $colname_report = $_POST['month'];
}
mysql_select_db($database_localhost, $localhost);
$query_report = sprintf("SELECT reservations.booking_id, reservations.booking_timestamp, reservations.booking_first_name, reservations.booking_last_name, reservations.booking_email, reservations.booking_contact, reservations.booking_status, reservations.booking_products, reservations.booking_series, reservations.booking_addons, reservations.booking_mindate, reservations.booking_maxdate, reservations.booking_notes, reservations.booking_finished, reservations.booking_technician FROM reservations WHERE MONTH(booking_mindate) = %s ORDER BY booking_timestamp ASC", GetSQLValueString($colname_report, "date"));
$query_limit_report = sprintf("%s LIMIT %d, %d", $query_report, $startRow_report, $maxRows_report);
$report = mysql_query($query_limit_report, $localhost) or die(mysql_error());
$row_report = mysql_fetch_assoc($report);

if (isset($_GET['totalRows_report'])) {
  $totalRows_report = $_GET['totalRows_report'];
} else {
  $all_report = mysql_query($query_report);
  $totalRows_report = mysql_num_rows($all_report);
}
$totalPages_report = ceil($totalRows_report/$maxRows_report)-1;

$room = $row_report['booking_products'];
$room_price = 0;

if ($room =='Unit Printer')
{
  $room_price == 500000;
}
elseif ($room =='Outdoor')
{
  $room_price == 1500000;
}
elseif($room =='Indoor')
{
  $room_price == 1000000;
}


$tot_bed =($row_report['booking_addons']) * 100000;
$tot_addons = $tot_bed;
$tot_room = $tot_addons + $room_price;



?>
<?php
require_once('../Connections/localhost.php');

mysql_select_db($database_localhost, $localhost);
   error_reporting(0);

$query_repot = sprintf("SELECT reservations.booking_id, reservations.booking_timestamp, reservations.booking_first_name, reservations.booking_last_name, reservations.booking_email, reservations.booking_contact, reservations.booking_status, reservations.booking_products, reservations.booking_series, reservations.booking_addons, reservations.booking_mindate, reservations.booking_maxdate, reservations.booking_notes, reservations.booking_finished, reservations.booking_technician FROM reservations WHERE booking_finished = $data[booking_finished] ORDER BY booking_timestamp ASC", GetSQLValueString($colname_report, "date"));
$query_limit_repot = sprintf("%s LIMIT %d, %d", $query_repot, $startRow_report, $maxRows_report);
$repot = mysql_query($query_limit_report, $localhost) or die(mysql_error());
$row_repot = mysql_fetch_assoc($repot);
?>
      <!-- <label>Year: <?php
$current_year = date("Y");
$range = range($current_year, ($current_year - 20));
echo '<select name="year" id="contact-year" tabindex="7">';
 
//Now we use a foreach loop and build the option tags
foreach($range as $r)
{
echo '<option value="'.$r.'">'.$r.'</option>';
}
 
//Echo the closing select tag
echo '</select>';
?></label> -->
 <script type="text/javascript">
  window.onload = function () {
    // window.print();
}
  </script>
     </form>
     <!-- code adde db ramdan -->
     <link rel="stylesheet" type="text/css" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="../node_modules/bootstrap/dist/js/bootstrap.min.js">

     <div class="container-fluid">
     <div class="row">
       <div class="col-md-6 col-md-offset-3" style="margin-top: 20px;">
         <img src="../images/logoprintmate2.png" align="center">
       </div>
     <!-- code ended -->

     <div class="col-md-12">
     <table class="table table-responsive table-condensed table-striped table-hover" border="1" cellpadding="2" cellspacing="2" class="data_table" style="margin-top: 20px;">
       <tr id="tr" style="background: #777; color: white;">
         <th>Submitted</th>
         <th>First Name</th>
         <th>Last Name</th>
         <th>Email</th>
         <th>Contact</th>
         <th>Status</th>
         <th>Product</th>
         <th>Series</th>
         <th>Addons</th>
         <th>Booking Minimal Date</th>
         <th>Booking Maximal Date</th>
         <th>Notes</th>
         <th>Finished</th>
         <th>Technician</th>
       </tr>
       <?php do { ?>
         <tr>
           <td><?php echo $row_report['booking_timestamp']; ?></td>
           <td><?php echo $row_report['booking_first_name']; ?></td>
           <td><?php echo $row_report['booking_last_name']; ?></td>
           <td><?php echo $row_report['booking_email']; ?></td>
           <td><?php echo $row_report['booking_contact']; ?></td>
           <td><?php echo $row_report['booking_status']; ?></td>
           <td><?php echo $row_report['booking_products']; ?></td>
           <td><?php echo $row_report['booking_series']; ?></td>
           <td><?php echo $row_report['booking_addons']; ?></td>
           <td><?php echo $row_report['booking_mindate']; ?></td>
           <td><?php echo $row_report['booking_maxdate']; ?></td>
           <td><?php echo $row_report['booking_notes']; ?></td>
           <td><?php echo $row_report['booking_finished']; ?></td>
           <td><?php echo $row_report['booking_technician']; ?></td>
         </tr>
         <?php } while ($row_report = mysql_fetch_assoc($report)); ?>
     </table>
      </div>
     </div>
     </div>

   <?php
   error_reporting(0);
mysql_free_result($user);

mysql_free_result($report);
?>
