<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
//require __DIR__ . '/controllers/AlunniController.php';
require __DIR__ . '/controllers/CertificazioniController.php';
require __DIR__ . '/includes/Db.php';

$app = AppFactory::create();

/*index con soli alunni
$app->get('/alunni', "AlunniController:index");
$app->get('/alunni/{id:\d+}', "AlunniController:view");
$app->post('/alunni', "AlunniController:create");
$app->put('/alunni', "AlunniController:update");
$app->delete('/alunni', "AlunniController:destroy");
$app->get('/alunni/search/{lettere:\w+}', "AlunniController:search");
$app->get('/alunni/sort/{col}', "AlunniController:sort");
*/
//index con tutto
$app->get('/alunni/{id:\d+}/cert', "CertificazioniController:view");
$app->get('/alunni/{id:\d+}/cert/{cert_id:\d+}', "CertificazioniController:search");
$app->post('/alunni/{id:\d+}/cert', "CertificazioniController:create");


$app->run();
?>  