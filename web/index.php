<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;


$app = new Silex\Application();

// ---------------
$app->register(new Silex\Provider\TwigServiceProvider(),[
    'twig.path' => __DIR__ . '/../app/View',
]);
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider());
$app['security.firewalls'] = [
    'main' => [
        'pattern' => '^/',
        'anonymous' => true,
        'form' => ['login_path' => '/login', 'check_path' => '/login_check'],
        'logout' => ['logout_path' => '/logout', 'invalidate_session' => true],
        'users' => function () use ($app) {
            return new App\Model\Security\User\UserProvider();
        },
    ],
];
$app['security.default_encoder'] = function ($app) {
    return new Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder();
};

$app->register(new Silex\Provider\HttpFragmentServiceProvider());
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\WebProfilerServiceProvider(), [
    'profiler.cache_dir' => __DIR__.'/../cache/profiler',
    'profiler.mount_prefix' => '/_profiler',
]);
// ---------------

$app->before(function (Request $request, $app) {
});

$app->get('/login', function (Request $request) use ($app) {
    $data["error"] = $app['security.last_error']($request);
    $data["last_username"] = $app['session']->get('_security.last_username');
    return $app["twig"]->render("login.html", $data);
});

$app->get('/', function () use ($app) {
    return $app["twig"]->render("index.html", []);
});

$app->run();
