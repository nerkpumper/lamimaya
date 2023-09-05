<?php
class ajax
{
	public function processRequest()
	{
		if(isset($_POST)&&isset($_POST['ajax']))
		{
			if(function_exists($_POST['ajax']))
			{
				if(isset($_POST['args']))
				{
					$arg=json_decode(str_replace('\"','"',$_POST['args']));
					$response=call_user_func_array($_POST['ajax'],$arg);
					die($response->getJSON());
				}
				die(json_encode(array("result"=>"error","msg"=>"No se encontraron los argumentos de la acción","data"=>array())));
			}
			die(json_encode(array("result"=>"error","msg"=>"La acción no esta registrada","data"=>array())));
		}
	}
}

class ajaxResponse
{
	var $response=array();

	public function call($args)
	{
		if(func_num_args()==0)
		{
			die("Error en el pase de parametros ajaxResponse call");
		}
			
		if (func_num_args() > 1)
		{
			$args=func_get_args();
			$action=array_shift($args);
			$this->response[]=array("type"=>"action","action"=>$action,"args"=>$args);
		}
		else
			$this->response[]=array("type"=>"action","action"=>$action,"args"=>array());
	}

	public function value($control,$valor)
	{
		$this->response[]=array("type"=>"value","control"=>$control,"valor"=>$valor);
	}

	public function label($control,$valor)
	{
		$this->response[]=array("type"=>"label","control"=>$control,"valor"=>$valor);
	}

	public function enabled($control,$valor)
	{
		$this->response[]=array("type"=>"enabled","control"=>$control,"valor"=>$valor);
	}

	public function redirect($destino)
	{
		$this->response[]=array("type"=>"redireccion","destino"=>$destino);
	}

	public function mostrarAviso($mensaje="")
	{
		if($mensaje=="")
			$this->call("mostrarAviso");
		else
			$this->call("mostrarAviso",$mensaje);
	}
	public function mostrarError($mensaje="")
	{
		if($mensaje=="")
			$this->call("mostrarError");
		else
			$this->call("mostrarError",$mensaje);
	}
	public function mostrarEspera($mensaje="")
	{
		if($mensaje=="")
			$this->call("mostrarEspera");
		else
			$this->call("mostrarEspera",$mensaje);
	}
	public function mostrarDenegado($mensaje="")
	{
		if($mensaje=="")
			$this->call("mostrarDenegado");
		else
			$this->call("mostrarDenegado",$mensaje);
	}
	public function mostrarExito($mensaje="")
	{
		if($mensaje=="")
			$this->call("mostrarExito");
		else
			$this->call("mostrarExito",$mensaje);
	}
	public function ocultarMensaje()
	{
		$this->call("ocultarMensaje");
	}
	 
	public function getJSON()
	{

		return json_encode($this->response);
	}
}