<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/helpers.php';

$app = new Src\Application(require __DIR__ . '/../config/app.php');

return $app;
