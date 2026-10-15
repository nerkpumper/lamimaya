<?php

/**
 * Autoload PSR-4 para PhpSpreadsheet y sus dependencias (librerías embebidas,
 * sin Composer). Ubicación: include/lib/phpspreadsheet/
 *
 * Versiones incluidas:
 *   phpoffice/phpspreadsheet 5.10.0
 *   maennchen/zipstream-php  2.4.0
 *   composer/pcre            3.4.0
 *   markbaker/complex        3.0.2
 *   markbaker/matrix         3.0.1
 *   psr/simple-cache         3.0.0
 *   psr/http-message         1.1
 *   myclabs/php-enum         1.8.5
 */

if (PHP_VERSION_ID < 80200) {
	trigger_error('PhpSpreadsheet requiere PHP 8.2 o superior (versión actual: ' . PHP_VERSION . ')', E_USER_ERROR);
}

spl_autoload_register(static function (string $class): void {
	static $prefixes = [
		'PhpOffice\\PhpSpreadsheet\\' => __DIR__ . '/phpoffice/phpspreadsheet/src/PhpSpreadsheet/',
		'Psr\\SimpleCache\\' => __DIR__ . '/psr/simple-cache/src/',
		'Psr\\Http\\Message\\' => __DIR__ . '/psr/http-message/src/',
		'Composer\\Pcre\\' => __DIR__ . '/composer/pcre/src/',
		'Complex\\' => __DIR__ . '/markbaker/complex/classes/src/',
		'Matrix\\' => __DIR__ . '/markbaker/matrix/classes/src/',
		'ZipStream\\' => __DIR__ . '/maennchen/zipstream-php/src/',
		'MyCLabs\\Enum\\' => __DIR__ . '/myclabs/php-enum/src/',
	];

	foreach ($prefixes as $prefix => $dir) {
		if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
			continue;
		}
		$file = $dir . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
		if (is_file($file)) {
			require $file;
		}
		return;
	}
});
