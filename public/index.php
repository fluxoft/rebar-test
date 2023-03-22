<?php

namespace RebarTest;

use Fluxoft\Rebar\Error\BasicNotifier;
use Fluxoft\Rebar\Error\Handler;
use Fluxoft\Rebar\Exceptions\AuthenticationException;
use Fluxoft\Rebar\Exceptions\RouterException;
use Fluxoft\Rebar\Http\Environment;
use Fluxoft\Rebar\Http\Request;
use Fluxoft\Rebar\Http\Response;
use Fluxoft\Rebar\Router;

error_reporting(E_ALL);
ini_set('display_errors', 'on');

$container = require_once 'services.php';

Handler::Handle(new BasicNotifier());

$router = new Router(
	'RebarTest\\Controllers',
	[$container]
);

$request  = new Request(
	Environment::GetInstance()
);
$response = new Response();

try {
	$router->Route($request, $response);
} catch (RouterException $e) {
	$response->Status = 404;
	$response->AddHeader('content-type', 'text/plain');
	$response->Body .= $e->getMessage();
	$response->Send();
} catch (AuthenticationException $e) {
	$response->Redirect('/auth/login');
}
