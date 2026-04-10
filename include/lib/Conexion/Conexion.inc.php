<?php

 $username = 'root';

$password = 'mayaroot123';

$hostname = 'db';

$database = 'mayamaria';

//-------------------------------
// $username='mvtoolin';

//   $password='GalvaTest#82';

//   $hostname="147.182.228.194";

//   $database="galvatest";

//-------------------

// $username='galvamex_uremote';

//   $password='GalvaRemote#12358';

//   $hostname="67.222.140.68";

//   // $database="galvamex_test";
//   $database = 'galvamex_appgalva';





// $database = 'galvamex_appgalva';
// $database = 'gmqa';

//---------------------------------
  // $username = 'oubdllnt_uappmaya';

  // $password = 'D;KXRs[];RT7GSv[';

  //   $hostname="199.26.86.79";

  // $database = 'oubdllnt_appmaya';


$dbLink= mysqli_connect($hostname, $username, $password)

or die("Unable to connect to MySQL");



 $selected = mysqli_select_db($dbLink,$database) or die("Could not select $database");
 
 

 mysqli_query($dbLink,"SET NAMES UTF8");
 
 