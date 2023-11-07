<?php
//// Allereerst zorgen dat de "Autoloader" uit vendor opgenomen wordt:
require_once("./vendor/autoload.php");

/// Twig koppelen:
$loader = new \Twig\Loader\FilesystemLoader("./templates");
/// VOOR PRODUCTIE:
/// $twig = new \Twig\Environment($loader), ["cache" => "./cache/cc"]);

/// VOOR DEVELOPMENT:
$twig = new \Twig\Environment($loader, ["debug" => true ]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

/******************************/

/// Next step, iets met je data doen. Ophalen of zo
require_once("lib/gerecht.php");
require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/ingredient.php");
require_once('lib/keukentype.php');
require_once('lib/user.php');
require_once('lib/gerechtinfo.php');
require_once('lib/boodschappen.php');
$db = new database();
$gerecht = new gerecht($db->getConnection());
$artikel = new artikel($db->getConnection());
$ingredient = new ingredient($db->getConnection());
$keukentype = new keukentype($db->getConnection());
$user = new user($db->getConnection());
$gerecht_info = new gerechtinfo($db->getConnection());
$boodschappen = new boodschappen($db->getConnection());

$data = $gerecht->selecteer_gerecht();


/*
URL:
http://localhost/index.php?gerecht_id=4&action=detail
*/

$gerecht_id = isset($_GET["gerecht_id"]) ? $_GET["gerecht_id"] : "";
$action = isset($_GET["action"]) ? $_GET["action"] : "homepage";


switch($action) {

        case "homepage": {
            $data = $gerecht->selecteer_gerecht();
            $template = 'homepage.html.twig';
            $title = "homepage";
            break;
        }

        case "detail": {
            $data = $gerecht->selecteer_gerecht($gerecht_id);
            $template = 'detail.html.twig';
            $title = "detail pagina";
            break;
        }

        /// etc

}



/// Onderstaande code schrijf je idealiter in een layout klasse of iets dergelijks
/// Juiste template laden, in dit geval "homepage"
$template = $twig->load($template);


/// En tonen die handel!
echo $template->render(["title" => $title, "data" => $data]);
