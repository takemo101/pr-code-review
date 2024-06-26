<?php

require_once 'router.php';

// http ルーティングによるリクエストの処理を実装します

// ルーティング設定
$router = new Router();
$router->add('/', function () {
    return 'Hello, World!';
});
$router->add('/users', function () {
    return 'Users list';
});
$router->add('/users/{id}', function ($id) {
    return "User: {$id}";
});

// リクエスト取得
$path = $_SERVER['REQUEST_URI'];

// ルーティング処理
$result = $router->route($path);

// ルーティング結果によるレスポンスの返却

if ($result['isMatch']) {
    $handler = $result['handler'];
    $params = $result['params'];
    echo $handler(...array_values($params));
} else {
    http_response_code(404);
    echo 'Not Found';
}
