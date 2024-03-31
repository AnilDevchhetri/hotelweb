<?php 
require('../admin/inc/db_config.php');
require('../admin/inc/essentials.php');

session_start();
if (!isset($_SESSION['login']) && $_SESSION['login'] == true) {
    redirect('index.php');
}

if(isset($_POST['pay_now']))
{
  
  $ORDER_ID = 'ORD_'.$_SESSION['uId'].'_'.random_int(11111,9999999);
  $CUST_ID = $_SESSION['uId'];
  $INDUSTRY_TYPE_ID = INDUSTRY_TYPE_ID;
  $CHANNEL_ID = CHANNEL_ID;
  $TXN_AMOUNT = $_SESSION['room']['payment'];

  //Create an array having all reuired parameters for creating checksum
  $paramList = array();
 // Create an array having all required parameters for creating checksum.
        $paramList["MID"] = 'Pay_'.$_SESSION['uId'].'_'.random_int(11111,9999999);//for payment id use when using online payment
        $paramList["ORDER_ID"] = $ORDER_ID;
        $paramList["CUST_ID"] = $CUST_ID;
        $paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
        $paramList["CHANNEL_ID"] = $CHANNEL_ID;
        $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
        $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
        $paramList["CALLBACK_URL"] = 'http://localhost/hotelbookingphp/pay_response.php';
        
        //Here checksum string will return by getChecksumFromArray() function.
        //  $checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);

     $frm_data = filteration($_POST);
     $query1 = "INSERT INTO `booking_order`( `user_id`, `room_id`, `check_in`, `check_out`,`booking_status`, `order_id`,`trans_amt`) VALUES (?,?,?,?,?,?,?)";
     $values = [$CUST_ID,$_SESSION['room']['id'],$frm_data['check_in'],$frm_data['check_out'],'booked',$ORDER_ID,$TXN_AMOUNT];
     $res1 = insert($query1,$values,'isssssi');
     $booking_id = mysqli_insert_id($con);
     $query2 = "INSERT INTO `booking_details`( `booking_id`, `room_name`, `price`, `total_pay`,`user_name`, `phonenum`, `address`) VALUES (?,?,?,?,?,?,?)";
    $res2 =  insert($query2,[$booking_id,$_SESSION['room']['name'],$_SESSION['room']['price'],$TXN_AMOUNT,$frm_data['name'],$frm_data['phonenum'],$frm_data['address']],'issssss');

    if($res1 == 1 && $res2 == 1){
      echo 'room_booked';
    }else{
      echo 'booking_error';
    }
     
     


}

//2:18