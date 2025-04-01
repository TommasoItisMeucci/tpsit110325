<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/AlunniController.php';

$app = AppFactory::create();

$app->get('/alunni', "AlunniController:index");
$app->get('/alunni/{id:\d+}', "AlunniController:view");
$app->post('/alunni', "AlunniController:create");
$app->put('/alunni', "AlunniController:update");
$app->delete('/alunni', "AlunniController:destroy");
$app->get('/alunni/{lettere:\w+}', "AlunniController:search");

$app->run();
?>