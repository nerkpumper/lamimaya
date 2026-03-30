<?php
class clsBasicCommon
{
	#-----------------------------------------------------------------------------------------------#
	#-------------------------------------------Variables-------------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	var $error=false;
	var $strError="";
	var $warning=false;
	var $arrWarning=array();

	var $debug=false;
	var $debugFile=false;
	var $debugFileName="";

	var $strSystemError;

	var $dbLink;
	var $link;

	var $__s=array();

	var $__fillable=array();
	var $__fillableHeader=array();

	var $__primaryKey="";
	var $__tableName="";
	var $__tableEdit="";
	var $__tableDelete="";

	var $__moreButtons = array();


	#-----------------------------------------------------------------------------------------------#
	#------------------------------------Constructor Destructor-------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	public function __construct($link)
	{
		$this->dbLink=$link;
		$this->link=$link;
	}

	public function __destruct()
	{
	}

	#-----------------------------------------------------------------------------------------------#
	#-----------------------------------------Setter Getter-----------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	public function clearError()
	{
		$this->error=false;
		$this->strError="";
	}

	public function clearMoreButtons()
	{
		$this->__moreButtons = array();
	}



	public function setError($msg)
	{
		$this->error=true;
		$this->strError=$msg;
		return false;
	}

	public function log($mensaje = "", $includeTime=false)
		 {      
			$__filename ="logerr.log";

			if($archivo = fopen($__filename, "a"))
			{
				fwrite($archivo, ($includeTime ? date("d m Y H:m:s"). " " : "---" ). $mensaje. "\n");
						
				fclose($archivo);
			}
		 }

	public function setSystemError($msg,$msgSystem)
	{
		$this->strSystemError=$msgSystem;
		if(defined("DEVELOPER")&&DEVELOPER){
			$this->log($msgSystem, true);
		}
			
		return $this->setError($msg);

	}

	public function getError()
	{
		return $this->error;
	}

	public function getStrError()
	{
		if(defined("DEVELOPER")&&DEVELOPER)
			return $this->strError . ($this->strSystemError!=""?"::SYSERROR: " . $this->strSystemError : "");
		return $this->strError;
	}

	public function getStrSystemError()
	{
		return $this->strSystemError;
	}

	public function setWarning($msg)
	{
		$this->warning=true;
		$this->arrWarning[]=$msg;
	}

	public function addExtraButton ($pageName, $alt, $icon, $style = "btn-info", $moreAttr = "")
	{
		$button = array(
				       "pageName" => $pageName,
				       "alt"      => $alt,
				       "icon"     => $icon,
				       "style"    => $style,
				       "moreAttr" => $moreAttr
		);

		array_push($this->__moreButtons, $button);
	}

	public function getWarning()
	{
		return $this->warning;
	}
	public function getArrWarning()
	{
		return $this->arrWarning;
	}

	public function getStrWarning($s="<br />")
	{
		return implode($s,$this->arrWarning);
	}

	public function clearWarning()
	{
		$this->warning=false;
		$this->arrWarning=array();
	}

	public function getDataSet($query)
	{
		$r=array();

		$result=mysqli_query($this->dbLink,$query);

		if(!$result)
		{
			return $this->setSystemError("Ocurrio  un error en getAll.", "[ln189][" . $query . "][" . mysqli_error($this->link) . "]");
		}
// 		echo $query; return $r;
		while($row=mysqli_fetch_assoc($result))
		{

			$r[]=$row;
		}

		return $r;
	}

	public function executeRaw($query)
	{
		
		$result=mysqli_query($this->dbLink,$query);

		if(!$result)
		{
			return $this->setSystemError("Ocurrio  un error en getAll.", "[ln189][" . $query . "][" . mysqli_error($this->link) . "]");
		}
// 		
		return $result;
	}

	



	public function getTableHTML($rows, $idTable = "tblTabla", $showEdit = false, $showDelete = false, $funcionPosfijo = "", $btnOptionsType = "btn-sm")
	{
		$html = "";

		if ($idTable == "")
			$idTable = $this->__tableName;

			if ($funcionPosfijo == "")
				$funcionPosfijo = $this->__tableName;

				if (count($this->__fillable) != count($this->__fillableHeader))
				{
					$this->__fillableHeader = $this->__fillable;
				}

				$html .= "<table id='" . $idTable . "' class='table table-striped table-bordered'> ";
				$html .= "<thead> ";

				//if (count($rows))
				//{
				foreach ($this->__fillableHeader as $head)
				//foreach ($rows[0] as $key=>$col)
				{

					//if (in_array($key, $this->__fillable))
					//{

					$html .= "<th>" . $head . "</th>";
					//}

				}

				//}

				if ($showEdit || $showDelete)
					$html .= "<th></th>";

					$html .= "</thead> ";

					$html .= "<tbody> ";

					foreach ($rows as $row)
					{
						$html .= "<tr>";
						foreach ($this->__fillable as $f)
						//foreach ($row as $key=>$col)
						{
							//$html .= "<td>" . $col . "</td>";
							$html .= "<td>" . $row[$f] . "</td>";
						}

						if ($showEdit || $showDelete)
						{
							$html .= "<td>";

							if ($showEdit)
								$html .=  "<a href=" . $this->__tableEdit . "/" .  $row[$this->__primaryKey] . " title='Editar' class='btn btn-success " . $btnOptionsType . "'><i class='fa fa-edit'></i></a>";

							$html .= "&nbsp;";

							foreach ($this->__moreButtons as $button)
							{
								$html .=  "<a href=" . $button["pageName"] . "/" .  $row[$this->__primaryKey] . " title='" . $button["alt"] . "' class='btn " . $button["style"] . " " . $btnOptionsType . "'  " . $button["moreAttr"] . "><i class='fa " . $button["icon"] . "'></i></a>";
								$html .= "&nbsp;";
							}

							if ($showDelete)
								$html .=  "<a href=" . $this->__tableDelete . "/" .  $row[$this->__primaryKey] . " title='Eliminar' class='btn btn-danger " . $btnOptionsType . "'><i class='fa fa-trash-o'></i></a>";

							$html .= "</td>";
						}



						//<a  title='Editar' alt='Editar' @click.prevent='editar" . $funcionPosfijo . "(" . $row[$this->__primaryKey] . ")' class='btn btn-success btn-xs'><i class='fa fa-edit'></i></a>
						//<button title='Eliminar' alt='Eliminar' @click.prevent='borrar" . $funcionPosfijo . "(" . $row[$this->__primaryKey] . ")' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></button>

						$html .= "</tr>";
					}

					$html .= "</tboby> ";
					$html .= "</table> ";

					return $html;
	}

	/*  Tabla para Productos */

	public function getTableHTMLProductos($rows, $idTable = "tblTabla", $showEdit = false, $showDelete = false, $funcionPosfijo = "", $btnOptionsType = "btn-sm	")
	{
		$html = "";

		if ($idTable == "")
			$idTable = $this->__tableName;

			if ($funcionPosfijo == "")
				$funcionPosfijo = $this->__tableName;

				if (count($this->__fillable) != count($this->__fillableHeader))
				{
					$this->__fillableHeader = $this->__fillable;
				}

// 				table-striped
				$html .= "<table id='" . $idTable . "' class='table  table-bordered'> ";
				$html .= "<thead> ";

				//if (count($rows))
				//{
				foreach ($this->__fillableHeader as $head)
				//foreach ($rows[0] as $key=>$col)
				{

					//if (in_array($key, $this->__fillable))
					//{

					$html .= "<th>" . $head . "</th>";
					//}

				}
				//}

				if ($showEdit || $showDelete)
					$html .= "<th></th>";

					$html .= "</thead> ";

					$html .= "<tbody> ";
					$color = "";

					$idProducto = 0;
					$idProductoAux = 0;
					
					foreach ($rows as $row)
					{
					    if (isset($row["idProducto"]))
					    {
    					    $idProducto = $row["idProducto"];
    					    if ($idProducto != $idProductoAux)
    					    {
    					        if ($color == "")
    					        {
    					            $color = "#f9f9f9";
    					        }
    					        else
    					        {
    					            $color = "";
    					        }
    					        
    					        $idProductoAux = $idProducto;
    					    }					        
					    }
					    
					    
						$html .= "<tr style='background: ".$color." !important'>";
						foreach ($this->__fillable as $f)
						//foreach ($row as $key=>$col)
						{
							//$html .= "<td>" . $col . "</td>";
							$html .= "<td>" . $row[$f] . "</td>";
						}

						if ($showEdit || $showDelete)
						{
							$html .= "<td>";

// 							if ($showEdit)
// 								$html .=  "<a href=" . $this->__tableEdit . "/" .  $row[$this->__primaryKey] . " alt='Editar' class='btn btn-success " . $btnOptionsType . "'><i class='fa fa-edit'></i></a>";

// 								$html .= "&nbsp;";


								$html .= "<div class='btn-group'>";
								$html .= "<button data-toggle='dropdown' class='btn btn-success btn-sm dropdown-toggle'><i class='fa fa-edit'></i> <span class='caret'></span></button>";
								$html .= "<ul class='dropdown-menu'>";

								$html .= "<li><a href='".$this->__tableEdit . "/" .  $row[$this->__primaryKey]."' title='Editar'><span class='fa fa-edit'></span> Editar Producto</a></li>";

								if ($row["idUnidad"] == "4" || ($row["idUnidad"] == "1" && $row["idRollo"] == "1"))
								{
									$html .= "<li class='divider'></li>";
									$html .= "<li><a href='productoinventario/" .  $row[$this->__primaryKey]."' title='Inventario'><span class='fa fa-slack'></span> Inventario Producto</a></li>";
								}



								$html .= "</ul>";
								$html .= "</div>";


// 								foreach ($this->__moreButtons as $button)
// 								{
// 									$html .=  "<a href=" . $button["pageName"] . "/" .  $row[$this->__primaryKey] . " alt='" . $button["alt"] . "' class='btn " . $button["style"] . " " . $btnOptionsType . "'  " . $button["moreAttr"] . "><i class='fa " . $button["icon"] . "'></i></a>";
// 									$html .= "&nbsp;";
// 								}

// 								$html .=  "<a href='inventario/" .  $row[$this->__primaryKey] . "' alt='Inventario' class='btn btn-success " . $btnOptionsType . "'><i class='fa fa-edit'></i></a>";

								$html .= "&nbsp;";

								if ($showDelete)
									$html .=  "<a href=" . $this->__tableDelete . "/" .  $row[$this->__primaryKey] . " alt='Eliminar' class='btn btn-danger " . $btnOptionsType . "'><i class='fa fa-trash-o'></i></a>";

									$html .= "</td>";
						}



						//<a  title='Editar' alt='Editar' @click.prevent='editar" . $funcionPosfijo . "(" . $row[$this->__primaryKey] . ")' class='btn btn-success btn-xs'><i class='fa fa-edit'></i></a>
						//<button title='Eliminar' alt='Eliminar' @click.prevent='borrar" . $funcionPosfijo . "(" . $row[$this->__primaryKey] . ")' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></button>

						$html .= "</tr>";
					}

					$html .= "</tboby> ";
					$html .= "</table> ";

					return $html;
	}

	/* Fin Tabla para Productos*/

    public function getTableHTML22($rows, $idTable = "tblTabla", $showEditDelete = true, $funcionPosfijo = "")
    {
    	$html = "";

    	if ($idTable == "")
    		$idTable = $this->__tableName;

    	if ($funcionPosfijo == "")
    		$funcionPosfijo = $this->__tableName;

    	if (count($this->__fillable) != count($this->__fillableHeader))
    	{
    		$this->__fillableHeader = $this->__fillable;
    	}

    	$html .= "<table id='" . $idTable . "' class='table table-striped table-bordered'> ";
    	$html .= "<thead> ";

    	//if (count($rows))
    	//{
    		foreach ($this->__fillableHeader as $head)
    		//foreach ($rows[0] as $key=>$col)
    		{

    			//if (in_array($key, $this->__fillable))
    			//{

    				$html .= "<th>" . $head . "</th>";
    			//}

    		}
    	//}

		if ($showEditDelete)
     		$html .= "<th></th>";

		$html .= "</thead> ";

		$html .= "<tbody> ";

 		foreach ($rows as $row)
 		{
 			$html .= "<tr>";
 			foreach ($this->__fillable as $f)
 			//foreach ($row as $key=>$col)
 			{
 				//$html .= "<td>" . $col . "</td>";
 				$html .= "<td>" . $row[$f] . "</td>";
 			}

 			if ($showEditDelete)
 			{
 				$html .= "<td>";
 				$html .= "<a href=" . $this->__tableEdit . "/" .  $row[$this->__primaryKey] . " alt='Editar' class='btn btn-success btn-xs'><i class='fa fa-edit'></i></a>&nbsp;";
 				$html .= "<a href=" . $this->__tableDelete . "/" .  $row[$this->__primaryKey] . " alt='Eliminar' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>";

 					  $html .="</td>";
 			}

 				//<a  title='Editar' alt='Editar' @click.prevent='editar" . $funcionPosfijo . "(" . $row[$this->__primaryKey] . ")' class='btn btn-success btn-xs'><i class='fa fa-edit'></i></a>
 				//<button title='Eliminar' alt='Eliminar' @click.prevent='borrar" . $funcionPosfijo . "(" . $row[$this->__primaryKey] . ")' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></button>

 			$html .= "</tr>";
 		}

 		$html .= "</tdoby> ";
 		$html .= "</table> ";

    	return $html;
    }

    public function getAll($fields = "", $joins = "" , $where = "", $order = "", $group = "")
    {
    	$r=array();

    	if ($fields == "")
    	{
    		$fields = implode(",", $this->__s);
    		//$fields = implode(",", $this->__fillable);
    	}

    	$query = "SELECT " . $fields;
    	$query .= " FROM " . $this->__tableName;

    	if ($joins != "")
    	{
    		$query .= " " . $joins;
    	}

    	if ($where != "")
    	{
    		$query .= " WHERE " . $where;
    	}

    	if ($group != "")
    	{
    	    $query .= " GROUP BY " . $group;
    	}
    	
    	if ($order != "")
    	{
    		$query .= " ORDER BY " . $order;
    	}
    	
    	

    	//echo $query;

    	$result=mysqli_query($this->dbLink,$query);

    	if(!$result)
    	{
    		return $this->setSystemError("Ocurrio  un error en getAll.", "[ln189][" . $query . "][" . mysqli_error($this->link) . "]");
    	}

    	while($row=mysqli_fetch_assoc($result))
    	{
    		$r[]=$row;
    	}

    	return $r;
    }

    public function getAllQUERY($fields = "", $joins = "" , $where = "", $order = "", $group = "")
    {
    	$r=array();

    	if ($fields == "")
    	{
    		$fields = implode(",", $this->__s);
    		//$fields = implode(",", $this->__fillable);
    	}

    	$query = "SELECT " . $fields;
    	$query .= " FROM " . $this->__tableName;

    	if ($joins != "")
    	{
    		$query .= " " . $joins;
    	}

    	if ($where != "")
    	{
    		$query .= " WHERE " . $where;
    	}

    	
    	if ($group != "")
    	{
    	    $query .= " GROUP BY " . $group;
    	}
    	
    	if ($order != "")
    	{
    		$query .= " ORDER BY " . $order;
    	}
    	
    	

    	return $query;

    }

    public function getOptionForSelect($rs, $valuecero = "0", $nombrecero = "-- Seleccione --")
    {
    	$result = "";

    	$result = "<option value='".$valuecero."'>".$nombrecero."</option>";
		// var_dump($rs);
		if ($rs)
		{
			foreach ($rs as $row)
			{
				$result .= "<option value='".$row["value"]."'>".$row["theoption"]."</option>";
			}
		}


    	return $result;
    }

    public function getOptionForSelectOnlyList($rs)
    {
    	$result = "";

    	foreach ($rs as $row)
    	{
    		$result .= "<option value='".$row["value"]."'>".$row["theoption"]."</option>";
    	}


    	return $result;
    }

    public function getForSelect($id, $value, $where = "", $order = "")
    {
    	$r=array();

    	$query = "SELECT " . $id . " as value, " . $value . " as theoption " ;
    	$query .= " FROM " . $this->__tableName;

		// echo "<br><br>". $query. "<br><br>";

    	if ($where != "")
    	{
    		$query .= " WHERE " . $where;
    	}

		// echo "<br><br>". $query. "<br><br>";

    	if ($order != "")
    	{
    		$query .= " ORDER BY " . $order;
    	}
		// echo "<br><br>". $query. "<br><br>";
    	$result=mysqli_query($this->dbLink,$query);

    	if(!$result)
    	{
    		return $this->setSystemError("Ocurrio  un error en getForSelect.", "[ln216][" . $query . "][" . mysqli_error($this->link) . "]");
    	}

    	while($row=mysqli_fetch_assoc($result))
    	{
    		$r[]=$row;
    	}

    	return $r;
    }

	#-----------------------------------------------------------------------------------------------#
	#-----------------------------------------------------------------------------------------------#


	#-----------------------------------------------------------------------------------------------#
	#---------------------------------------------Otras---------------------------------------------#
	#-----------------------------------------------------------------------------------------------#

    public function varDump($obj)
    {
    	echo "<pre>";
    	print_r($obj);
    	echo "</pre>";
    }

    public function NOW()
    {
    	return date("Y-m-d H:i:s");
    }

    public function CURDATE()
    {
    	return date("Y-m-d");
    }

    public function CURTIME()
    {
    	return date("H:i:s");
    }

    public function existeField($field, $value, $idToOmitir = 0)
    {
    	try
    	{
    		$SQL = "SELECT " . $field . "
					FROM " . $this->__tableName . "
					WHERE " . $field . " = '" . mysqli_real_escape_string ( $this->dbLink, $value ) . "'
					AND " . $this->__primaryKey . " <> " . mysqli_real_escape_string ( $this->dbLink, $idToOmitir );

    		$result = mysqli_query ( $this->dbLink, $SQL );

    		if (! $result)
    			return $this->setSystemError ( "Error en la verificacion de nombre de los dispositivos.", "[ModeloBaseDispositivo::existeNombre][" . $SQL . "][" . mysqli_error ( $this->dbLink ) . "]" );

    			
//     			return $SQL . "   ---->  " . mysqli_num_rows ( $result );
    			
    		if (mysqli_num_rows ( $result ) > 0)
    			return true;

    		return false;

    	}
    	catch ( Exception $e )
    	{
    		return $this->setErrorCatch ( $e );
    	}
    }

	public function dumpAsTable($newLine = '<br>')
	{
		$this->dumpBeginTable();
		$this->dumpAsHeaderTable($newLine);
		$this->dumpAsRowTable($newLine);
		$this->dumpEndTable();
	}

	public function dumpObj($newLine = '<br>')
	{
		echo $newLine;
		echo $this->_nombreClase . ":" . $newLine;

		foreach ($this->__s as $s)
		{
			echo "    - " . $s . "  =  " . $this->$s . $newLine;
		}
		echo $newLine;
	}

	public function dumpBeginTable ()
	{
		echo "<table border='1'>";
	}

	public function dumpEndTable ()
	{
		echo "</table>";
	}

	public function dumpAsHeaderTable($newLine = '<br>')
	{

		echo "<tr>";
		foreach ($this->__s as $s)
		{
			echo "<td>";
			echo "<strong>". $s . "</strong>";
			echo "</td>";
		}
		echo "</tr>";
	}

	public function dumpAsRowTable($newLine = '<br>')
	{
		echo "<tr>";
		foreach ($this->__s as $s)
		{
			echo "<td>";
			echo $this->$s;
			echo "</td>";
		}
		echo "</tr>";
	}

	public function toUpper()
	{
		foreach($this->__s as $k=>$v)
			$this->$v=strtoupper($this->$v);
	}


	public function transaccionIniciar()
	{
		if(function_exists("mysqli_begin_transaction"))
		{
			$r=mysqli_begin_transaction($this->dbLink);
		}
		else
		{
			$query="START TRANSACTION";
			$r=mysqli_query($this->dbLink, $query);
		}
		if(!$r)
			return $this->setSystemError("Error en la BD", mysql_error());
		return true;
	}

	public function transaccionCommit()
	{
		if(function_exists("mysqli_commit"))
		{
			$r=mysqli_commit($this->dbLink);
		}
		else
		{
			$query="COMMIT";
			$r=mysqli_query($this->dbLink, $query);
		}
		if(!$r)
			return $this->setSystemError("Error en la BD", mysql_error());
		return true;

	}

	public function transaccionRollback()
	{
		if(function_exists("mysqli_rollback"))
		{
			$r=mysqli_rollback($this->dbLink);
		}
		else
		{
			$query="ROLLBACK";
			$r=mysqli_query($this->dbLink, $query);
		}
		if(!$r)
			return $this->setSystemError("Error en la BD", mysql_error());
		return true;
	}





	public function serialize()
	{
		$valores=array();
		foreach($this->__s AS $k=>$v)
		{
			$valores[$v]=$this->$v;
		}
		return serialize($valores);
	}

	public function unserialize($v)
	{

		$valores=unserialize($v);
		foreach($valores AS $k=>$v)
		{
			$this->$k=$v;
		}
	}


	#-----------------------------------------------------------------------------------------------#
	#---------------------------------------------S Q L---------------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	//Set user and date of what ever event

	public function setDateAndUser($evento, $idUsuario = 2)
	{
		global $objSession;

		//$evento = creacion
		$fecha_evento = "fecha_".$evento;   //fecha_creacion
		$idUsuarioEvento = "id_usuario_".$evento; //id_usuario_creacion

		try
		{
			if(property_exists($this,$fecha_evento)  && property_exists($this,$idUsuarioEvento) )
			{
				$this->$fecha_evento = $this->NOW();
				
				$usuario = "";
				if (!isset($objSession))
				    $usuario = $idUsuario;
				else
				    $usuario = $objSession->getIdUsuario();
				
				$this->$idUsuarioEvento = $usuario;
			}
		}
		catch (Exception $e)
		{

		}
	}

	public function setDate($evento)
	{
		global $objSession;

		//$evento = creacion
		$fecha_evento = "fecha_".$evento;   //fecha_creacion
		
		try
		{
			if(property_exists($this,$fecha_evento))
			{
				$this->$fecha_evento = $this->NOW();					
			}
		}
		catch (Exception $e)
		{

		}
	}


	public function AplicaBaja()
	{
		try
		{
			$this->setDateUserDeleting();
			$this->setEstadoBAJA();

			$idTabla="" . $this->__primaryKey;

			$SQL="UPDATE " . $this->__tableName . " SET
	                                              estado='" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
	                                              fecha_baja='" . mysqli_real_escape_string($this->dbLink,$this->NOW()) . "',
	                                              idUsuarioBaja='" . mysqli_real_escape_string($this->dbLink,$this->getIdUsuarioBaja()) . "'
					WHERE ".$this->__primaryKey."=" . $this->$idTabla;

			$result=mysqli_query($this->dbLink,$SQL);
			if(!$result)
				return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCliente::Update]");

				return true;
		}
		catch (Exception $e)
		{
			return $this->setErrorCatch($e);
		}
	}

	public function setDateUserCreating()
	{
		global $objSession;
		try
		{
			if(property_exists($this,"fecha_creacion")  && property_exists($this,"idUsuarioCrea") )
			{
				$this->fecha_creacion = $this->NOW();
				$this->idUsuarioCrea = $objSession->getIdUsuario();
			}
		}
		catch (Exception $e)
		{

		}
	}



	public function setDateUserUpdating()
	{
		global $objSession;
		try
		{
			if(property_exists($this,"fecha_modifica")  && property_exists($this,"idUsuarioModifica") )
			{
				$this->fecha_modifica = $this->NOW();
				$this->idUsuarioModifica = $objSession->getIdUsuario();
			}
		}
		catch (Exception $e)
		{

		}
	}

	public function setDateUserDeleting()
	{
		global $objSession;
		try
		{
			if(property_exists($this,"fecha_baja")  && property_exists($this,"idUsuarioBaja") )
			{
				$this->fecha_baja = $this->NOW();
				$this->idUsuarioBaja = $objSession->getIdUsuario();
			}
		}
		catch (Exception $e)
		{

		}
	}









}
