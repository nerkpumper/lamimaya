<?php
// $_showPageHeading = false;

$titlePage = "Capturar Cotizaci&oacute;n / Pedido";
// $breadCum = "Ventas/Pedido/Nuevo";
$_lugar = LUGAR_VENTAS_NUEVOPEDIDO;

 $_addHead="
                <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>    

  		";

$_addScript='
 		
<script defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRxUzlluNFaKpmV_J91pZIBma14x3JQFI&callback=initMap">
    </script>
		 ';
	
?>

<div id="map"></div>
