<?php

date_default_timezone_set("America/Mexico_City");

require_once "apiconfiginclude.inc.php";
define("FOLDER_MODEL_BASE", FOLDER_INCLUDE . "model/base/");
define("FOLDER_MODEL", FOLDER_INCLUDE . "model/extend/");
require_once FOLDER_INCLUDE . 'model/clsBasicCommon.inc.php';
define("LIB_CONEXION", FOLDER_INCLUDE ."lib/Conexion/Conexion.inc.php");
require_once LIB_CONEXION;

class APIBase{
    
    var $method = '';
    var $idUsuario = 0;
    var $checkSecurity = false;
    var $response = array();

    public function __construct()
	{        
		$this->method = $_GET["method"];        
	}
    
    public function addResponse($key, $value){
        $this->response[$key] = $value; 
    }

    public function run(){
        if ($this->checkSecurity)
        {
            $headers = apache_request_headers();
            if ($headers == null)
            {
                header("HTTP/1.1 401 Unauthorized");
                die();        
            }

            if (!isset($headers['IdUsuario']))
            {
                header("HTTP/1.1 401 Unauthorized");
                die();        
            }

            $this->idUsuario = $headers['IdUsuario'];
        }
        else
        {
            $this->idUsuario = 2;
        }


        if(method_exists($this, $this->method))
		{
            try
            {
                call_user_func(array($this, $this->method));
                $this->getResponse();        			
            }
            catch(Exception $e)
            {
                $this->throwError("Error in " . $this->method.". " . $e->getMessage());        			    
            }
		}
		else
		{
			$this->throwError("Metodo solicitado no existe");        			
		}
    }
    
    public function getResponse(){
        header('Content-type: application/json');
        echo json_encode($this->response);
    }

    public function throwError($msg){
        header('Content-type: application/json');
        echo json_encode(array("error" => true, "msg" => $msg));
        die();
    }
}