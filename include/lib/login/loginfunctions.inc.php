<?php

function sec_session_start ()
{

	session_start();

	return;
	/*
	// Configura un nombre de sesión personalizado.
	$session_name = 'sec_session_id';
	$secure = SECURE;

	// Esto detiene que JavaScript sea capaz de acceder a la identificación de
	// la sesión.
	$httponly = true;

	// Obliga a las sesiones a solo utilizar cookies.
	if (ini_set('session.use_only_cookies', 1) === FALSE)
	{
		header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
		exit();
	}

	// Obtiene los params de los cookies actuales.
	$cookieParams = session_get_cookie_params();
	session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"],
			$cookieParams["domain"], $secure, $httponly);

	// Configura el nombre de sesión al configurado arriba.
	session_name($session_name);
	session_start(); // Inicia la sesión PHP.
	session_regenerate_id(); // Regenera la sesión, borra la previa.
	*/
}

function login ($email, $password, $mysqli)
{
	// Usar declaraciones preparadas significa que la inyección de SQL no será
	// posible.
	$query="SELECT idUsuario, password,email, salt FROM usuario WHERE username ='" . mysqli_real_escape_string($mysqli,$email) . "' LIMIT 1";
	
	
	$result=mysqli_query($mysqli, $query);
	if ($result)
	{		
		$row=mysqli_fetch_assoc($result);
		$idUsuario=$row['idUsuario'];
		
		$db_password=$row['password'];  
		$salt=$row['salt'];

		// Hace el hash de la contraseña con una sal única.
		$password = hash('sha512', $password . $salt);
		if (mysqli_num_rows($result)==1)
		{
			// Si el usuario existe, revisa si la cuenta está bloqueada por
			// muchos intentos de conexión.
			
			if (checkbrute($idUsuario, $mysqli) == true)
			{
				// La cuenta está bloqueada.
				// Envía un correo electrónico al usuario que le informa que su
				// cuenta está bloqueada.
				return false;
			}
			else
			{
				// Revisa que la contraseña en la base de datos coincida con la
				// contraseña que el usuario envió.

				 

				if ($db_password == $password)
				{
					// ¡La contraseña es correcta!
					// Obtén el agente de usuario del usuario.
					$user_browser = $_SERVER['HTTP_USER_AGENT'];
					// Protección XSS ya que podríamos imprimir este valor.
					$idUsuario = preg_replace("/[^0-9]+/", "", $idUsuario);
					$_SESSION['idUsuario'] = $idUsuario;
					// Protección XSS ya que podríamos imprimir este valor.
		
					$_SESSION['login_string'] = hash('sha512',$password . $user_browser);
					// Inicio de sesión exitoso
					return true;
				}
				else
				{
					// La contraseña no es correcta.
					// Se graba este intento en la base de datos.
					$now = time();

					$query="INSERT INTO usuario_intento_login(idUsuario, time) VALUES ('$idUsuario', '$now')";
					$record=mysqli_query($mysqli, $query);
					//die("pass incorrecto");

					return false;
				}
			}
		}
		else
		{
			//die("no existe");
			// El usuario no existe.
			return false;
		}
	}
	else
	{
		//die("[" . $query . "]" . mysqli_error($mysqli));
		return false;

	}
}

function checkbrute ($idUsuario, $mysqli)
{
	// Obtiene el timestamp del tiempo actual.
	$now = time();

	// Todos los intentos de inicio de sesión se cuentan desde las 2 horas
	// anteriores.

	$valid_attempts = $now - (2 * 60 * 60);

	$query="SELECT time FROM usuario_intento_login  WHERE idUsuario = '" . mysqli_real_escape_string($mysqli,$idUsuario) . "' AND time > '$valid_attempts'";
	$result=mysqli_query($mysqli, $query);
	if ($result)
	{
		// Si ha habido más de 5 intentos de inicio de sesión fallidos.
		return mysqli_num_rows($result) > LOGIN_ATTEMPS_LIMIT;
	}
	//die("Error en la consulta loginfunctions inc checkbrute ln 129");
	return false;
}

function login_check ($mysqli)
{	
	
	// Revisa si todas las variables de sesión están configuradas.



	if (isset($_SESSION['idUsuario'],$_SESSION['login_string']))
	{
		//die("Aqui1");

		$idUsuario = $_SESSION['idUsuario'];
		$login_string = $_SESSION['login_string'];
		

		// Obtiene la cadena de agente de usuario del usuario.
		$user_browser = $_SERVER['HTTP_USER_AGENT'];

		$query="SELECT password FROM  usuario  WHERE idUsuario = '" . mysqli_real_escape_string($mysqli, $idUsuario ) . "' LIMIT 1";
				
		$result=mysqli_query($mysqli, $query) or die("Error en consulta");
		//die("Aquí2");

		if ($result)
		{
			
			// Une “$user_id” al parámetro.


			if (mysqli_num_rows($result) == 1)
			{
				// Si el usuario existe, obtiene las variables del resultado.
				$row=mysqli_fetch_assoc($result);
				$password=$row['password'];

				$login_check = hash('sha512', $password . $user_browser);
				if ($login_check == $login_string)
				{
					// ¡¡Conectado!!
					return true;
				}
				else
				{
					// No conectado.
					return false;
				}
			}
			else
			{
				// No conectado.
				return false;
			}
		}
		else
		{
			

			// No conectado.
			return false;
		}
	}
	else
	{
		//die( "[4]");
		// No conectado.
		return false;
	}
}

function esc_url ($url)
{
	if ('' == $url)
	{
		return $url;
	}

	$url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '',$url);

	$strip = array('%0d','%0a','%0D','%0A'	);
	$url = (string) $url;

	$count = 1;
	while ($count)
	{
		$url = str_replace($strip, '', $url, $count);
	}

	$url = str_replace(';//', '://', $url);

	$url = htmlentities($url);

	$url = str_replace('&amp;', '&#038;', $url);
	$url = str_replace("'", '&#039;', $url);

	if ($url[0] !== '/')
	{
		// Solo nos interesan los enlaces relativos de $_SERVER['PHP_SELF']
		return '';
	}
	else
	{
		return $url;
	}
}