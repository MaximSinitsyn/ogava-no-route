<?php
// маршруты (можно хранить в конфиге приложения)
// можно использовать wildcards (подстановки):
// :any - любое цифробуквенное сочетание
// :num - только цифры
// в результирующее выражение записываются как $1, $2 и т.д. по порядку

/* $routes = array(
    'url' => 'контроллер/действие/параметр1/параметр2/параметр3'
    '/' => 'MainController/index', // главная страница
    '/contacts' => 'MainController/contacts', // страница контактов
    '/blog' => 'BlogController/index', // список постов блога
    '/blog/:num' => 'BlogController/viewPost/$1' // просмотр отдельного поста, например, /blog/123
    '/blog/:any/:num' => 'BlogController/$1/$2' // действия над постом, например, /blog/edit/123 или /blog/dеlete/123
    '/:any' => 'MainController/anyAction' // все остальные запросы обрабатываются здесь
)); */


require_once $_SERVER['DOCUMENT_ROOT'].'/scripts/Router.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/scripts/controllers/MainController.php';

$router = Bit55\Litero\Router::fromGlobals();

$router->add([
    '/'       => 'Bit55\Litero\MainController@base',
    '/services'       => 'Bit55\Litero\MainController@services',
    '/services/:any' => 'Bit55\Litero\MainController@servicesAny',
    '/sale'       => 'Bit55\Litero\MainController@sale'
]);


// Start route processing
if ($router->isFound()) {
    $router->executeHandler(
        $router->getRequestHandler(),
        $router->getParams()
    );
}
else {
    // Simple "Not found" handler
    $router->executeHandler(function () {
        http_response_code(404);
        echo '404 Not found';
    });
}
?>