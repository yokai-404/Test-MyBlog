<?php

declare(strict_types=1);

$smarty = require_once __DIR__ . '/../config/smarty.php';

$smarty->assign('title', 'My Blog');
$smarty->assign('message', 'Smarty работает!');

$smarty->display('pages/home.tpl');