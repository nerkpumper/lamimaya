<?php
/**
 * Página de prueba para diagnosticar cargarProductoIndividual
 * Uso: /lamimaya/html/test?codigo=LRN-100+RPP264NGALVAG33
 *       /lamimaya/html/test?idProducto=436
 */

require_once FOLDER_MODEL . "model.viewproductos.inc.php";

$idProducto = isset($_GET['idProducto']) ? intval($_GET['idProducto']) : 0;
$codigo = isset($_GET['codigo']) ? $_GET['codigo'] : '';

$output = "";
$errors = [];

// 1. Ejecutar la consulta SQL directamente
$productos = new ModeloViewproductos();

if ($codigo != "")
{
    $productos->getViewProductoByCodigo($codigo);
    $output .= "<h3>Búsqueda por código: " . htmlspecialchars($codigo) . "</h3>";
}
else
{
    $productos->getViewProductoByCodigo("", $idProducto);
    $output .= "<h3>Búsqueda por idProducto: " . $idProducto . "</h3>";
}

// 2. Mostrar resultados
$output .= "<h4>Resultados (" . count($productos->lstProductos) . " producto(s) encontrado(s)):</h4>";

if (count($productos->lstProductos) > 0)
{
    $output .= "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse:collapse;width:100%;'>";
    $output .= "<tr style='background:#337ab7;color:white;'>
                    <th>#</th>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Precio1</th>
                    <th>Tipo Precio</th>
                    <th>Estado</th>
                    <th>Encontrado</th>
                  </tr>";
    
    foreach ($productos->lstProductos as $idx => $prod)
    {
        $style = ($idx % 2 == 0) ? 'background:#f9f9f9;' : 'background:white;';
        $output .= "<tr style='" . $style . "'>";
        $output .= "<td>" . ($idx + 1) . "</td>";
        $output .= "<td>" . $prod->getIdProducto() . "</td>";
        $output .= "<td>" . htmlspecialchars($prod->getCodigo()) . "</td>";
        $output .= "<td>" . htmlspecialchars($prod->getDescauto()) . "</td>";
        $output .= "<td>" . $prod->getPrecio1() . "</td>";
        $output .= "<td>" . $prod->getTipoPrecio() . "</td>";
        $output .= "<td>" . $prod->getEstado() . "</td>";
        $output .= "<td style='color:green;'>✓ SÍ</td>";
        $output .= "</tr>";
    }
    $output .= "</table>";
}

// 2b. Mostrar todos los valores de los productos
if (count($productos->lstProductos) > 0)
{
    $output .= "<h4>Valores completos (formato app.productos.push):</h4>";
    $output .= "<pre style='background:#f5f5f5;padding:10px;border:1px solid #ccc;overflow:auto;'>";
    
    $errores = array();
    
    foreach ($productos->lstProductos as $i => $prod)
    {
        $output .= "<strong>Producto " . ($i + 1) . ":</strong>\n";
        $output .= "app.productos.push({\n";
        
        // Función helper para obtener valor o registrar error
        $getSafe = function($method, $fieldName) use ($prod, &$errores, $i) {
            if (method_exists($prod, $method))
            {
                try
                {
                    $val = $prod->$method();
                    return $val;
                }
                catch (Exception $e)
                {
                    $errores[] = "Producto $i: $fieldName -> ERROR: " . $e->getMessage();
                    return "ERROR";
                }
            }
            else
            {
                $errores[] = "Producto $i: $fieldName -> MÉTODO NO EXISTE: $method()";
                return "NO_EXISTE";
            }
        };
        
        $descAuto = $getSafe('getDescauto', 'descauto');
        $codigoProd = $getSafe('getCodigo', 'codigo');
        $descRollo = $getSafe('getRolloDescripcion', 'rolloDescripcion');
        
        $output .= "    idProducto: '" . $getSafe('getIdProducto', 'idProducto') . "',\n";
        $output .= "    codigo: '" . $codigoProd . "',\n";
        $output .= "    isMoldura: false,\n";
        $output .= "    longitud: '" . $getSafe('getLongitud', 'longitud') . "',\n";
        $output .= "    mlpieza: " . $getSafe('getMlpieza', 'mlpieza') . ",\n";
        $output .= "    idTipoProducto: '" . $getSafe('getIdTipoProducto', 'idTipoProducto') . "',\n";
        $output .= "    tipoProducto: '" . $getSafe('getTipoProducto', 'tipoProducto') . "',\n";
        $output .= "    shortTipoProducto: '" . $getSafe('getShortTipoProducto', 'shortTipoProducto') . "',\n";
        $output .= "    idAplicacion: '" . $getSafe('getIdAplicacion', 'idAplicacion') . "',\n";
        $output .= "    aplicacion: '" . $getSafe('getAplicacion', 'aplicacion') . "',\n";
        $output .= "    idMaterial: '" . $getSafe('getIdMaterial', 'idMaterial') . "',\n";
        $output .= "    material: '" . $getSafe('getMaterial', 'material') . "',\n";
        $output .= "    curva: '',\n";
        $output .= "    idRollo: '" . $getSafe('getIdRollo', 'idRollo') . "',\n";
        $output .= "    rolloCodigo: '" . $getSafe('getRolloCodigo', 'rolloCodigo') . "',\n";
        $output .= "    rolloIdMaterial: '" . $getSafe('getRolloIdMaterial', 'rolloIdMaterial') . "',\n";
        $output .= "    rolloMaterial: '" . $getSafe('getRolloMaterial', 'rolloMaterial') . "',\n";
        $output .= "    rolloShortMaterial: '" . $getSafe('getRolloShortMaterial', 'rolloShortMaterial') . "',\n";
        $output .= "    rolloIdProveedor: '" . $getSafe('getRolloIdProveedor', 'rolloIdProveedor') . "',\n";
        $output .= "    rolloProveedor: '" . $getSafe('getRolloProveedor', 'rolloProveedor') . "',\n";
        $output .= "    rolloShortProveedor: '" . $getSafe('getRolloShortProveedor', 'rolloShortProveedor') . "',\n";
        $output .= "    rolloCalibre: '" . $getSafe('getRolloCalibre', 'rolloCalibre') . "',\n";
        $output .= "    rolloPies: '" . $getSafe('getRolloPies', 'rolloPies') . "',\n";
        $output .= "    rolloPesokiloml: " . $getSafe('getRolloPesokiloml', 'rolloPesokiloml') . ",\n";
        $output .= "    rolloDescripcion: '" . $descRollo . "',\n";
        $output .= "    idUnidad: '" . $getSafe('getIdUnidad', 'idUnidad') . "',\n";
        $output .= "    unidad: '" . $getSafe('getUnidad', 'unidad') . "',\n";
        $output .= "    shortUnidad: '" . $getSafe('getShortUnidad', 'shortUnidad') . "',\n";
        $output .= "    calibre: '" . $getSafe('getCalibre', 'calibre') . "',\n";
        $output .= "    descripcion: '" . $getSafe('getDescripcion', 'descripcion') . "',\n";
        $output .= "    existencia: '" . $getSafe('getExistencia', 'existencia') . "',\n";
        $output .= "    tipoPrecioComision: 'PRECIO',\n";
        $output .= "    tipoPrecio: '" . $getSafe('getTipoPrecio', 'tipoPrecio') . "',\n";
        $output .= "    isRango: '" . $getSafe('getIsRango', 'isRango') . "',\n";
        $output .= "    tipoRango: '" . $getSafe('getTipoRango', 'tipoRango') . "',\n";
        $output .= "    isRollo: '" . $getSafe('getIsRollo', 'isRollo') . "',\n";
        $output .= "    precio1: '" . $getSafe('getPrecio1', 'precio1') . "',\n";
        $output .= "    precio2: '" . $getSafe('getPrecio2', 'precio2') . "',\n";
        $output .= "    precio3: '" . $getSafe('getPrecio3', 'precio3') . "',\n";
        $output .= "    precio4: '" . $getSafe('getPrecio4', 'precio4') . "',\n";
        $output .= "    preciomendez: '" . $getSafe('getPreciomendez', 'preciomendez') . "',\n";
        $output .= "    estado: '" . $getSafe('getEstado', 'estado') . "',\n";
        $output .= "    existenciaEstimada: '" . $getSafe('getExistenciaToCero', 'existenciaEstimada') . "',\n";
        $output .= "    fullDescripcion: '" . $descAuto . "',\n";
        $output .= "    fullDescripcionCode: '" . $codigoProd . " - " . $descAuto . "',\n";
        $output .= "    cantidad: 1,\n";
        $output .= "    lblUnidad: '',\n";
        $output .= "    cantUnidad: 1,\n";
        $output .= "    cantUnidadReal: 1,\n";
        $output .= "    dobleces: '0',\n";
        $output .= "    precioRenglon: '0',\n";
        $output .= "    rangoRenglon: '1',\n";
        $output .= "    totalRenglon: '0',\n";
        $output .= "    desarrolloI: '0',\n";
        $output .= "    desarrolloT: '0',\n";
        $output .= "    dobleces: '0',\n";
        $output .= "    debug: '',\n";
        $output .= "    kl: 0,\n";
        $output .= "    productoCantidadDisponible: true,\n";
        $output .= "    molPrecioLamina: 0,\n";
        $output .= "    molMoldurasXLamina: 1,\n";
        $output .= "    molMoldurasXLaminaTodos: 1,\n";
        $output .= "    molLaminasCobrar: 1,\n";
        $output .= "    molLaminasATomar: 1,\n";
        $output .= "    molCorte: 0,\n";
        $output .= "    molDobles: 0,\n";
        $output .= "    molIsScrap: false,\n";
        $output .= "    molTotalCMScrap: 0,\n";
        $output .= "    molLongitudinal: 'L',\n";
        $output .= "    sugerirStock: [],\n";
        $output .= "    inventarioSucursal: [],\n";
        $output .= "    idPedidoDetalle: 0\n";
        $output .= "});\n\n";
    }
    
    $output .= "</pre>";
    
    // Mostrar errores si los hay
    if (count($errores) > 0)
    {
        $output .= "<h4 style='color:red;'>⚠ Valores que no se pudieron leer:</h4>";
        $output .= "<pre style='background:#f2dede;padding:10px;border:1px solid #ebccd1;'>";
        foreach ($errores as $err)
        {
            $output .= htmlspecialchars($err) . "\n";
        }
        $output .= "</pre>";
    }
    else
    {
        $output .= "<h4 style='color:green;'>✓ Todos los valores se leyeron correctamente</h4>";
    }
}
else
{
    $output .= "<div style='background:#f2dede;padding:15px;border:1px solid #ebccd1;border-radius:4px;'>";
    $output .= "<strong>✗ NO SE ENCONTRÓ EL PRODUCTO</strong><br>";
    $output .= "Verifique que:<br>";
    $output .= "1. El producto exista en la vista `viewproductos`<br>";
    $output .= "2. El estado sea 'ACTIVO'<br>";
    $output .= "3. El precio1 sea > 0 si tipoPrecio = 'G'<br>";
    $output .= "</div>";
}

// 4. Mostrar información de depuración de la conexión
$output .= "<h4>Información de depuración:</h4>";
$output .= "<pre style='background:#f5f5f5;padding:10px;border:1px solid #ccc;'>";
$output .= "Total productos en lstProductos: " . count($productos->lstProductos) . "\n";
$output .= "Error de la consulta: " . ($productos->getError() ? 'SÍ' : 'NO') . "\n";
$output .= "Mensaje de error: " . htmlspecialchars($productos->getStrError()) . "\n";
$output .= "</pre>";

// 5. Verificar la tabla directamente
$output .= "<h4>Verificación directa en BD:</h4>";

if ($codigo != "")
{
    $sqlCheck = "SELECT idProducto, codigo, descauto, estado, precio1, tipoPrecio 
                  FROM viewproductos 
                  WHERE codigo = '" . mysqli_real_escape_string($productos->dbLink, $codigo) . "' 
                  OR descauto LIKE '%" . mysqli_real_escape_string($productos->dbLink, $codigo) . "%' 
                  LIMIT 1";
}
else
{
    $sqlCheck = "SELECT idProducto, codigo, descauto, estado, precio1, tipoPrecio 
                  FROM viewproductos 
                  WHERE idProducto = " . $idProducto . " 
                  LIMIT 1";
}

$resultCheck = mysqli_query($productos->dbLink, $sqlCheck);
if ($resultCheck)
{
    $output .= "<p>Consulta SQL directa: <code>" . htmlspecialchars($sqlCheck) . "</code></p>";
    if (mysqli_num_rows($resultCheck) > 0)
    {
        $row = mysqli_fetch_assoc($resultCheck);
        $output .= "<div style='background:#dff0d8;padding:15px;border:1px solid #d0e9c6;border-radius:4px;'>";
        $output .= "<strong>✓ El producto SÍ existe en la base de datos:</strong><br>";
        $output .= "ID: " . $row['idProducto'] . "<br>";
        $output .= "Código: " . htmlspecialchars($row['codigo']) . "<br>";
        $output .= "Descripción: " . htmlspecialchars($row['descauto']) . "<br>";
        $output .= "Estado: " . $row['estado'] . "<br>";
        $output .= "Precio1: " . $row['precio1'] . "<br>";
        $output .= "Tipo Precio: " . $row['tipoPrecio'] . "<br>";
        $output .= "</div>";
    }
    else
    {
        $output .= "<div style='background:#f2dede;padding:15px;border:1px solid #ebccd1;border-radius:4px;'>";
        $output .= "<strong>✗ El producto NO existe en la base de datos</strong>";
        $output .= "</div>";
    }
}
else
{
    $output .= "<div style='background:#f2dede;padding:15px;border:1px solid #ebccd1;border-radius:4px;'>";
    $output .= "<strong>Error en la consulta:</strong> " . mysqli_error($productos->dbLink);
    $output .= "</div>";
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Test - cargarProductoIndividual</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h3 { color: #337ab7; border-bottom: 2px solid #337ab7; padding-bottom: 5px; }
        h4 { color: #5a5a5a; margin-top: 20px; }
        form { background: #f5f5f5; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        input[type=text], input[type=number] { padding: 8px; width: 300px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 8px 15px; background: #337ab7; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #286090; }
        code { background: #e7e7e7; padding: 2px 5px; border-radius: 3px; }
    </style>
</head>
<body>
    <h2>🔍 Test de Diagnóstico - cargarProductoIndividual</h2>
    
    <form method="GET">
        <div style='margin-bottom:10px;'>
            <label>ID Producto: </label><br>
            <input type="number" name="idProducto" value="<?php echo $idProducto; ?>" placeholder="Ej: 436">
        </div>
        <div style='margin-bottom:10px;'>
            <label>Código: </label><br>
            <input type="text" name="codigo" value="<?php echo htmlspecialchars($codigo); ?>" placeholder="Ej: LRN-100 RPP264NGALVAG33">
        </div>
        <button type="submit">🔍 Buscar Producto</button>
    </form>
    
    <hr>
    
    <?php echo $output; ?>
    
    <hr>
    <div style='background:#d9edf6;padding:15px;border:1px solid #bce8f1;border-radius:4px;'>
        <strong>💡 Instrucciones:</strong><br>
        1. Ingrese un <strong>idProducto</strong> (ej: 436) o un <strong>código</strong> (ej: LRN-100 RPP264NGALVAG33)<br>
        2. Presione "Buscar Producto"<br>
        3. Revise la salida: SQL ejecutado, resultados y verificación en BD<br>
        4. Si el producto no aparece en resultados pero SÍ en "Verificación directa", el problema está en el código PHP (filtros, errores silenciados)
    </div>
</body>
</html>
