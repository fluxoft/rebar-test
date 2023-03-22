<?php

namespace RebarTest\Controllers;

use Fluxoft\Rebar\Container;
use Fluxoft\Rebar\Controller;
use Fluxoft\Rebar\Presenters\Twig;

class Main extends Controller {
	public function Setup(Container $c) {
		/** @var Twig $presenter */
		$presenter = $c['twig'];
		$this->presenter = $presenter;
	}

	public function Index() {
		$this->presenter->Template = 'main/index.twig';
	}
}
