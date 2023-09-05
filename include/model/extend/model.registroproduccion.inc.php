<?php

	require FOLDER_MODEL_BASE . "model.base.registroproduccion.inc.php";

	class ModeloRegistroproduccion extends ModeloBaseRegistroproduccion
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="ModeloBaseRegistroproduccion";

		var $__ss=array();
		var $__primaryKey="idRegistroProduccion";				
		var $__tableName="registroproduccion";
		var $__tableEdit="registroproduccionedit";
		var $__tableDelete="registroproducciondelete";				

		#------------------------------------------------------------------------------------------------------#
		#--------------------------------------------Inicializacion--------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		function __construct()
		{
			parent::__construct();
		}

		function __destruct()
		{
			
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Setter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		public function getRegistroProduccion($idRegistroProduccion)
		{
				$query = "select rp.idregistroproduccion, rm.norollo,  rp.idremisionrollo, rp.kilos, rp.kilosmaquilados, rp.totalml, rp.factor, rp.rendimiento, rp.terminado, rp.fecha_creacion,
						(rp.kilos - rp.kilosmaquilados) as kilosfaltantes,rp.espesor,rp.largoRollo,
		idregistroproducciondetalle, rpd.tipo, ifnull(pedido.idpedido, rpd.tipo) as nopedido , 
									  ifnull(concat(cliente.nombre, ' ', cliente.apellidos), if(rpd.tipo = 'STOCK', 'GALVAMEX', 'PYC')) as nombrecliente, 
									  rpd.partida, longitud, (rpd.partida * longitud) as totalml, totalkg, totalreal,
		rp.fecha_creacion, rp.id_usuario_creacion, IFNULL(creacion.nombre,'') as creacionNombre, IFNULL(creacion.apellidoPaterno,'') as creacionAPaterno, IFNULL(creacion.apellidoMaterno,'') as creacionAMaterno,
		rp.fecha_creacion, rp.id_usuario_termina, IFNULL(termina.nombre,'') as terminaNombre, IFNULL(termina.apellidoPaterno,'') as terminaAPaterno, IFNULL(termina.apellidoMaterno,'') as terminaAMaterno
		FROM registroproduccion as rp
		INNER JOIN remisionrollo as rm ON rm.idremisionrollo = rp.idremisionrollo
		inner join registroproducciondetalle as rpd on rpd.idregistroproduccion = rp.idregistroproduccion
		left join pedidodetalle on pedidodetalle.idpedidodetalle = rpd.idpedidodetalle
		left join pedido on pedido.idpedido = pedidodetalle.idpedido
		left join cliente on cliente.idcliente = pedido.idcliente 
		LEFT JOIN usuario as creacion
						   ON creacion.idUsuario = rp.id_usuario_creacion
						LEFT JOIN usuario as termina
						   ON termina.idUsuario = rp.id_usuario_termina
		WHERE rp.idregistroproduccion = ". $idRegistroProduccion."
		ORDER BY rpd.idregistroproducciondetalle; " ;
					
				$this->__rsDetalle = $this->getDataSet($query);
			}
			
			public function getRegitroProduccionDato($column)
			{
				$dato = "";
			
				if (count($this->__rsDetalle) > 0)
				{
					if (isset($this->__rsDetalle[0][$column]))
					{
						$dato = $this->__rsDetalle[0][$column];
					}
				}
			
				return $dato;
			}


		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		public function getFactorYRendimiento(&$factor, &$rendimiento)
		{
	// 		    SET NEW.factor = (NEW.kilos * 100) / NEW.kilosMaquilados;
	// 		    SET NEW.rendimiento = ((NEW.kilosMaquilados - NEW.kilos)*100) / NEW.kilosMaquilados;
			if ($this->kilosMaquilados > 0)
			 {
				return true;
				$factor = round($this->kilos * 100 / $this->kilosMaquilados, 2);
				$rendimiento = round(($this->kilosMaquilados - $this->kilos) * 100 / $this->kilosMaquilados,2);
			 }	

			}

		public function validarDatos()
		{
			return true;
		}


	}

