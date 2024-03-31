<?php

require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();



if (isset($_POST['get_bookings'])) {
    
    $frm_data = filteration($_POST);


    $query = "SELECT bo.*, bd.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_Id
     WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ? )
     AND (bo.booking_status =?) ORDER BY bo.booking_id ASC";
    $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%","cancelled"],'ssss');
    $i = 1;
    
    if(mysqli_num_rows($res)==0){
        echo "<b>No Data found</b>";
        exit;
    }
    $table_data = "";
    while ($data = mysqli_fetch_assoc($res)) {
        $date = date("d-m-Y", strtotime($data['datentime']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));
        $table_data .= "
       <tr>
         <td>$i</td>
         <td>
         <span class='badge bg-primary'>
         Order ID: $data[order_id]
         </span><br>
         <b>Name: </b>$data[user_name]<br>
         <b>Phone No.: </b>$data[phonenum]      
         </td>
         <td>
          <b>Room: </b> $data[room_name]<br>
          <b>Price: </b>₹ $data[price]<br>
         </td>
         <td>
          <b>  Check in: </b> $checkin<br>
          <b>  Check Out: </b> $checkout<br>
          <b> Total Amount: </b>₹ $data[trans_amt]<br>
          <b>Date: </b> $date;
         </td>
         <td>           
            <button type='button' onclick='delete_booking($data[booking_id])' class='btn btn-outline-danger btn-sm fw-bold shadow-none' >
            <i class='bi bi-trash'></i>
         </td>
       </tr>
    ";
        $i++;
    }
    echo $table_data;
}



if(isset($_POST['assign_room'])){
  $frm_data = filteration($_POST);

  $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd
          ON bo.booking_id = bd.booking_id SET bo.arrival = ?,bd.room_no = ?
          WHERE bo.booking_id = ?
          ";
  $value = [1,$frm_data['room_no'],$frm_data['booking_id']];
  $res = update($query,$value,'isi');
  echo ($res==2)? 1 :0;
}



if (isset($_POST['delete_booking'])) {

    
    $frm_data = filteration($_POST);
    $query1 = delete("DELETE FROM `booking_details` WHERE `booking_id`=? ",[$frm_data['booking_id']],'i');
    if($query1==1){
        $query2 = delete("DELETE FROM `booking_order` WHERE `booking_id`=? ",[$frm_data['booking_id']],'i');
        echo $query2;
    }else{
        echo 0;
    }
    

   }



