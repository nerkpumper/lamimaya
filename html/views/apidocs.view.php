<?php
// require_once 'model/clsPermisos.inc.php';
// require_once 'model/extend/model.usuario.inc.php';

// if (!Permisos::userIsThisRol(Permisos::$rol_ROOT)) {
//     echo "No tiene permisos para acceder a esta pagina";
//     exit();
// }

$apiFiles = glob("api/*.api.php"); 

$apis = [];
foreach ($apiFiles as $file) {
    $name = basename($file, '.api.php');
    $content = file_get_contents($file);
    
    preg_match('/class\s+(\w+)\s+extends\s+APIBase/', $content, $matches);
    $className = $matches[1] ?? $name;
    
    preg_match_all('/public\s+function\s+(\w+)\s*\(/', $content, $methods);
    
    // Extraer parametros de cada metodo
    $methodParams = [];
    foreach ($methods[1] ?? [] as $method) {
        $params = [];
        // Buscar $_GET["parametro"] en el metodo
        preg_match_all('/\$_GET\["(\w+)"\]/', $content, $allParams);
        if (!empty($allParams[1])) {
            $params = array_unique($allParams[1]);
        }
        $methodParams[$method] = $params;
    }
    
    $apis[] = [
        'name' => $name,
        'class' => $className,
        'file' => $file,
        'methods' => $methods[1] ?? [],
        'methodParams' => $methodParams
    ];
}

sort($apis);
$idUsuarioActual = ModeloUsuario::getObjSession()->getIdUsuario();
$nombreUsuario = ModeloUsuario::getObjSession()->getNombre();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - Lamimaya</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; 
            background: #f5f5f5; 
            color: #333;
            min-height: 100vh;
        }
        
        .header { 
            background: #fff; 
            padding: 20px 30px; 
            border-bottom: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .header h1 { 
            color: #333; 
            font-size: 24px; 
            font-weight: 600;
        }
        .header p { 
            color: #666; 
            margin-top: 5px;
        }
        
        .container { max-width: 1100px; margin: 0 auto; padding: 20px; }
        
        .api-card { 
            background: #fff; 
            border-radius: 8px; 
            margin-bottom: 15px; 
            overflow: hidden; 
            border: 1px solid #e0e0e0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }
        .api-card-header { 
            background: #fafafa; 
            padding: 15px 20px; 
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.2s;
            border-bottom: 1px solid #e0e0e0;
        }
        .api-card-header:hover { background: #f0f0f0; }
        .api-card-header h3 { color: #333; font-size: 16px; font-weight: 600; }
        .api-card-header .badge { background: #6c757d; color: #fff; padding: 2px 8px; border-radius: 10px; font-size: 11px; }
        
        .api-card-body { display: none; padding: 20px; }
        .api-card-body.active { display: block; }
        
        .method-item { background: #fafafa; border-radius: 6px; margin-bottom: 15px; padding: 15px; border: 1px solid #e0e0e0; }
        .method-name { color: #007bff; font-size: 15px; font-weight: 600; margin-bottom: 10px; }
        
        .url-example { background: #f1f3f4; padding: 10px 14px; border-radius: 4px; font-family: monospace; font-size: 12px; color: #555; margin-bottom: 15px; border: 1px solid #e0e0e0; }
        
        .json-input { 
            width: 100%; 
            min-height: 80px; 
            background: #fff; 
            border: 1px solid #ced4da; 
            color: #333; 
            padding: 12px; 
            border-radius: 4px;
            font-family: 'Monaco', 'Menlo', monospace;
            font-size: 13px;
            resize: vertical;
        }
        .json-input:focus { outline: none; border-color: #007bff; box-shadow: 0 0 0 3px rgba(0,123,255,0.1); }
        
        .btn-test { background: #007bff; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: 500; font-size: 13px; transition: all 0.2s; }
        .btn-test:hover { background: #0056b3; transform: translateY(-1px); }
        
        .response-area { background: #f8f9fa; border-radius: 4px; padding: 12px; margin-top: 15px; max-height: 350px; overflow: auto; font-family: 'Monaco', monospace; font-size: 12px; white-space: pre-wrap; display: none; border: 1px solid #dee2e6; }
        .response-area.show { display: block; }
        .response-success { border-left: 4px solid #28a745; }
        .response-error { border-left: 4px solid #dc3545; }
        
        .search-box { background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #e0e0e0; }
        .search-input { width: 100%; padding: 12px 15px; background: #fff; border: 1px solid #ced4da; color: #333; border-radius: 4px; font-size: 14px; }
        .search-input:focus { outline: none; border-color: #007bff; box-shadow: 0 0 0 3px rgba(0,123,255,0.1); }
        
        .method-count { color: #666; font-size: 12px; margin-left: 10px; }
        .toggle-icon { transition: transform 0.2s; color: #666; }
        .toggle-icon.rotated { transform: rotate(180deg); }
        
        .loading { display: none; color: #007bff; margin-left: 8px; }
        .user-info { background: #e7f3ff; padding: 10px 15px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #b8daff; font-size: 13px; color: #004085; }
        .user-info i { margin-right: 5px; }
        .info-badge { display: inline-block; background: #17a2b8; color: #fff; padding: 2px 8px; border-radius: 3px; font-size: 11px; margin-left: 8px; }
        
        .param-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 10px; }
        .param-tag { background: #e9ecef; color: #495057; padding: 4px 10px; border-radius: 15px; font-size: 12px; border: 1px solid #ced4da; cursor: pointer; transition: all 0.2s; }
        .param-tag:hover { background: #007bff; color: #fff; border-color: #007bff; }
        .param-tag.added { background: #28a745; color: #fff; border-color: #28a745; }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-plug"></i> API Documentation</h1>
        <p>Lamimaya REST API Endpoints</p>
    </div>
    
    <div class="container">
        <div class="user-info">
            <i class="fas fa-user"></i> Usuario: <strong><?php echo $nombreUsuario; ?></strong> 
            <span class="info-badge">ID: <?php echo $idUsuarioActual; ?></span>
        </div>
        
        <div class="search-box">
            <input type="text" class="search-input" id="searchInput" placeholder="Buscar API o metodo..." onkeyup="filterAPIs()">
        </div>
        
        <?php foreach ($apis as $api): ?>
        <div class="api-card" data-name="<?php echo strtolower($api['name']); ?>">
            <div class="api-card-header" onclick="toggleCard(this)">
                <h3>
                    <i class="fas fa-cube" style="color: #007bff;"></i> 
                    <?php echo htmlspecialchars($api['name']); ?>.api.php
                    <span class="method-count">(<?php echo count($api['methods']); ?> metodos)</span>
                </h3>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </div>
            <div class="api-card-body">
                <?php if (empty($api['methods'])): ?>
                    <p style="color: #666;">// No public methods found</p>
                <?php else: ?>
                    <?php foreach ($api['methods'] as $method): ?>
                    <?php 
                        $params = $api['methodParams'][$method] ?? [];
                        $defaultJson = json_encode(array_fill_keys($params, ""), JSON_PRETTY_PRINT);
                    ?>
                    <div class="method-item" data-method="<?php echo strtolower($method); ?>">
                        <div class="method-name">
                            <i class="fas fa-method"></i> 
                            method=<?php echo htmlspecialchars($method); ?>()
                        </div>
                        <div class="url-example">
                            <strong>Endpoint:</strong> <?php echo URL_BASE; ?>api/<?php echo $api['name']; ?>.api.php?method=<?php echo $method; ?>&idUsuario=<?php echo $idUsuarioActual; ?>&...
                        </div>
                        
                        <?php if (!empty($params)): ?>
                        <div class="param-tags">
                            <span style="color: #666; font-size: 12px; margin-right: 8px;">Params:</span>
                            <?php foreach ($params as $p): ?>
                            <span class="param-tag" onclick="addParam('<?php echo $method; ?>', '<?php echo $p; ?>', this)"><?php echo $p; ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        
                        <textarea class="json-input" id="json-<?php echo $api['name']; ?>-<?php echo $method; ?>" placeholder='{ "param1": "value1", "param2": "value2" }'><?php echo $defaultJson; ?></textarea>
                        
                        <button class="btn-test" onclick="testEndpoint('<?php echo $api['name']; ?>', '<?php echo $method; ?>', this)">
                            <i class="fas fa-play"></i> Try it out
                            <span class="loading"><i class="fas fa-spinner fa-spin"></i></span>
                        </button>
                        <div class="response-area"></div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <script>
        function toggleCard(header) {
            const body = header.nextElementSibling;
            const icon = header.querySelector('.toggle-icon');
            body.classList.toggle('active');
            icon.classList.toggle('rotated');
        }
        
        function filterAPIs() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('.api-card').forEach(card => {
                const name = card.getAttribute('data-name');
                const matches = name.includes(search);
                card.style.display = matches ? 'block' : 'none';
                
                if (matches) {
                    card.querySelectorAll('.method-item').forEach(item => {
                        const method = item.getAttribute('data-method');
                        item.style.display = method.includes(search) || search === '' ? 'block' : 'none';
                    });
                }
            });
        }
        
        function addParam(methodName, paramName, tag) {
            const textarea = tag.closest('.method-item').querySelector('textarea');
            try {
                let json = JSON.parse(textarea.value || '{}');
                if (!json[paramName]) {
                    json[paramName] = '';
                    textarea.value = JSON.stringify(json, null, 4);
                    tag.classList.add('added');
                }
            } catch(e) {
                textarea.value = '{"' + paramName + '": ""}';
                tag.classList.add('added');
            }
        }
        
        function testEndpoint(apiName, methodName, btn) {
            const methodItem = btn.closest('.method-item');
            const responseArea = methodItem.querySelector('.response-area');
            const loading = methodItem.querySelector('.loading');
            const textarea = methodItem.querySelector('textarea');
            const idUsuario = <?php echo $idUsuarioActual; ?>;
            
            let url = '<?php echo URL_BASE; ?>api/' + apiName + '.api.php?method=' + methodName;
            url += '&idUsuario=' + idUsuario;
            
            // Parse JSON input
            try {
                const jsonParams = JSON.parse(textarea.value || '{}');
                for (const [key, value] of Object.entries(jsonParams)) {
                    if (value && value.toString().trim() !== '') {
                        url += '&' + key + '=' + encodeURIComponent(value);
                    }
                }
            } catch(e) {
                // Si no es JSON valido, intentar como query string
                if (textarea.value.trim()) {
                    url += '&' + textarea.value.trim();
                }
            }
            
            loading.style.display = 'inline';
            btn.disabled = true;
            responseArea.classList.remove('show', 'response-success', 'response-error');
            responseArea.textContent = 'Loading...\nURL: ' + url;
            
            fetch(url)
                .then(response => response.text())
                .then(text => {
                    loading.style.display = 'none';
                    btn.disabled = false;
                    
                    try {
                        const json = JSON.parse(text);
                        responseArea.textContent = JSON.stringify(json, null, 2);
                        responseArea.classList.add('show');
                        responseArea.classList.add(json.error ? 'response-error' : 'response-success');
                    } catch (e) {
                        responseArea.textContent = 'Parse Error:\n' + text;
                        responseArea.classList.add('show', 'response-error');
                    }
                })
                .catch(error => {
                    loading.style.display = 'none';
                    btn.disabled = false;
                    responseArea.textContent = 'Error: ' + error.message;
                    responseArea.classList.add('show', 'response-error');
                });
        }
        
        // Open first card by default
        document.querySelector('.api-card-header').click();
    </script>
</body>
</html>
