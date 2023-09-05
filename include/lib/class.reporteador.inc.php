<?php


class clsReporteador extends clsBasicCommon
{

	#------------------------------------------------------------------------------------------------------#
	#----------------------------------------------Propiedades---------------------------------------------#
	#------------------------------------------------------------------------------------------------------#	

	var $fcampos;
	var $ftitulo;
	var $fsubtitulo;
	var $rs;
	private $errorReporter = false;
	private $descError = "";
	private $parametros = array();
	private $fselect;
	private $ftabla;
	private $finner;
	private $fwhere;
	private $fgroup;
	private $forder;
	
	#------------------------------------------------------------------------------------------------------#
	#--------------------------------------------Inicializacion--------------------------------------------#
	#------------------------------------------------------------------------------------------------------#
	
	function __construct()
	{
		global $dbLink;
		if(is_null($dbLink))
		{
			trigger_error("La coneccion a la base de datos no esta establecida.",E_ERROR);
// 			die("La coneccion a la base de datos no esta establecida.");
			return;
		}
		$this->dbLink=$dbLink;
		$this->link=$dbLink;
	}
	
	function __destruct()
	{
			
	}
	
	#------------------------------------------------------------------------------------------------------#
	#------------------------------------------------Setter------------------------------------------------#
	#------------------------------------------------------------------------------------------------------#
	
	public function setParam($key, $value)
	{
		$this->parametros[$key] = $value;
	}
	
	#------------------------------------------------------------------------------------------------------#
	#-----------------------------------------------Unsetter-----------------------------------------------#
	#------------------------------------------------------------------------------------------------------#
	
	#------------------------------------------------------------------------------------------------------#
	#------------------------------------------------Getter------------------------------------------------#
	#------------------------------------------------------------------------------------------------------#
	
	public function getQuery()
	{
		$_strQuery = "SELECT " . $this->fselect .
					  " FROM " . $this->ftabla .
		                  " " . $this->finner;
		
		if ($this->fwhere != "")
		{
			$_strQuery .= " WHERE " .  $this->fwhere . " " ;
		}
		
		if ($this->fgroup != "")
		{
			$_strQuery .= " GROYP BY " .  $this->fgroup . " " ;
		}
		
		if ($this->forder != "")
		{
			$_strQuery .= " ORDER BY " .  $this->forder . " " ;
		}
		
		return $_strQuery;
	}
	
	
	
	public function getDataSet($query)
	{		
		$r=array();
			
		$result=mysqli_query($this->dbLink,$query);
			
		if(!$result)
		{
			return $this->setSystemError("Ocurrio  un error en la obtencion de Dataset.", "[ln51][" . $query . "][" . mysqli_error() . "]");
		}
			
		while($row=mysqli_fetch_assoc($result))
		{
			$r[]=$row;
		}
	
		return $r;
	}
	
	public function getCampos()
	{
		$result = array();
		
		$campos = explode(",", $this->fcampos);
		foreach ($campos as $head)
		{
		 	array_push($result, trim($head));
		}
		
		return $result;
	}
	
	public function getTable($idTable)
	{
		$html = "";
		
		$html .= "<table id='" . $idTable . "' class='table table-striped table-bordered'> ";
		$html .= "<thead> ";
		
		$campos = explode(",", $this->fcampos);
		
		foreach ($campos as $head)		
		{				
			$html .= "<th>" . trim($head) . "</th>";				
		}
		
		$html .= "</thead>";
		
		$html .= "<tbody>";
		
		if(count($this->rs) > 0)
		{
			foreach ($this->rs as $row)
			{
				$html .= "<tr>";
				
				foreach ($row as $col)
				{
					$html .= "<td>".$col."</td>";
				}
				
				$html .= "<td>";
			}
		}
		else 
		{
			$html .= "<tr><td colspan='".count($campos)."'>No se encontr&oacute; informaci&oacute;n.</td></tr>";
		}		
		
		
		$html .= "</tbody>";
		
		
		$html .= "</table>";
		
		
		
		return $html;
	}
	
	public function getTitulo()
	{
		return $this->ftitulo;
	}
		
	public function getSubtitulo()
	{
		return $this->fsubtitulo;
	}
	
	#------------------------------------------------------------------------------------------------------#
	#------------------------------------------------Querys------------------------------------------------#
	#------------------------------------------------------------------------------------------------------#
	
	public function executeQuery ()
	{
		$this->rs = $this->getDataSet($this->getQuery());
	}
	
	#------------------------------------------------------------------------------------------------------#
	#------------------------------------------------Otras-------------------------------------------------#
	#------------------------------------------------------------------------------------------------------#
	
	public function hayError()
	{
		return $this->errorReporter;
	}
	
	public function reporteadorError()
	{
		return $this->descError;
	}
	
	public function printParametros()
	{
		print_r($this->parametros);
	}
	
	public function saluda()
	{
		echo "<br>hola desde class.reporter no directamente";
	}
	
	public function prepare($modulo, $functionname)
	{
		$this->errorReporter = false;
		$this->descError = "";
		$metodo = $modulo."_".$functionname;
		
		if (method_exists($this, $metodo))
		{
			
			$this->$metodo();
		}
		else
		{
			$this->errorReporter = true;
			$this->descError = "No se ha encontrado informaci&oacute;n para generar el reporte.";
		}		
	}
	
	#------------------------------------------------------------------------------------------------------#
	#------------------------------------------------rolloremisiones_movimientorollo-----------------------#
	#------------------------------------------------------------------------------------------------------#
	
	
	public function rolloremisiones_movimientorollo()
	{	
		try 
		{
			$this->fcampos = "Fecha Movimiento, Empleado, Documento, Referencia, Movimiento, Existencia Anterior, Cantidad, Existencia Actual, Observaciones";
			$this->fselect = "fecha_movimiento, concat(nombre, ' ', apellidoPaterno, ' ' , apellidoMaterno) as usrMovimiento, documento, referencia, movimiento, existenciaRollo, cantidad, IF(movimiento = 'ENTRADA', existenciaRollo + cantidad, existenciaRollo - cantidad) as saldo, observaciones";
			$this->ftabla = "invzmovrollo";
			$this->finner = "INNER JOIN usuario as u ON u.idUsuario = id_usuario_movimiento";
			$this->fwhere = "";
			
			if ($this->parametros["mov"] == "ES")
			{
				$this->fwhere = "movimiento IN ('ENTRADA','SALIDA') ";
			}
			else if ($this->parametros["mov"] == "E")
			{
				$this->fwhere = "movimiento IN ('ENTRADA') ";
			}
			else
			{
				$this->fwhere = "movimiento IN ('SALIDA') ";
			}
			
			if (!isset($this->parametros["idrollo"]))
			{
				throw new Exception("Parametros insuficientes para generar consulta");	
			}
			
			$this->fwhere = "idRollo = " . $this->parametros["idrollo"] . " AND " . $this->fwhere;
			
			if (!isset($this->parametros["desde"]) || !isset($this->parametros["hasta"]))
			{
				throw new Exception("Parametros insuficientes para generar consulta");
			}
			
			$this->fwhere = $this->fwhere . " AND date_format(fecha_movimiento, '%Y-%m-%d') BETWEEN '".$this->parametros["desde"]."' AND '".$this->parametros["hasta"]."' ";
			
			$this->fgroup = "";
			$this->forder = "idInvzmovRollo DESC";
			$this->ftitulo = "Reporte";
			$this->fsubtitulo = "";
			
			if (isset($this->parametros["letitle"]))
			{
				$this->ftitulo = $this->parametros["letitle"];
			}
				
			if (isset($this->parametros["lesubtitle"]))
			{
				$this->fsubtitulo = $this->parametros["lesubtitle"];
			}
		}
		catch(Exception $ex)
		{
			$this->errorReporter = true;
			$this->descError = $ex->getMessage();
		}
 		
	}
	
	#------------------------------------------------------------------------------------------------------#
	#------------------------------------------------rolloremisiones_movimientoremisionrollo---------------#
	#------------------------------------------------------------------------------------------------------#
	
	
	public function rolloremisiones_movimientoremisionrollo()
	{
		try
		{
			$this->fcampos = "Fecha Movimiento, Empleado, Documento, Referencia, Movimiento, Existencia Anterior, Cantidad, Existencia Actual, Observaciones";
			$this->fselect = "fecha_movimiento, concat(nombre, ' ', apellidoPaterno, ' ' , apellidoMaterno) as usrMovimiento, documento, referencia, movimiento, existenciaNoRollo, cantidad, IF(movimiento = 'ENTRADA', existenciaNoRollo + cantidad, existenciaNoRollo - cantidad) as saldo, observaciones ";
			$this->ftabla = "invzmovrollo";
			$this->finner = "INNER JOIN usuario as u ON u.idUsuario = id_usuario_movimiento";
			$this->fwhere = "";
				
			if ($this->parametros["mov"] == "ES")
			{
				$this->fwhere = "movimiento IN ('ENTRADA','SALIDA') ";
			}
			else if ($this->parametros["mov"] == "E")
			{
				$this->fwhere = "movimiento IN ('ENTRADA') ";
			}
			else
			{
				$this->fwhere = "movimiento IN ('SALIDA') ";
			}
				
			if (!isset($this->parametros["idremisionrollo"]))
			{
				throw new Exception("Parametros insuficientes para generar consulta");
			}
				
			$this->fwhere = "idRemisionRollo = " . $this->parametros["idremisionrollo"] . " AND " . $this->fwhere;
				
			if (!isset($this->parametros["desde"]) || !isset($this->parametros["hasta"]))
			{
				throw new Exception("Parametros insuficientes para generar consulta");
			}
				
			$this->fwhere = $this->fwhere . " AND date_format(fecha_movimiento, '%Y-%m-%d') BETWEEN '".$this->parametros["desde"]."' AND '".$this->parametros["hasta"]."' ";
				
			$this->fgroup = "";
			$this->forder = "idInvzmovRollo DESC";
			
			$this->ftitulo = "Reporte";
			$this->fsubtitulo = "";
			
			if (isset($this->parametros["letitle"]))
			{
				$this->ftitulo = $this->parametros["letitle"];
			}
			
			if (isset($this->parametros["lesubtitle"]))
			{
				$this->fsubtitulo = $this->parametros["lesubtitle"];
			}
			
		}
		catch(Exception $ex)
		{
			$this->errorReporter = true;
			$this->descError = $ex->getMessage();
		}
			
	}
}