<?php


	require_once FOLDER_MODEL . "model.login_members_permisos_especiales.inc.php";
	require_once FOLDER_MODEL . "model.pagina_modulo.inc.php";
	require_once FOLDER_MODEL . "model.pagina_modulo_agrupado.inc.php";
	require_once FOLDER_MODEL . "model.rol.inc.php";
	require_once FOLDER_MODEL . "model.rol_modulo_agrupado.inc.php";
	require_once FOLDER_MODEL . "model.pagina.inc.php";
	
	require_once FOLDER_MODEL . "model.seccion.inc.php";
	require_once FOLDER_MODEL . "model.subseccion.inc.php";


/**
 * Obtiene el valor del permiso de acuerdo al logueo y al módulo.
 * Los parámetros opcionales se pueden omitir cuando el modulo ya esta registrado en base de datos.
 * Si no se especifican todos los parámetros y el módulo no existe en la base de datos, se dispara un warning.
 * @param string $clave hasta 50 caracteres, identificador del módulo, puede repetirse si el módulo aparece en mas de una sección
 * @param string $tipoModulo [optional ] [default:''] valores: 'alta','consulta','edicion','borrado'
 * @param string $permisoDefault [optional] [default: 'asignado'] valores: 'asignado', 'noasignado', si el modulo es nuevo, por default se permite el acceso
 * @return Regresa true si el usuario tiene permiso para el modulo, false en caso contrario
 * */	

function permiso($clave,  $tipoModulo="",$permisoDefault="asignado",$page="")
{
	global $objSession;
	global $__FILE_NAME__;
	if($page=="")
		$page=$__FILE_NAME__;
	
	if(!is_file("./" . $page . ".php"))
	{
		trigger_error("La pagina (destino) no existe.",E_USER_WARNING);
		die();
	}
	
	//if($objSession->getRol()=="root")
	//	return true;
	
	if($clave=="")
	{
		trigger_error("Clave de modulo vacia.",E_USER_WARNING);
		die();
	}
	
	$arrTipo=array('visita','alta','consulta','edicion','borrado');
	if($tipoModulo!=""&&!in_array($tipoModulo, $arrTipo))
	{
		trigger_error("Tipo de modulo erroneo.",E_USER_WARNING);
		die();
	}
	
	
	/*---------------------------------------------------------------------------------------------------------------*/
	/*---------------Se verifica la existencia de la pagina en base de datos, si no existe, se agrega.---------------*/
	/*---------------------------------------------------------------------------------------------------------------*/
	$Pagina=verificaPagina($page);
	
	
	
	
	/*---------------------------------------------------------------------------------------------------------------*/
	/*------------Se verifica la existencia de modulo agrupado en base de datos, si no existe, se agrega.------------*/
	/*---------------------------------------------------------------------------------------------------------------*/
	
	$Grupo=new ModeloPagina_modulo_agrupado();
	$Grupo->setClave($clave);
	if(!$Grupo->existe())
	{
		if($tipoModulo=="")
		{
			trigger_error("No se especifico el tipo de modulo para nuevo registro.",E_USER_WARNING);
			die();
		}
		$Grupo->setTipo($tipoModulo);
		$Grupo->Guardar();
		if($Grupo->getError())
			die($Grupo->getStrError());
		
		$Modulo=new ModeloPagina_modulo();
		$Modulo->setClave($clave);
		$Modulo->setTipo($tipoModulo);
		$Modulo->setIdPaginaModuloAgrupado($Grupo->getIdPaginaModuloAgrupado());
		$Modulo->setIdPagina($Pagina->getIdPagina());
		$Modulo->Guardar();
		if($Modulo->getError())
			die($Modulo->getStrError());
	}
	else
	{
		$Grupo->getDatosByClave();
		$Modulo=new ModeloPagina_modulo();
		$Modulo->setClave($clave);
		$Modulo->setIdPagina($Pagina->getIdPagina());
		
		/*---------------------------------------------------------------------------------------------------------------*/
		/*-----------------Se verifica la existencia de modulo en base de datos, si no existe, se agrega.----------------*/
		/*---------------------------------------------------------------------------------------------------------------*/
		
		if(!$Modulo->existe())
		{	
			if($tipoModulo=="")
			{
				trigger_error("No se especificó el tipo de módulo para nuevo registro.",E_USER_WARNING);
				die();
			}
			$Modulo->setTipo($tipoModulo);
			$Modulo->setIdPaginaModuloAgrupado($Grupo->getIdPaginaModuloAgrupado());
			$Modulo->Guardar();
			if($Modulo->getError())
				die($Modulo->getStrError());
		}
		else
		{
			$Modulo->getDatosByClavePagina();
		}
	}
	
	$Pagina->transaccionCommit();
	if($Pagina->getError())
		die($Pagina->getStrError());
		
	/*---------------------------------------------------------------------------------------------------------------*/
	/*-----------------------------Se verifica permiso en permisos especiales de usuario.----------------------------*/
	/*---------------------------------------------------------------------------------------------------------------*/
		
	$Especial=new ModeloLogin_members_permisos_especiales();
	
	$Especial->setIdLoginMember($objSession->getIdLoginMember());
	$Especial->setIdPaginaModuloAgrupado($Grupo->getIdPaginaModuloAgrupado());
	
	if($Especial->existe())
	{
		$Especial->getDatosByLoginGrupo();
		return $Especial->getAcceso()=="si";
	}
	
	/*---------------------------------------------------------------------------------------------------------------*/
	/*--------------------------------Se verifica permiso en base al rol del usuario.--------------------------------*/
	/*---------------------------------------------------------------------------------------------------------------*/
	
	$Permiso=new ModeloRol_modulo_agrupado();
	$Permiso->setIdPaginaModuloAgrupado($Grupo->getIdPaginaModuloAgrupado());
	$Permiso->setIdRol($objSession->getIdRol());
	return $Permiso->existe()||$permisoDefault=="asignado";
	
}

function verificaPagina($page="")
{	
	global $__FILE_NAME__;
	if($page=="")
		$page=$__FILE_NAME__;
	
	
	$Pagina=new ModeloPagina();
	$Pagina->transaccionIniciar();
	if($Pagina->getError())
		die($Pagina->getStrError());
	$Pagina->setNombre($page);
	if(!$Pagina->existe())
	{
		$Pagina->Guardar();
		if($Pagina->getError())
			die($Pagina->getStrError());

	}
	else
	{
		$Pagina->getDatosByNombre();
	}
	if($Pagina->getError())
		die($Pagina->getStrError());
	
	return $Pagina;
}

function generaMenuTop()
{
	global $objSession;
	global $__FILE_NAME__;
	global $dbLink;
	
	$Pagina=verificaPagina();
	$Subseccion=new ModeloSubseccion();
	$Subseccion->setIdSeccion($Pagina->getIdSubseccion());
	
	$idPagina=$objSession->getidPaginasPermitidas();
	
	/*
	$query="SELECT S.idSeccion AS idSeccion, S.destino As destino,S.nombre AS nombre, S.autenticacion As autenticacion 
			FROM seccion AS S 
			-- INNER JOIN subseccion AS SB ON SB.idSeccion=S.idSeccion
			-- INNER JOIN pagina AS P ON SB.idSubSeccion=P.idSubseccion
			-- WHERE P.idPagina IN(" . implode(",",$idPagina) . ")
			ORDER BY S.posicion ASC";
	die($query);
	*/
	
	$query="SELECT DISTINCT S.idSeccion AS idSeccion, S.destino As destino,S.nombre AS nombre, S.autenticacion As autenticacion
			FROM seccion AS S
			INNER JOIN subseccion AS SB ON SB.idSeccion=S.idSeccion
			INNER JOIN pagina AS P ON SB.idSubSeccion=P.idSubseccion
			WHERE P.idPagina IN(" . implode(",",$idPagina) . ")
			ORDER BY S.posicion ASC";
	
	$result=mysqli_query($dbLink, $query);
	
	
	$menu='';
	while($r=@mysqli_fetch_assoc($result))
	{
		if($r['autenticacion']==0)
			$menu.='<li ' . ($Subseccion->getIdSeccion()==$r['idSeccion']?'class="active"':'') . '><a href="' . $r['destino'] . '.php">' . $r['nombre'] . '</a></li>';
		else
			$menu.='<li ' . ($Subseccion->getIdSeccion()==$r['idSeccion']?'class="active"':'') . '><a href="' . $r['destino'] . '.php">' . $r['nombre'] . '</a></li>';
	}
	$Pagina->transaccionCommit();
	return $menu;
	
}

function construccionMenuLateral($lateral,$Pagina)
{
	$strRetorno='';
	foreach($lateral AS $id=>$elementos)
	{
		
		if(isset($elementos['contenido']))
		{
			$subcontenido=construccionMenuLateral($elementos['contenido'], $Pagina);
			if($elementos['abierto'])
			{
				$abierto='class="menu-open"';
				$direccion="down";
			}
			else
			{
				$abierto="";
				$direccion="left";
			}
			$strRetorno.='
					<li ' . $abierto . '>
						<a href="#">' . $elementos['nombre'] . '
							<i class="fa ' . $elementos['icono'] . '"></i> 
							<i class="fa fa-caret-' . $direccion . '"></i>
						</a>
						' . $subcontenido . '
					</li>';
		}
		else
		{
			$strRetorno.='
					<li ' . ($Pagina->getidSubseccion()==$elementos['idSubseccion']?'class="page-arrow active-page"':'') . '>
						<a href="' . $elementos['destino'] . '.php">' . $elementos['nombre'] . '
							<i class="fa ' . $elementos['icono'] . '"></i>
						</a>
					</li>';
		}
		
		
	}
	return '
				<ul>
					' . $strRetorno . '
				</ul>';
}


function generaMenuLateral()
{
	global $objSession;
	global $__FILE_NAME__;
	global $dbLink;
	
	$Pagina=verificaPagina();
	$Pagina->transaccionCommit();
	
	$Subseccion=new ModeloSubseccion();
	$Subseccion->setIdSubseccion($Pagina->getIdSubseccion());
	
	
	
	$query="SELECT idSubseccion, nombre, clave, destino, posicion,padre,icono 
			FROM subseccion 
			WHERE idSeccion=" . $Subseccion->getIdSeccion() . " 
			ORDER BY padre ASC, posicion ASC";
	$result=mysqli_query($dbLink, $query);
	if(!$result)
		die(mysqli_error($dbLink));
	
		
	$lateral=array();
	
	while($r=mysqli_fetch_assoc($result))
	{
		if($r['padre']==0)
		{
			$lateral[$r['idSubseccion']]['nombre']=$r['nombre'];
			$lateral[$r['idSubseccion']]['icono']=$r['icono'];
			$lateral[$r['idSubseccion']]['abierto']=0;
			$lateral[$r['idSubseccion']]['contenido']=array();
		}
		else
		{
			$elemento['nombre']=$r['nombre'];
			$elemento['destino']=$r['destino'];
			$elemento['idSubseccion']=$r['idSubseccion'];
			$elemento['icono']=$r['icono'];
			$lateral[$r['padre']]['contenido'][]=$elemento;
			if($Pagina->getIdSubseccion()==$r['idSubseccion'])
				$lateral[$r['padre']]['abierto']=1;
		}
	}
	
	
	$strMenuLateral= construccionMenuLateral($lateral,$Pagina);
	//echo $strMenuLateral;
	
	//print_r($Pagina);
	//print_r($lateral);
	//die();
	
	return '
			<div class="sidebar-module"> 
				<nav class="sidebar-nav-v2">
					' . $strMenuLateral . '
				</nav>
			</div>';
	
	
	
	
	
	
	
		
	
	
	
	
	
}
	
	