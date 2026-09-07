<?php
$parentDir = dirname(__DIR__);
chdir($parentDir);

ob_start();
require $parentDir . '/index.php';
$html = ob_get_clean();

echo preg_replace('/<head([^>]*)>/i', '<head$1><base href="../">', $html, 1);
