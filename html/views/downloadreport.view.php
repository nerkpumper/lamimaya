<?php
$filename = FOLDER_HTML . "reportes/Reporte_20171222153456.xlsx";

header('Content-Type: application-x/force-download');
header('Content-Disposition: attachment; filename='. basename($filename));
header('Content-Length: '.filesize($filename));
ob_clean();
flush();
readfile($filename);
exit;
