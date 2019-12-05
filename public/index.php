<?php
// création des "names spaces" spécifiques // et généré à partir de l'instanciation et du get
use DI\Container;
use M2i\monProjet\Model\PublisherDAO;
use Slim\Factory\AppFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use M2i\monProjet\Controller\PublisherController;

// enregistrement du chemin racine avec la constante define
define("ROOT_PATH", dirname(__DIR__));

require ROOT_PATH . "../vendor/autoload.php";


// création du conteneur de dépendances disponibles pour toute mon application
// à créer au moment de la création de l'app
$container = new Container();
AppFactory::setContainer($container);
$app = appFactory::create();

$container->set("pdo", function () {
    // définition de la connexion
    $pdo = new \PDO("mysql:host=localhost;dbname=test", "root", "", [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    return $pdo;
});

$container->set("dao.publisher", function () use ($container) {
    // instanciation du DAO
    $publisherDAO = new PublisherDAO($container->get("pdo"));
    return $publisherDAO;
});

// instanciation de Slim
$app = AppFactory::create();

// dire ce que l'app doit répondre quand on la créée
// toutes nos fonctions doivent retourner une réponse
// quand on envoie une requête avec la méthode Get, on execute la fonction
$app->get("/hello/{name}", function (RequestInterface $request, ResponseInterface $response, $args) {
    $name = $args["name"];
    $response->getBody()->write("Hello $name");
    return $response;
});

// afficher le nom du publisher quand on appelle l'id en argument
// attention : les fonctions anonymes n'importent pas les variables

//on instancie le DAO dans la function - V1
/*
$app->get("/publisher/{id}", function (RequestInterface $request, ResponseInterface $response, $args){
    $id = $args["id"];

    // définition de la connexion
    $pdo = new \PDO("mysql:host=localhost;dbname=test", "root", "",
        [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);

    // instanciation du DAO
    $publisherDAO = new M2i\monProjet\Model\PublisherDAO($pdo);

    // j'encapsule ma fonction dans une variable
    $result = $publisherDAO->findOneById($id);

    $response->getBody()->write("L'id de publisher est {$result["id"]}, son nom est {$result["name"]}");
    return $response;
});
*/

// spécifier que la fonction doit utiliser $publisherDAO - V2
$app->get("/publisher/{id}", PublisherController::class. ":ShowOne");

$app->get("/publishers/", PublisherController::class. ":ShowAll");

$app->delete("/publishers/{id}", PublisherController::class. ":DeleteOne");

$app->run();