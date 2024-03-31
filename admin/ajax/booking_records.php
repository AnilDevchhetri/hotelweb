<?php

require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();



if (isset($_POST['get_bookings'])) {
    
    $frm_data = filteration($_POST);
    $limit = 3;
    $page = $frm_data['page'];
    $start = ($page-1) * $limit;
    //page 1: 0,10,  page 2: 2-1 = 10-20
    $query = "SELECT bo.*, bd.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_Id
     WHERE ((bo.booking_status ='booked' AND bo.arrival = 1) OR (bo.booking_status='cancelled'))
     AND (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ? )
     ORDER BY bo.booking_id DESC";
    $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"],'sss');
    $limit_query = $query ." LIMIT $start, $limit";
    $limit_res =  select($limit_query, ["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"],'sss');
   

    $total_rows =mysqli_num_rows($res);
    
    if($total_rows==0){
        $output = json_encode(['table_data'=>"<b>No Data found</b>","pagination"=>'']);
        echo $output;
        exit;
    }
    $i = $start+1;
    $table_data = "";
    while ($data = mysqli_fetch_assoc($limit_res)) {
        $date = date("d-m-Y", strtotime($data['datentime']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));
        if($data['booking_status'] == 'booked'){
            $status_bg = 'bg-success';
        }else if($data['booking_status'] =='cancelled'){
            $status_bg = 'bg-danger';
        }else{
            $status_bg = 'bg-warning';
        }
        $table_data .="<tr>
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
          <b>Date: </b> $date
         </td>
         <td>
         <span class='badge $status_bg'>$data[booking_status]</span>
         </td>
         <td>
            <button type='button' onclick='assign_room($data[booking_id])' class='btn text-white btn-sm fw-bold custom-bg shadow-none' data-bs-toggle='modal' data-bs-target='#assign-room'>
            Check-Out 
            </button><br>
            <button type='button' onclick='download($data[booking_id])' class='btn mt-2 btn-outline-success btn-lm fw-bold fs-4 shadow-none'>
            <i class='bi bi-filetype-pdf'></i>
            </button>
         </td>
       </tr>
    ";
        $i++;
    }
    $pagination = '';
    if($total_rows>$limit){
 
      $total_pages = ceil($total_rows/$limit);
      $disabled = ($page==1)? 'disabled': '';
      $prev = $page - 1;

      if($page != 1){
        $pagination .= "<li class='page-item $disabled'><button class='page-link shadow-none' onclick='change_page(1)'>First</button></li>";
      }

      $pagination .= "<li class='page-item $disabled'><button class='page-link shadow-none ' onclick='change_page($prev)' >Prev</button></li>";
      $disabled = ($page==$total_pages)? 'disabled': '';
      $next = $page + 1;
      $pagination .= "<li class='page-item $disabled'><button class='page-link shadow-none' onclick='change_page($next)'>Next</button></li>";

      if($page != $total_pages){
        $pagination .= "<li class='page-item $disabled'><button class='page-link shadow-none' onclick='change_page($total_pages)'>Last</button></li>";
      }
    }
    $output = ['table_data'=>$table_data,'pagination'=>$pagination];
    echo json_encode($output);
}







