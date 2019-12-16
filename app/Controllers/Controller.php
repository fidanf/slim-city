<?php

namespace App\Controllers;

use Interop\Container\ContainerInterface as Container;
use App\Database\Eloquent;
use App\Support\Storage\Session;
use League\Fractal\Manager;
use Slim\Flash\Messages;
use Slim\Views\Twig;

abstract class Controller
{
    protected $view;
    protected $db;
    protected $session;
    protected $mail;
    protected $router;
    protected $cache;

    /**
     * Controller constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->view = $container->get(Twig::class);
        $this->db = $container->get(Eloquent::class);
        $this->session = $container->get(Session::class);
        $this->fractal = $container->get(Manager::class);
        $this->router = $container->get('router');
        $this->cache = $container->get('cache');
    }

}