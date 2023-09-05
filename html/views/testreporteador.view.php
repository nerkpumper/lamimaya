<?php

require_once LIB_REPORTEADOR;

$reporter = new clsReporteador();

$reporter->setParam("idremisionrollo", "377");
$reporter->setParam("mov", "ES");
$reporter->setParam("desde", "2017-12-30");
$reporter->setParam("hasta", "2018-01-10");

$reporter->prepare("rolloremisiones","movimientoremisionrollo");

if ($reporter->hayError())
{
	echo $reporter->reporteadorError();
	return;
}

// $reporter->printParametros();

echo $reporter->getQuery();

echo "<br><br>";



$reporter->executeQuery();

// $reporter->varDump($reporter->rs);

echo $reporter->getTable("tblReportito");