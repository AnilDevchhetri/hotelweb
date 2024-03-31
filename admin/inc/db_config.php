<?php

$hname = 'localhost';
$uname = 'root';
$pass = '';
$db = 'hotelbookingwebsite';

$con = mysqli_connect($hname, $uname, $pass, $db);

if (!$con) {
   die("Cannot connect to database" . mysqli_connect_error());
}


function filteration($data)
{
   foreach ($data as $key => $value) {

      $value = trim($value);
      $value = stripslashes($value);
      $value = htmlspecialchars($value);
      $value = strip_tags($value);
      $data[$key] = $value;
   }
   return $data;
}


function selectAll($table){
   $con = $GLOBALS['con'];
   $res = mysqli_query($con,"SELECT * FROM   $table");
   return $res;
}


function select($sql, $values, $datatype)
{
   $con = $GLOBALS['con'];
   if ($stmt = mysqli_prepare($con, $sql)) {
      mysqli_stmt_bind_param($stmt, $datatype, ...$values); //... is php splate operator
      if (mysqli_stmt_execute($stmt)) {
         $res = mysqli_stmt_get_result($stmt);
         mysqli_stmt_close($stmt);
         return $res;
      } else {
         mysqli_stmt_close($stmt);
         die("query conanot to be Prepare - Select");
      }
   } else {
      die("query conanot to be excuded - Select");
   }
}



function update($sql, $values, $datatype)
{
   $con = $GLOBALS['con'];
   if ($stmt = mysqli_prepare($con, $sql)) {
      mysqli_stmt_bind_param($stmt, $datatype, ...$values); //... is php splate operator
      if (mysqli_stmt_execute($stmt)) {
         $res = mysqli_stmt_affected_rows($stmt);
         mysqli_stmt_close($stmt);
         // return 1;
         return $res;
      } else {
         mysqli_stmt_close($stmt);
         die("query conanot to be Prepare - Update");
      }
   } else {
      die("query conanot to be excuded - Update");
   }
}



function insert($sql, $values, $datatype)
{
   $con = $GLOBALS['con'];
   if ($stmt = mysqli_prepare($con, $sql)) {
      mysqli_stmt_bind_param($stmt, $datatype, ...$values); //... is php splate operator
      if (mysqli_stmt_execute($stmt)) {
         $res = mysqli_stmt_affected_rows($stmt);
         mysqli_stmt_close($stmt);
         // return 1;
         return $res;
      } else {
         mysqli_stmt_close($stmt);
         die("query conanot to be Prepare - insert");
      }
   } else {
      die("query conanot to be excuded - insert");
   }
}

function Delete($sql, $values, $datatype)
{
   $con = $GLOBALS['con'];
   if ($stmt = mysqli_prepare($con, $sql)) {
      mysqli_stmt_bind_param($stmt, $datatype, ...$values); //... is php splate operator
      if (mysqli_stmt_execute($stmt)) {
         $res = mysqli_stmt_affected_rows($stmt);
         mysqli_stmt_close($stmt);
         // return 1;
         return $res;
      } else {
         mysqli_stmt_close($stmt);
         die("query conanot to be Prepare - Update");
      }
   } else {
      die("query conanot to be excuded - Update");
   }
}
