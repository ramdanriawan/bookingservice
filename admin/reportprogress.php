<?php// Include file class.ezpdf dalam folder fungsiPDF
include ('includes/fpdf.php');
// Koneksi ke database dan tampilkan datanya
mysql_connect("localhost", "root", "");
mysql_select_db("hans_db");

if ($_POST[booking_finished]=='Choose Progress'){
 echo "Please Choose Progress Which One You Want View.. ";
}
else {
 $pdf = new Cezpdf();

// Set margin dan font
 $pdf->ezSetCmMargins(3, 3, 3, 3);
 $pdf->SetFont('Arial','',11);
 $all = $pdf->openObject();

// Tampilkan logo
 $pdf->setStrokeColor(0, 0, 0, 1);
 $pdf->addJpegFromFile('logo.jpg',20,800,69);

// Teks di tengah atas untuk judul header
 $pdf->addText(200, 820, 16,'<b>Laporan Data Progress Service</b>');
 $pdf->addText(90, 800, 14,'<b>PT Putra Mutiara Jaya &amp; (Printmate)</b>');
 // Garis atas untuk header
 $pdf->line(10, 795, 578, 795);
 $pdf->addText(50, 780, 8,'<b>Progress :</b> '. $_POST[booking_finished]);
 // Garis bawah untuk footer
 $pdf->line(10, 50, 578, 50);
 // Teks kiri bawah
 $pdf->addText(30,34,8,'Dicetak tanggal:' . date( 'd-m-Y, H:i:s'));

$pdf->closeObject();

// Tampilkan object di semua halaman
 $pdf->addObject($all, 'all');

// Query untuk merelasikan kedua tabel
 $sql = mysql_query("SELECT * FROM reservations WHERE booking_finished = '$_POST[booking_finished]'");
 $jml = mysql_num_rows($sql);
 $i = 1;
 while($r = mysql_fetch_array($sql)){
$data[$i]=array('<b>No</b>'=>$i,
 '<b>Booking Time</b>'=>$r[booking_timestamp],
     '<b>Name</b>'=>$r[booking_first_name]>$r[booking_last_name],
     '<b>Email</b>'=>$r[booking_email],
     '<b>Contact No</b>'=>$r[booking_contact],
     '<b>Member Status</b>'=>$r[booking_status]),
     '<b>Product</b>'=>$r[booking_product]),
     '<b>Series / Serial Number</b>'=>$r[booking_series]),
     '<b>Addons (Ink Package)</b>'=>$r[booking_addons]),
     '<b>Booking Service Minimal Dates</b>'=>$r[booking_mindate]),
     '<b>Booking Service Maximal Dates</b>'=>$r[booking_maxdate]),
     '<b>Service Notes</b>'=>$r[booking_notes]),
     '<b>Technician</b>'=>$r[booking_technician])
;
 $i++;
}
$pdf->ezTable($data, '', '', '');

 // Penomoran halaman
 $pdf->ezStartPageNumbers(320, 15, 8);
 $pdf->ezStream();
 }
?>