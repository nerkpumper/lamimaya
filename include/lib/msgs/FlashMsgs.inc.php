<?php


class FlashMsgs
{
	public static $arrMsgs = array();
	
	public static function addError($msg)
	{
		if (!isset(self::$arrMsgs["msgDanger"]))
			self::$arrMsgs["msgDanger"] = "";
		
		self::$arrMsgs["msgDanger"] .= "|" . $msg;		
	}
	
	public static function addSuccess($msg)
	{	
		if (!isset(self::$arrMsgs["msgSuccess"]))
			self::$arrMsgs["msgSuccess"] = "";
		
		self::$arrMsgs["msgSuccess"] .= "|" . $msg;
	}
	
	public static function addWarning($msg)
	{		
		if (!isset(self::$arrMsgs["msgWarning"]))
			self::$arrMsgs["msgWarning"] = "";
		
		self::$arrMsgs["msgWarning"] .= "|" . $msg;		
	}
	
	public static function addInfo($msg)
	{
		if (!isset(self::$arrMsgs["msgInfo"]))
			self::$arrMsgs["msgInfo"] = "";
		
		self::$arrMsgs["msgInfo"] .= "|" . $msg;		
	}
	
	public static function clear()
	{
 		if (isset(self::$arrMsgs["msgDanger"]))
 			self::$arrMsgs["msgDanger"] = "";
		
		//echo "<br><br>borrando success <br><br>";
		if (isset(self::$arrMsgs["msgSuccess"]))
			self::$arrMsgs["msgSuccess"] = "";
		
		//echo "<br><br>borrando warning <br><br>";			
		if (isset(self::$arrMsgs["msgWarning"]))
			self::$arrMsgs["msgWarning"] = "";		
		
		//echo "<br><br>borrando info <br><br>";
		if (isset(self::$arrMsgs["msgInfo"]))
			self::$arrMsgs["msgInfo"] = "";				
	}
	
	public static function createMsgs($arrMsg, $class)
	{
		$msgs = "";
		if (isset(self::$arrMsgs["msgSuccess"]) && self::$arrMsgs["msgSuccess"] != "")
		{
			//echo " Poniendo msgSuccess" ;
			$lst = explode("|", self::$arrMsgs["msgSuccess"]);
				
				
			foreach ($lst as $m)
			{
				if ($m != "")
					$msgs .= ($msgs != "" ? "</li><li>" : "<ul><li>") . $m;
			}
				
			if ($msgs != "")
			{
				$msgs = '<div class="alert alert-' . $class . ' role="alert">' . $msgs . '</li></ul></div>';
			}
				
		}
		
		return $msgs;
	}
	
	public static function setMsgsToXAjax(xajaxResponse $objAjax)
	{
		$result = self::getMsgs();
		if ($result != "")
		{
			$objAjax->mostrarMsgs($result);
		}
		
	}
	
	public static function getMsgs()
	{
		//echo '<div class="alert alert-success" role="alert">' . $GLOBALS["msgSuccess"] . '</div>';
		//echo "<br><br>antes de poner los mensajes <br><br>";
		//echo "msgs -> ";
		$result = "";
		
		if (isset(self::$arrMsgs["msgSuccess"]) && self::$arrMsgs["msgSuccess"] != "")
		{
			$result .= self::createMsgs(self::$arrMsgs["msgSuccess"], "success");
		}
		
		if (isset(self::$arrMsgs["msgInfo"]) && self::$arrMsgs["msgInfo"] != "")
		{
			$result .= self::createMsgs(self::$arrMsgs["msgSuccess"], "info");
		}
		
		if (isset(self::$arrMsgs["msgWarning"]) && self::$arrMsgs["msgWarning"] != "")
		{
			$result .= self::createMsgs(self::$arrMsgs["msgSuccess"], "warning");
		}
		
		if (isset(self::$arrMsgs["msgDanger"]) && self::$arrMsgs["msgDanger"] != "")
		{
			$result .= self::createMsgs(self::$arrMsgs["msgSuccess"], "danger");
		}
		
		
					
		//echo "<br><br>aqui mandamos borrar<br><br>";
		self::clear();
		//echo "<br><br>ya regrese de borrar<br><br>";
		
		return $result;
	}
		
}