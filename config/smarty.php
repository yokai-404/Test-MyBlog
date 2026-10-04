<?php

declare(strict_types=1);

use Smarty\Smarty;

require_once __DIR__ . '/../vendor/autoload.php';

$smarty = new Smarty();

$smarty->setTemplateDir(__DIR__ . '/../templates');
$smarty->setCompileDir(__DIR__ . '/../storage/smarty/compile');
$smarty->setCacheDir(__DIR__ . '/../storage/smarty/cache');
$smarty->setConfigDir(__DIR__ . '/../storage/smarty/config');

return $smarty;