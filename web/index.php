<?php
date_default_timezone_set("Asia/Jakarta");
require_once('../vendor/autoload.php');

/*
 * Todo: refactor into it's own standalone loader
 */
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TwigServiceProvider;


$app = new Silex\Application();
$app->register(new Silex\Provider\DoctrineServiceProvider());

// Show errors
$app['debug'] = true;

// Templates
$app->register(new TwigServiceProvider(), array(
    'twig.options'         => array(
        'cache'            => false,
        'strict_variables' => true
    ),
    'twig.path'            => array(__DIR__ . '/../resources/views')
));

/*
 * Todo: Extract into reuseable connection
 */
// Doctrine (db)
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'host'     => 'localhost',
    'dbname'   => 'bookstore',
    'user'     => 'root',
    'password' => '',
);

$app->get('/', function() use ($app)
{
    $alphas = []; //initialize blank alphas array
    /*
     * Todo: refactor into it's own model
     * performance note: triggering  index_title
     */
    $books = $app['db']->fetchAll('SELECT id, substr(title,1,1) as alpha, title, description FROM books;');
    foreach($books as $book)
    {
        {
            $alphas[] = $book['alpha'];
        }
    }
    return $app['twig']->render(
        'index.html.twig',
        array(
            'books' => $books,
            'alphas' => $alphas,
            'index_name' => [] //variable will be used on view only
        )
    );
});

$app->get('/book/{id}', function($id) use ($app)
{
    if(isset($_REQUEST['title']) && isset($_REQUEST['description']))
    {
        $title = $_REQUEST['title'];
        $description = $_REQUEST['description'];
    }
    else
    {
        /*
         * introduce caching on doctrine2
         */
        $book = $app['db']->fetchAll('SELECT id,isbn,title,description FROM books WHERE id = '.$id.' LIMIT 1');
        $title = $book[0]['title'];
        $description = $book[0]['description'];
    }

    return $app['twig']->render(
        'book.html.twig',
        array(
            'book' => [
                'title' => $title,
                'description' => $description
            ]
        )
    );
});


$app->run();