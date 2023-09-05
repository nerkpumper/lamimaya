<?php


	function returnAppError($msgError)
	{
		$R=new clsAppGenericResponse();
		$R->setResult("NOK");
		$R->setMsg($msgError);
		die($R->getJSONResponse());
	}




	class clsAppGenericResponse
	{
		var $result;
		var $msg="";
		var $data="";

		public function setResult($result)
		{
			$this->result=$result;
		}
		public function setMsg($msg)
		{
			$this->msg=$msg;
		}

		public function setData($data)
		{
			$this->data=$data;
		}

		public function getJSONResponse()
		{
			$r=array("result"=>$this->result,"msg"=>$this->msg,"data"=>json_encode($this->data));
			return json_encode($r);
		}

	}

	class clsAppGenericProcess
	{
		var $token;
		var $param;


		public function setParam($param)
		{
			$Parametros=json_decode($param);
			foreach($Parametros AS $variable=>$valor)
				$this->$variable=$valor;
		}



	}