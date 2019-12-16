<?php 

namespace App;

use DI\ContainerBuilder;
use Interop\Container\ContainerInterface as Container;

use Predis\Client;
use Monolog\{Handler\FingersCrossedHandler, Handler\StreamHandler, Logger};
use App\Support\{NotFound, Storage\Cache, Extensions\VarDump};
use Slim\Views\{Twig, TwigExtension};
use App\Database\Eloquent;
use Illuminate\Database\Capsule\Manager as Capsule;
use Twig_Extension_Debug;



class App extends \DI\Bridge\Slim\App
{

    private $definitions;

    /**
     * App constructor.
     * @param $definitions
     */
    public function __construct(array $definitions = null)
    {
        $this->definitions = $definitions;
        parent::__construct();
    }

    protected function configureContainer(ContainerBuilder $builder): void
    {
        $dependencies = [
            Twig::class => function (Container $container) {
                $view = new Twig(['../resources/views', '../resources/assets'], $container->get('twig'));
                $view->addExtension(new TwigExtension(
                    $container->get('router'),
                    $container->get('request')->getUri()
                ));
                $view->addExtension(new Twig_Extension_Debug());
                $view->addExtension(new VarDump());
                $view->getEnvironment()->addGlobal('APP_NAME', getenv('APP_NAME'));
                return $view;
            },

            Eloquent::class => function (Container $container)  {
                 $capsule = new Capsule;
                 $capsule->addConnection($container->get('db'));
                 $capsule->setAsGlobal();
                 $capsule->bootEloquent();
                 return $capsule;
             },

            Logger::class => function() {
                $logger = new Logger('logger');
                $filename = __DIR__ . '/../logs/error.log';
                $stream = new StreamHandler($filename, Logger::DEBUG);
                $fingersCrossed = new FingersCrossedHandler(
                    $stream, Logger::ERROR);
                $logger->pushHandler($fingersCrossed);
                return $logger;
            },

            'notFoundHandler' => function(Container $container){
                return new NotFound($container->get(Twig::class));
            },

            'errorHandler' => function(Container $container) {
                return new Support\Error($container->get('settings.displayErrorDetails'),$container->get(Logger::class));
            },

            'cache' => function (Container $container) {
                $client = new Client([
                    'scheme' => 'tcp',
                    'host' => $container->get('redis')['host'],
                    'port' => $container->get('redis')['port'],
                    'password' => $container->get('redis')['password'],
                ]);

                return new Cache($client);
            },

        ];

        $builder->addDefinitions($this->definitions);
        $builder->addDefinitions($dependencies);
    }
}