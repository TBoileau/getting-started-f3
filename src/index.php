<?php

session_start();

require __DIR__.'/../vendor/autoload.php';

$f3 = \Base::instance();

$sqlite = __DIR__.'/../db.sqlite';

\Template::instance()->filter('format_datetime', 'TBoileau\FatFreeFramework\Templating\DateTimeHelper::format');

$f3->set('DB', new DB\SQL(sprintf('sqlite:%s', $sqlite)));

$f3->route('GET @blog_home: /', 'TBoileau\FatFreeFramework\Controller\BlogController->home');
$f3->route('POST /create', 'TBoileau\FatFreeFramework\Controller\BlogController->create');
$f3->route('GET|POST /@id/update', 'TBoileau\FatFreeFramework\Controller\BlogController->update');
$f3->route('GET|POST /@id/delete', 'TBoileau\FatFreeFramework\Controller\BlogController->delete');

$f3->run();
