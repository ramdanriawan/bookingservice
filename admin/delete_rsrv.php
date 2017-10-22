<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_localhost = "localhost";
$database_localhost = "hans_db";
$username_localhost = "root";
$password_localhost = "";
$localhost = mysql_pconnect($hostname_localhost, $username_localhost, $password_localhost) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
<?php  
  
 $booking_id=$_GET['booking_id'];
      $hapus = mysql_query("DELETE FROM reservations WHERE booking_id=$booking_id");
      if($hapus)
      {  
          ?>  
            <script language="javascript">  
                alert('Data Berhasil Dihapus !!');
                window.location.href=document.referrer;  
              </script>  
          <?php  
        }
        else
        {  
          ?>  
            <script language="javascript">  
                alert('Gagal menghapus');
                window.location.href=document.referrer; 
              </script>  
          <?php  
        }
   
?>  