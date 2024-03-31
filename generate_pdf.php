<?php
require('admin/inc/essentials.php');
require('admin/inc/db_config.php');
require('admin/inc/mpdf/vendor/autoload.php');
session_start();
if (!isset($_SESSION['login']) && $_SESSION['login'] == false) {
  redirect('rooms.php');
  exit;
}

if (isset($_GET['gen_pdf']) && isset($_GET['id'])) {
    $frm_data = filteration($_GET);
    $query = "SELECT bo.*, bd.*, uc.* FROM `booking_order` bo 
   INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_Id
   INNER JOIN `user_cred` uc ON bo.user_id = uc.id
  WHERE ((bo.booking_status ='booked' AND bo.arrival = 1) OR (bo.booking_status='cancelled'))
     AND bo.booking_id = '$frm_data[id]'";
    $res = mysqli_query($con, $query);
    $total_rows = mysqli_num_rows($res);
    if ($total_rows == 0) {
        header('location: index.php');
        exit;
    }
    $data = mysqli_fetch_assoc($res);
    $date = date("h:ia | d-m-Y", strtotime($data['datentime']));
    $checkin = date("d-m-Y", strtotime($data['check_in']));
    $checkout = date("d-m-Y", strtotime($data['check_out']));


    $table_data = "
  <h2>Booking Receipt</h2>
  <table border='1'>
   <tr>
     <td> Order ID: $data[order_id]</td>
     <td> Booking Date: $date</td>
   </tr>
   <tr>
    <td colspan='2'>Status: $data[booking_status]</td>
   </tr>
   <tr>
     <td> Name:  $data[user_name]</td>
     <td> Email: $data[email]</td>
  </tr>
  <tr>
     <td> Phone Number:  $data[phonenum]</td>
     <td> Address: $data[address]</td>
  </tr>
  <tr>
     <td> Room name:  $data[room_name]</td>
     <td> Cost: ₹$data[price] Per night</td>
  </tr>
  <tr>
   <td> Check-In:  $checkin</td>
   <td> Check-Out: $checkout</td>
  </tr>
  <tr>
    <td> Room Number:  $data[room_no]</td>  
  </tr>
  <tr>
    <td> Total Amount Pay:  $data[total_pay]</td>  
  </tr>
  </table>

";

    // // Create an instance of the class:
    // $mpdf = new \Mpdf\Mpdf();

    // // Write some HTML code:
    // $mpdf->WriteHTML($table_data);

    // // Output a PDF file directly to the browser
    // $mpdf->Output($data['order_id'].'pdf','D');
    // echo $table_data;
} else {
    header('location: index.php');
}
