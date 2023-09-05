<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.datosfacturacion.inc.php";
require_once FOLDER_MODEL. "model.clientedatosfacturacion.inc.php";
require_once FOLDER_MODEL. "model.cliente.inc.php";

class APIDatosFacturacion extends APIBase{

    public function get(){
        $idDatosFacturacion = $_GET["idDatosFacturacion"];

        $query = "
                SELECT idDatosFacturacion,
                        rfc,
                        email,
                        razonSocial,
                        domicilio,
                        numero,
                        colonia,
                        ciudad,
                        codigoPostal,
                        idUsoCfdi,
                        idRegimenFiscal,
                        credito,
                        capacidadPago,
                        privado                    
                FROM  datosfacturacion        
                WHERE idDatosFacturacion = " . $idDatosFacturacion ;

        $datosfacturacion = new ModeloDatosfacturacion();

        $rs = $datosfacturacion->getDataSet($query);

        if (count($rs) > 0)
        {
            $this->addResponse("error", false);  
            $this->addResponse("datosfacturacion", $rs[0]);          
        }
        else
        {
            $this->addResponse("error", true);  
            $this->addResponse("msg", "No se pudo recuperar la información");          
        }
       
        
    }

    public function saveRFCCreditos(){
        $idCliente = $_POST["idCliente"];
        $creditoCliente = $_POST["creditoCliente"];
        $capacidadPagoCliente = $_POST["capacidadPagoCliente"];
        
        $cliente = new ModeloCliente();

        $cliente->transaccionIniciar();
        $cliente->setIdCliente($idCliente);
                
        $cliente->setCredito($creditoCliente);
        $cliente->setCapacidadPago($capacidadPagoCliente);
        
        $cliente->setDate("modifica");
        $cliente->setIdUsuarioModifica($this->idUsuario);
        $cliente->Guardar();

        if ($cliente->getError())
        {
            $cliente->transaccionRollback();
            $this->throwError($cliente->getStrError());
        }
        
        $cliente->transaccionCommit();
        
        $this->addResponse("error", false);
    }

    public function addDatosFacturacion(){
        $idCliente = $_POST["idCliente"];
        $idDatosFacturacion = $_POST["idDatosFacturacion"];

        $query = "SELECT idClienteDatosFacturacion
                  FROM clientedatosfacturacion
                  WHERE idCliente = ".$idCliente."
                  AND   idDatosFacturacion = " . $idDatosFacturacion;

        $clienteDatosFacturacion = new ModeloClientedatosfacturacion();

        $rs = $clienteDatosFacturacion->getDataSet($query);

        if (count($rs) > 0)
        {
            $this->throwError("No se pudo agregar el RFC al Cliente, al parecer, ya lo tiene asignado");
        }
        else
        {
            $clienteDatosFacturacion->setIdCliente($idCliente);
            $clienteDatosFacturacion->setIdDatosFacturacion($idDatosFacturacion);            
            $clienteDatosFacturacion->setDateAndUser("insert", $this->idUsuario);
            $clienteDatosFacturacion->setDateAndUser("update", $this->idUsuario);            

            $clienteDatosFacturacion->Guardar();

            if ($clienteDatosFacturacion->getError())
            {
                $this->throwError($clienteDatosFacturacion->getStrError());
            }
        }

        $this->addResponse("error", false);
    }

    public function getall(){
        $idCliente = $_GET["idCliente"];

        $obtenerDatosPropios = true;

        if (isset($_GET["deotros"]))
        {
            $obtenerDatosPropios = false;
        }

        if ($obtenerDatosPropios)
        {
            $query = "
                    SELECT clientedatosfacturacion.idCliente,     
                            clientedatosfacturacion.idClienteDatosFacturacion,           
                            datosfacturacion.idDatosFacturacion,
                            datosfacturacion.rfc,
                            datosfacturacion.email,
                            datosfacturacion.razonSocial,
                            datosfacturacion.domicilio,
                            datosfacturacion.numero,
                            datosfacturacion.colonia,
                            datosfacturacion.ciudad,
                            datosfacturacion.codigoPostal,
                            datosfacturacion.idUsoCfdi,
                            datosfacturacion.privado                            
                    FROM clientedatosfacturacion
                    INNER JOIN datosfacturacion
                    ON datosfacturacion.idDatosFacturacion = clientedatosfacturacion.idDatosFacturacion
                    WHERE clientedatosfacturacion.idCliente = " . $idCliente;
        }
        else
        {
            $query = "
                    SELECT clientedatosfacturacion.idCliente,
                            clientedatosfacturacion.idClienteDatosFacturacion,           
                            datosfacturacion.idDatosFacturacion,
                            datosfacturacion.rfc,
                            datosfacturacion.email,
                            datosfacturacion.razonSocial,
                            datosfacturacion.domicilio,
                            datosfacturacion.numero,
                            datosfacturacion.colonia,
                            datosfacturacion.ciudad,
                            datosfacturacion.codigoPostal,
                            datosfacturacion.idUsoCfdi,
                            datosfacturacion.privado
                    FROM clientedatosfacturacion 
                    INNER JOIN datosfacturacion
                    ON datosfacturacion.idDatosFacturacion = clientedatosfacturacion.idDatosFacturacion
                    AND datosfacturacion.privado = 'NO'
                    WHERE clientedatosfacturacion.idcliente <> ".$idCliente."
                    AND clientedatosfacturacion.iddatosfacturacion not in (select iddatosfacturacion from clientedatosfacturacion where idcliente = ".$idCliente.") " ;
        }

        if ($obtenerDatosPropios)
        {
            $query = "
                    SELECT clientedatosfacturacion.idCliente,     
                            clientedatosfacturacion.idClienteDatosFacturacion,           
                            datosfacturacion.idDatosFacturacion,
                            datosfacturacion.rfc,
                            datosfacturacion.email,
                            datosfacturacion.razonSocial,
                            datosfacturacion.domicilio,
                            datosfacturacion.numero,
                            datosfacturacion.colonia,
                            datosfacturacion.ciudad,
                            datosfacturacion.codigoPostal,
                            datosfacturacion.idUsoCfdi,
                            datosfacturacion.privado                            
                    FROM clientedatosfacturacion
                    INNER JOIN datosfacturacion
                    ON datosfacturacion.idDatosFacturacion = clientedatosfacturacion.idDatosFacturacion
                    WHERE clientedatosfacturacion.idCliente = " . $idCliente;
        }
        else
        {
            $query = "
                    SELECT clientedatosfacturacion.idCliente,
                            clientedatosfacturacion.idClienteDatosFacturacion,           
                            datosfacturacion.idDatosFacturacion,
                            datosfacturacion.rfc,
                            datosfacturacion.email,
                            datosfacturacion.razonSocial,
                            datosfacturacion.domicilio,
                            datosfacturacion.numero,
                            datosfacturacion.colonia,
                            datosfacturacion.ciudad,
                            datosfacturacion.codigoPostal,
                            datosfacturacion.idUsoCfdi,
                            datosfacturacion.privado
                    FROM clientedatosfacturacion 
                    INNER JOIN datosfacturacion
                    ON datosfacturacion.idDatosFacturacion = clientedatosfacturacion.idDatosFacturacion
                    AND datosfacturacion.privado = 'NO'
                    WHERE clientedatosfacturacion.idcliente <> ".$idCliente."
                    AND clientedatosfacturacion.iddatosfacturacion not in (select iddatosfacturacion from clientedatosfacturacion where idcliente = ".$idCliente.") " ;
        }

        $datosfacturacion = new ModeloDatosfacturacion();
        $cliente = new ModeloCliente();

        $cliente->setIdCliente($idCliente);

        $lst = $datosfacturacion->getDataSet($query);
        
        $this->addResponse("error", false);  
        $this->addResponse("creditoCliente", $cliente->getCredito());          
        $this->addResponse("capacidadPagoCliente", $cliente->getCapacidadPago()); 
        $this->addResponse("sumaCreditoCliente", $cliente->getSumacreditorfc());          
        $this->addResponse("sumaCapacidadPagoCliente", $cliente->getSumacapacidadpagorfc()); 
        $this->addResponse("list", $lst);          
    }

    public function getDireccionesPage(){
        $idCliente = $_GET["idCliente"];
        $page = $_GET["page"];
        $pageSize = $_GET["pageSize"];
        $filtro = $_GET["filtro"];

        $obtenerDatosPropios = true;

        if (isset($_GET["deotros"]))
        {
            $obtenerDatosPropios = false;
        }

        if ($obtenerDatosPropios)
        {
            $query = "
                    SELECT COUNT(0) total                            
                    FROM clientedatosfacturacion
                    INNER JOIN datosfacturacion
                    ON datosfacturacion.idDatosFacturacion = clientedatosfacturacion.idDatosFacturacion
                    WHERE clientedatosfacturacion.idCliente = " . $idCliente ." 
                    " . ($filtro != "" ? " AND CONCAT(datosfacturacion.rfc, datosfacturacion.razonSocial, datosfacturacion.email) LIKE '%".$filtro."%'" : "");
        }
        else
        {
            $query = "
                    SELECT COUNT(0) total                            
                    FROM clientedatosfacturacion 
                    INNER JOIN datosfacturacion
                    ON datosfacturacion.idDatosFacturacion = clientedatosfacturacion.idDatosFacturacion
                    AND datosfacturacion.privado = 'NO'
                    WHERE clientedatosfacturacion.idcliente <> ".$idCliente.
                    ($filtro != "" ? " AND CONCAT(datosfacturacion.rfc, datosfacturacion.razonSocial, datosfacturacion.email) LIKE '%".$filtro."%'" : "") ."
                    AND clientedatosfacturacion.iddatosfacturacion not in (select iddatosfacturacion from clientedatosfacturacion where idcliente = ".$idCliente.") " ;
        }

        $datosfacturacion = new ModeloDatosfacturacion();

        $rs = $datosfacturacion->getDataSet($query)[0];

        $totalReg =$rs["total"];


        if ($obtenerDatosPropios)
        {
            $query = "
                    SELECT clientedatosfacturacion.idCliente,     
                            clientedatosfacturacion.idClienteDatosFacturacion,           
                            datosfacturacion.idDatosFacturacion,
                            datosfacturacion.rfc,
                            datosfacturacion.email,
                            datosfacturacion.razonSocial,
                            datosfacturacion.domicilio,
                            datosfacturacion.numero,
                            datosfacturacion.colonia,
                            datosfacturacion.ciudad,
                            datosfacturacion.codigoPostal,
                            datosfacturacion.idUsoCfdi,
                            regimenfiscal.codigo rgcodigo,
                            regimenfiscal.descripcion regimenfiscal,
                            datosfacturacion.privado                            
                    FROM clientedatosfacturacion
                    INNER JOIN datosfacturacion
                    ON datosfacturacion.idDatosFacturacion = clientedatosfacturacion.idDatosFacturacion
                    INNER JOIN regimenfiscal 
                    ON regimenfiscal.idRegimenFiscal = datosfacturacion.idRegimenFiscal
                    WHERE clientedatosfacturacion.idCliente = " . $idCliente . 
                    ($filtro != "" ? " AND CONCAT(datosfacturacion.rfc, datosfacturacion.razonSocial, datosfacturacion.email) LIKE '%".$filtro."%'" : "") ."
                    LIMIT ".$pageSize."
                    OFFSET ".($page * $pageSize);
        }
        else
        {
            $query = "
                    SELECT clientedatosfacturacion.idCliente,
                            clientedatosfacturacion.idClienteDatosFacturacion,           
                            datosfacturacion.idDatosFacturacion,
                            datosfacturacion.rfc,
                            datosfacturacion.email,
                            datosfacturacion.razonSocial,
                            datosfacturacion.domicilio,
                            datosfacturacion.numero,
                            datosfacturacion.colonia,
                            datosfacturacion.ciudad,
                            datosfacturacion.codigoPostal,
                            datosfacturacion.idUsoCfdi,
                            regimenfiscal.codigo rgcodigo,
                            regimenfiscal.descripcion regimenfiscal,
                            datosfacturacion.privado
                    FROM clientedatosfacturacion 
                    INNER JOIN datosfacturacion
                    ON datosfacturacion.idDatosFacturacion = clientedatosfacturacion.idDatosFacturacion
                    AND datosfacturacion.privado = 'NO'
                    INNER JOIN regimenfiscal 
                    ON regimenfiscal.idRegimenFiscal = datosfacturacion.idRegimenFiscal
                    WHERE clientedatosfacturacion.idcliente <> ".$idCliente. 
                    ($filtro != "" ? " AND CONCAT(datosfacturacion.rfc, datosfacturacion.razonSocial, datosfacturacion.email) LIKE '%".$filtro."%'" : "")."
                    AND clientedatosfacturacion.iddatosfacturacion not in (select iddatosfacturacion from clientedatosfacturacion where idcliente = ".$idCliente.") 
                    LIMIT ".$pageSize."
                    OFFSET ".($page * $pageSize);
        }

        
        $lst = $datosfacturacion->getDataSet($query);
        
        $this->addResponse("error", false);  
        $this->addResponse("totalregs", $totalReg);  
        $this->addResponse("list", $lst);          
    }

    public function save(){
        $idCliente = $_POST["idCliente"];
        $idDatosFacturacion = $_POST["idDatosFacturacion"];
        $rfc = $_POST["rfc"];
        $email = $_POST["email"];
        $razonSocial = $_POST["razonSocial"];
        $domicilio = $_POST["domicilio"];
        $numero = $_POST["numero"];
        $colonia = $_POST["colonia"];
        $ciudad = $_POST["ciudad"];
        $codigoPostal = $_POST["codigoPostal"];
        $idUsoCfdi =$_POST["idUsoCfdi"];
        $idRegimenFiscal =$_POST["idRegimenFiscal"];
        
        $credito = $_POST["credito"];
        $capacidadPago = $_POST["capacidadPago"];
        $privado = $_POST["privado"];

        $saveClienteDatosFacturacion = $idDatosFacturacion == 0 ? true : false;
        $datosfacturacion = new ModeloDatosfacturacion();

        if ($idDatosFacturacion > 0 )
        {
            $datosfacturacion->setIdDatosFacturacion($idDatosFacturacion);            
        }
        else
        {
            $datosfacturacion->setDateAndUser("insert", $this->idUsuario);
        }

        $datosfacturacion->setDateAndUser("update", $this->idUsuario);
        $datosfacturacion->setRfc($rfc);
        $datosfacturacion->setRazonSocial($razonSocial);
        $datosfacturacion->setEmail($email);
        $datosfacturacion->setDomicilio($domicilio);
        $datosfacturacion->setNumero($numero);
        $datosfacturacion->setColonia($colonia);
        $datosfacturacion->setCiudad($ciudad);
        $datosfacturacion->setCodigopostal($codigoPostal);
        $datosfacturacion->setIdUsoCfdi($idUsoCfdi);
        $datosfacturacion->setIdRegimenFiscal($idRegimenFiscal);
        $datosfacturacion->setCredito($credito);
        $datosfacturacion->setCapacidadPago($capacidadPago);
        $datosfacturacion->setPrivado($privado);

        $continuar = true;

        if ($datosfacturacion->existeField("rfc", $rfc, $datosfacturacion->getIdDatosFacturacion()))
        {
            $this->addResponse("error", true);
            $this->addResponse("msg", "El RFC que desea almacenar ya existe. No puede haber duplicados");
            $continuar = false;
        }

        if ($datosfacturacion->existeField("email", $email, $datosfacturacion->getIdDatosFacturacion()))
        {
            $this->addResponse("error", true);
            $this->addResponse("msg", "El Email que desea almacenar ya existe. No puede haber duplicados");
            $continuar = false;
        }


        if ($continuar)
        {

            $datosfacturacion->Guardar();

            if (!$datosfacturacion->getError())
            {
                $cliente = new ModeloCliente ();

                // $cliente->updateMontoCreditoUsingDatosFacturacion($idCliente);
                
                if ($saveClienteDatosFacturacion)
                {
                    $clienteDatosFacturacion = new ModeloClientedatosfacturacion();
                    $clienteDatosFacturacion->setIdCliente($idCliente);
                    $clienteDatosFacturacion->setIdDatosFacturacion($datosfacturacion->getIdDatosFacturacion());
                    $clienteDatosFacturacion->setDateAndUser("insert", $this->idUsuario);
                    $clienteDatosFacturacion->setDateAndUser("update", $this->idUsuario);

                    $clienteDatosFacturacion->Guardar();

                    if (!$clienteDatosFacturacion->getError())
                    {
                        $this->addResponse("error", false);
                        $this->addResponse("idDatosFacturacion", $datosfacturacion->getIdDatosFacturacion());
                        $this->addResponse("idClienteDatosFacturacion", $clienteDatosFacturacion->getIdClienteDatosFacturacion());
                        
                    }    
                    else
                    {
                        $this->addResponse("error", true);
                        $this->addResponse("msg", "Error al insertar relacion cliente-datosfacturacion");
                        
                    }
                }
                else
                {
                    $this->addResponse("error", false);
                    $this->addResponse("idDatosFacturacion", $datosfacturacion->getIdDatosFacturacion());
                        $this->addResponse("idClienteDatosFacturacion", 0);

                }
            }
            else
            {   
                $this->addResponse("error", true);
                $this->addResponse("msg", "Error al insertar datosfacturacion");
            }
        }
    }
}

$api = new APIDatosFacturacion();
$api->run();