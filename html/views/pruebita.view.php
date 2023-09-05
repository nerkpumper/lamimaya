<?php
$_lugar = "dashtarifas";


$random_salt = "402ad03acfa76262a95038fd8395deca329ace9ff57d8459496ba25a1f84943ce5296d5617e1b4a036d7e7a879a90e851131bfb8f3c750fa89801c53e92192ff";
echo "<br>salt: " . $random_salt;
$passwordSalt = hash('sha512', "nerkpumper" . $random_salt);

echo "<br>pass:  d699e4a4bb0e31e751537dd19347cbd8410186fec616ee8cc31416c059b21d74fbafab0584a35470d6524d03846ef15852087ca6e2347d3c12756b5364fb1f4f";

echo "<br>pass: " . $passwordSalt;

$db_password="nerkpumper";
$salt= $random_salt;

// Hace el hash de la contraseña con una sal única.
$password = hash('sha512', $password . $salt);

echo "<br>pass: " . $password;




return;

echo "estoy en pruebita.view.php";

echo "<br><br>vamos a imprimir variable parametro pa ver si llega pa aca: ";
echo "<br><br>Param1 en vista: " . $param1;



echo "<br>" . $paramDeController;
echo "<br>" . $paramDeController2;
?>

<h1>Bienvenido, {{ nombre }}</h1>
<input type="text" v-model="nombre">

<div >
  {{ message }}
</div>

<pre>
	{{ $data | json}}
</pre>

