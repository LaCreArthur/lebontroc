<?php
session_start();
error_reporting(E_ALL);
define('SQL_DSN', 'codd.u-strasbg.fr:1521/ROSA');
define('SQL_USERNAME', 'ascheidel');
define('SQL_PASSWORD', 'ascheidel');

require_once 'models/model_base.php';
require_once 'controllers/user.php';
require_once 'controllers/object.php';
require_once 'controllers/proposition.php';

if (isset($_SERVER['PATH_INFO'])) {
    $args = explode('/', $_SERVER['PATH_INFO']);
} else {
    $args = array("/", "/");
}

define('BASEURL', dirname($_SERVER['SCRIPT_NAME']));
//phpinfo();
Model_Base::set_db();

ob_start();
$cu = new Controller_User();
$cp = new Controller_Proposition();
$co = new Controller_Object();
$cm = new Model_Base();

if ($args[1] == '/') { // index.php
    echo "Page principale de l'application d'échange de biens et de services !";
    echo "<br>connectez-vous ou inscrivez-vous ";
} else if ($args[1] == 'connexion') {
    $cu->connexion();
} else if ($args[1] == 'deconnexion') {
    $cu->deconnexion();
} else if ($args[1] == 'valid_connect') {
    $cu->connexion_valide();
} else if ($args[1] == 'valid_inscription') {
    $cu->inscription_valide();
} else if ($args[1] == 'objet_form') {
    $co->objet_form();
} else if ($args[1] == 'objet') {
    $co->objet();
} else if ($args[1] == 'objet_id' && isset($args[2])) {
    $co->objet_id($args[2]);
} else if ($args[1] == 'all_object') {
    $co->all_object();
} else if ($args[1] == 'myobj') {
    $co->all_my_object();
} else if ($args[1] == 'inscription') {
    $cu->inscription();
} else if ($args[1] == 'user') {
    $cu->user();
} else if ($args[1] == 'valid_com_usr') {
    $cu->valid_com_usr();
} else if ($args[1] == 'other') {
    $cu->other($args[2]);
} else if ($args[1] == 'propositions') {
    $cp->propositions();
} else if ($args[1] == 'valid_proposition') {
    $cp->create_prop();
} else if ($args[1] == 'accept_prop') {
    $cp->accept_prop();
} else if ($args[1] == 'archive_prop') {
    $cp->archive_prop();
} else if ($args[1] == 'myprops') {
    $cp->myprops();
} else if ($args[1] == 'archives') {
    $cp->archives();
} else if ($args[1] == 'prop_form') {
    $cp->prop_form();
} else if ($args[1] == 'not_done_yet') {
    $cm->not_done_yet();
} else {
    echo "La page demandée n'existe pas.";
}

$content = ob_get_clean();
Model_Base::close_db();
?>
<!DOCTYPE html>
<html lang="fr"><head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="<?= BASEURL ?>/normalize.css" />
        <link rel="stylesheet" href="<?= BASEURL ?>/css/style.css" />
        <link rel="stylesheet" href="<?= BASEURL ?>/css/avgrund.css" />
        <link rel="stylesheet" href="<?= BASEURL ?>/css/tinycarousel.css" />
        <title> Troc de biens et de services</title>
    </head>
    <body>
        <div id="content-wrapper">
            <div class="avgrund-contents">
                <?php
                include 'views/nav.php';
                include 'views/header.php';
                ?>
                <a id="title" href="<?= BASEURL ?>/index.php" style="border:none">
                </a>
                <?php
                if (isset($_SESSION['message'])) {
                    echo '<p>' . $_SESSION['message'] . '</p>';
                    unset($_SESSION['message']);
                }
                // redimensionner le texte de nav pour admin qui a plus d'options
                if (isset($_SESSION['nom']) && ($_SESSION['nom'] === "admin")) {
                    echo "<style> button,nav a { font-size:1.2rem !important}</style>";
                }
                if (!isset($_SESSION['connect'])) {
                    echo "<style> button,nav a { font-size:1.6rem !important}</style>";
                }
                if (!isset($_SESSION['connect'])) {
                    echo "<style> button,nav a { font-size:1.4rem}</style>";
                }
                ?>
            </div>
            <p class="text-center">
                <?= $content ?>
            </p>
        </div>
        <div class="avgrund-contents">
            <?php
            include 'views/footer.php';
            // phpinfo();
            ?>
        </div>
        <script>
            function openDialog() {
                Avgrund.show("[id^=default-popup]");
            }
            function openDialog1() {
                Avgrund.show("[id=popup_acheteur]");
            }
            function openDialog2() {
                Avgrund.show("[id=popup_vendeur]");
            }
            function openconnect() {
                Avgrund.show("[id^=connect-popup]");
            }
            function closeDialog() {
                Avgrund.hide();
            }
        </script>
        <script type="text/javascript" src="http://turing.u-strasbg.fr/~ascheidel/js/avgrund.js"></script>
        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-latest.min.js"></script>
        <script>

//            // essayer de supprimer ca !
//            var _gaq = [['_setAccount', 'UA-15240703-1'], ['_trackPageview']];
//            (function (d, t) {
//                var g = d.createElement(t),
//                        s = d.getElementsByTagName(t)[0];
//                g.async = true;
//                g.src = ('https:' == location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
//                s.parentNode.insertBefore(g, s);
//            })(document, 'script');
//            // jusque la

            $(document).ready(function () {
                // ----------- DEBUT TINYCAROUSEL
                $("#slider7").tinycarousel({interval: true});
                var slider7 = $("#slider7").data("plugin_tinycarousel");
                // ------------ FIN TINYCAROUSE

                var text;
                $("#signin").hover(function () {
                    text = $(this).text();
                    $(this).children("a").text("S'inscrire");
                    $(this).css("text-align : center;")
                },
                        function () {
                            $(this).children("a").text(text);
                        });
            });
        </script>

        <script type="text/javascript" src="http://turing.u-strasbg.fr/~ascheidel/js/jquery.tinycarousel.js"></script>
        <div class="avgrund-cover"></div>

    </body>
</html>