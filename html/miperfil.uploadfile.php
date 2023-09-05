<?php





define('FOLDER_INCLUDE', '../include/');

// define('FOLDER_INCLUDE', '/home/galvamex/appgalvamex/include/');



define('FOLDER_HTML', './');	



require_once FOLDER_INCLUDE . 'config/constantes.inc.php';



$limite_kb = 1000;

$permitidos = array("image/jpeg");



$upload_filename = strtolower ( str_replace ( " ", "_", basename ( $_FILES ['archivo'] ['name'] ) ) );









$isUsuario = $_POST["txtIdUsuario"];







//los errores ya son explicitos, antes solo mostraban error2, error3

if (preg_match ( "/[^0-9a-zA-Z_.-]/", $upload_filename ))

{

	echo json_encode(array('error' => true, 'msg' => 'El nombre del archivo tiene caracteres no v&aacute;lidos.'));

	return;

}

else if (in_array ( $_FILES ['archivo'] ['type'], $permitidos ) && $_FILES ['archivo'] ['size'] <= $limite_kb * 1024)

{	

	//$dirFiles = "assets/dispositivos/";

	

	$dirFiles = URL_BASE ."img/";



	//$path = "assets/dispositivos/$identificadorDispositivo/$upload_filename";

	

	$path = $dirFiles . $upload_filename;



	// if (!file_exists($path))

	// {

	$resultado = @move_uploaded_file( $_FILES ["archivo"] ["tmp_name"], "img/" . 	$isUsuario . ".jpg" );



	if ($resultado)

	{

		echo json_encode(array('error' => false, 'msg' => $path));

		return;

	}

	else

	{

		echo json_encode(array('error' => true, 'msg' => 'Ocurrio un error al tratar de guardar el archivo.' . $path . '. ' . $_FILES ["archivo"] ["tmp_name"]));

		return;



	}



	// }

	// else

	// {

	// $alert.= '<li> Ya existe un archivo con ese nombre, no es posible guardarlo</li>';

	// $val = 0;

	// }

}

else

{

	echo json_encode(array('error' => true, 'msg' => 'Nombre de archivo o peso no permitido.'));

	return;



}