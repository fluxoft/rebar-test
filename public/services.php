<?php
namespace RebarTest;

use Fluxoft\Rebar\Container;
use Fluxoft\Rebar\Presenters\Twig;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__.'/../vendor/autoload.php';
$c = new Container();

$c['cachePath'] = __DIR__.'/../cache/';
$c['templatePath'] = __DIR__.'/../templates/';

$c['twig'] = function($c) {
	return new Twig(
		new Environment(
			new FilesystemLoader($c['templatePath']),
			[
				'cache' => $c['cachePath'].'Twig/cache'
			]
		)
	);
};

return $c;