<?php 

namespace App\Controllers;

use Slim\Http\Response;

class HomeController extends Controller {

	public function index(Response $response)
	{
        return $this->view->render($response, 'templates/index.twig');
	}
}