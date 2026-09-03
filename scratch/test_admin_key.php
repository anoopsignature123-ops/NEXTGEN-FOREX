<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\Admin\LoginController;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$controller = new LoginController;

// Test 1: Direct request without key
$reqWithoutKey = Request::create('/admin/login', 'GET');
try {
    $res1 = $controller->showLoginForm($reqWithoutKey);
    echo "TEST 1 FAILED: Expected 404 abort!\n";
} catch (NotFoundHttpException $e) {
    echo "TEST 1 PASSED: Direct /admin/login without key returned 404 Not Found!\n";
}

// Test 2: Request with valid key
$reqWithKey = Request::create('/admin/login?key=ngt-2026', 'GET');
try {
    $res2 = $controller->showLoginForm($reqWithKey);
    echo "TEST 2 PASSED: /admin/login?key=ngt-2026 returned Admin Login View successfully!\n";
} catch (Exception $e) {
    echo 'TEST 2 FAILED: '.$e->getMessage()."\n";
}
