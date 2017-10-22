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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE reservations SET booking_timestamp=%s, booking_first_name=%s, booking_last_name=%s, booking_email=%s, booking_contact=%s, booking_status=%s, booking_products=%s, booking_series=%s, booking_addons=%s, booking_mindate=%s, booking_maxdate=%s, booking_notes=%s, booking_finished=%s WHERE booking_id=%s",
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
                       GetSQLValueString($_POST['booking_notes'], "text"),
                       GetSQLValueString($_POST['booking_finished'], "text"),
                       GetSQLValueString($_POST['booking_id'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "records.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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

$colname_records = "-1";
if (isset($_GET['rsrv_id'])) {
  $colname_records = $_GET['rsrv_id'];
}
mysql_select_db($database_localhost, $localhost);
$query_records = sprintf("SELECT * FROM reservations WHERE booking_id = %s", GetSQLValueString($colname_records, "int"));
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
<link rel="stylesheet" type="text/css" media="all" href="style/includes/jquery/jquery-ui-custom.css" />
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" />
<script src="style/includes/jquery/jquery-1.10.2.js"></script>
<script src="style/includes/jquery/jquery-ui-custom.js"></script>
<script src="style/includes/jquery/maskedinput.js"></script>
<script src="style/includes/bootstrap/js/bootstrap.js"></script>
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
<div id="container">
 <h2><i class="fa fa-bars"></i> Records</h2>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">First Name:</td>
      <td><input type="text" name="booking_first_name" value="<?php echo htmlentities($row_records['booking_first_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Last Name:</td>
      <td><input type="text" name="booking_last_name" value="<?php echo htmlentities($row_records['booking_last_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Email:</td>
      <td><input type="text" name="booking_email" value="<?php echo htmlentities($row_records['booking_email'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Contact Numbers:</td>
      <td><input type="text" name="booking_contact" value="<?php echo htmlentities($row_records['booking_contact'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Customer Status:</td>
      <td valign="baseline"><table>
        <tr>
          <td><input type="radio" name="booking_status" value="Member" <?php if (!(strcmp(htmlentities($row_records['booking_status'], ENT_COMPAT, 'utf-8'),"Member"))) {echo "checked=\"checked\"";} ?> />
            Member</td>
        </tr>
        <tr>
          <td><input type="radio" name="booking_status" value="Non Member" <?php if (!(strcmp(htmlentities($row_records['booking_status'], ENT_COMPAT, 'utf-8'),"Non Member"))) {echo "checked=\"checked\"";} ?> />
            Non Member</td>
        </tr>
      </table></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Products :</td>
      <td><select name="booking_products">
        <option value="Unit Printer" <?php if (!(strcmp(1, htmlentities($row_records['booking_products'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>1</option>
        <option value="Outdoor" <?php if (!(strcmp(2, htmlentities($row_records['booking_products'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>2</option>
        <option value="Indoor" <?php if (!(strcmp(3, htmlentities($row_records['booking_products'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>3</option>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Series :</td>
      <td><input type="text" name="booking_series" value="<?php echo htmlentities($row_records['booking_series'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Addons (Ink Packages) :</td>
      <td>
      <select name="booking_addons">
      <option value="1" <?php if (!(strcmp(1, htmlentities($row_records['booking_addons'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>1</option>
      <option value="2" <?php if (!(strcmp(2, htmlentities($row_records['booking_addons'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>2</option>
      <option value="3" <?php if (!(strcmp(3, htmlentities($row_records['booking_addons'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>3</option>
      <option value="4" <?php if (!(strcmp(1, htmlentities($row_records['booking_addons'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>4</option>
      <option value="5" <?php if (!(strcmp(5, htmlentities($row_records['booking_addons'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>5</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Service Minimal Date:</td>
      <td><input type="text" id="booking_mindate" name="booking_mindate" value="<?php echo htmlentities($row_records['booking_mindate'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Service Maximal Date:</td>
      <td><input type="text" id="booking_maxdate" name="booking_maxdate" value="<?php echo htmlentities($row_records['booking_maxdate'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Notes:</td>
      <td><textarea name="booking_notes"><?php echo htmlentities($row_records['booking_notes'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Finished:</td>
      <td valign="baseline"><table>
        <tr>
          <td><input type="radio" name="booking_finished" value="Yes" <?php if (!(strcmp(htmlentities($row_records['booking_finished'], ENT_COMPAT, 'utf-8'),"Yes"))) {echo "checked=\"checked\"";} ?> />
            Yes</td>
        </tr>
        <tr>
          <td><input type="radio" name="booking_finished" value="No (On Progress)" <?php if (!(strcmp(htmlentities($row_records['booking_finished'], ENT_COMPAT, 'utf-8'),"No (On Progress)"))) {echo "checked=\"checked\"";} ?> />
            No (On Progress)</td>
        </tr>
      </table></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="booking_id" value="<?php echo $row_records['booking_id']; ?>" />
  <input type="hidden" name="booking_timestamp" value="<?php echo htmlentities($row_records['booking_timestamp'], ENT_COMPAT, 'utf-8'); ?>" />
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="booking_id" value="<?php echo $row_records['booking_id']; ?>" />
</form>
 <p>&nbsp;</p>
</div>
</body>
</html>
<?php
mysql_free_result($user);

mysql_free_result($records);
?>
