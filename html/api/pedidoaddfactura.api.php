<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.pedido.inc.php";
require_once FOLDER_MODEL. "model.cliente.inc.php";

class APIPedidoAddFactura extends APIBase{

           
    public function uploadfiles(){
        
        // $ff = $_POST["files"];

        $permitidos = array("application/pdf","application/xml", "text/xml");
        $upload_filename = strtolower(str_replace(" ", "_", basename($_FILES['archivo']['name'])));
        $idPedido = $_POST["idPedido"];

        if (preg_match("/[^0-9a-zA-Z_.-]/", $upload_filename))
        {
            $this->addResponse('error', true);
            $this->addResponse('msg', 'El nombre del archivo tiene caracteres no v&aacute;lidos.');
        } 
        else if (in_array($_FILES['archivo']['type'], $permitidos)){
            $dirFiles = FILES_FOLDER.$idPedido.DIRECTORY_SEPARATOR;            
            $path = $dirFiles.$upload_filename;
            
            if (!$this->folder_exist($dirFiles)){
                
                mkdir($dirFiles);
            }

            if (file_exists($path)){
                $this->throwError("Ya existe un archivo con el nombre de archivo que desea subir.");
                return;
            }

            $resultado = @move_uploaded_file($_FILES["archivo"]["tmp_name"], $path);    

            if ($resultado)
            {
                $this->addResponse('error',false);
                $this->addResponse('msg', $path);

            } 
            else{
                $this->addResponse('error', true);
                $this->addResponse('msg', 'Ocurrio un error al tratar de guardar el archivo.'.$path.
                    '. '.$_FILES["archivo"]["tmp_name"]);
            }
        } else
        {   
            $this->throwError("Tipo de archivo no permitido ". $_FILES['archivo']['type']);
        }
           
    }

    function folder_exist($folder)
    {
        // Get canonicalized absolute pathname
        $path = realpath($folder);

        // If it exist, check if it's a directory
        return ($path !== false AND is_dir($path)) ? $path : false;
    }

    public function cargarArchivos(){
        $idPedido = $_GET["idPedido"];

        $pedido = new ModeloPedido();
        $pedido->setIdPedido($idPedido);

        if ($pedido->getIdpedido() > 0 ){
            $cliente = new ModeloCliente();

            $cliente->setIdCliente($pedido->getIdCliente());

            $dirFiles = FILES_FOLDER.$idPedido.DIRECTORY_SEPARATOR;            
            $result = [];
            if (file_exists($dirFiles)) {
                $d = scandir($dirFiles);
                foreach($d as $file) {
                    if ($file !== "." && $file !== "..") {

                        array_push($result, array("fileName" => $file,                      
                                    "creation" => date("d/m/Y H:i", filectime($dirFiles.$file)))); // "$file");
                    }
                    
                }                
            }
            $this->addResponse("error", false);
            $this->addResponse("files", $result);
            $this->addResponse("cliente", $cliente->getNombre() . " " . $cliente->getApellidos());
            $this->addResponse("totalPedido", $pedido->getTotal());
        }
        else{
            $this->throwError("Parece que el pedido que ha indicado no existe.");
        }
    }
}

$api = new APIPedidoAddFactura();
$api->run();