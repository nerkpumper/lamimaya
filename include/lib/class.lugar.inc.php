<?php
class CLugar
{
	var $primero;
	var $segundo;
	var $tercero;
	var $cuarto;
	public function setLugar($lugarActual)
	{
		$this->primero=substr($lugarActual,0,1);
		$this->segundo=substr($lugarActual,1,1);
		$this->tercero=substr($lugarActual,2,1);
		$this->cuarto=substr($lugarActual,3,1);
	}
	public function isPrimero($lugar)
	{
		return $this->primero==substr($lugar, 0,1);		
	}
	public function isSegundo($lugar)
	{
		if($this->isPrimero($lugar))
			return $this->segundo==substr($lugar, 1,1);
		return false;
	}
	public function isTercero($lugar)
	{
		if($this->isSegundo($lugar))
			return $this->tercero==substr($lugar, 2,1);
		return false;
	}
	public function isCuarto($lugar)
	{
		if($this->isTercero($lugar))
			return $this->cuarto==substr($lugar, 3,1);
		return false;
	}
}