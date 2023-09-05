<?php





 //$username = 'root';

// $password = 'nerkpumper';

// $hostname = 'localhost';

// $database = 'galvamex';

 

  $username = 'galvamex_uappgalva';

  $password = 'UserAppGalvamex#12358';

  $hostname = 'localhost';

  $database = 'galvamex_appgalva';



$dbLink= mysqli_connect($hostname, $username, $password)

or die("Unable to connect to MySQL");



 $selected = mysqli_select_db($dbLink,$database) or die("Could not select $database");
 
 

 mysqli_query($dbLink,"SET NAMES UTF8");
 
 