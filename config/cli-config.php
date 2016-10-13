<?php

require_once dirname(__FILE__).'/../vendor/autoload.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use App\App;

$app = new App();

return ConsoleRunner::createHelperSet( $app->getEntityManager() );