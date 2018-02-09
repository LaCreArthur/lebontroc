
<?php

require_once 'models/proposition.php';

class Controller_Proposition {

    public function __construct() {
        
    }

    public function myprops() {
        if (!isset($_SESSION['connect'])) {
            echo "Comment ?!";
        } else {
            $myprops = Proposition::get_p_by_usrid($_SESSION['id']);
            include 'views/myprops.php';
        }
    }

    public function prop_form() {
        if (!isset($_SESSION['connect'])) {
            echo "Comment ?!";
        } else {
            $idobj = current($_GET);
            include 'views/prop_form.php';
        }
    }

    public function create_prop() {
        if (!isset($_SESSION['connect'])) {
            echo "Comment ?!";
        } else {
            $prop = Proposition::create_prop($_SESSION['id'], $_POST['vendeur'], $_POST['ptroc_acheteur'], $_POST['coordx'], $_POST['coordy'], $_POST['date'], $_POST['ptroc_vendeur']);
            if ((Proposition::create_recoit($_POST['objprop'], $prop->id())) != 0)
                $_SESSION['message'] = "create_recoit_une a bugué dommage ?!";
            else
                $_SESSION['message'] = "proposition envoyee";

            // si le contenu de post = on c'est qu'il sagit d'une checkbox alors ajouter la clef dans recoit_une
            while (($p = current($_POST)) !== FALSE) {
                if ($p == 'on') {
                    $key = key($_POST);
                    Proposition::create_recoit($key, $prop->id());
                    $_SESSION['message'] = "recoit_une ajoute " . $key . $prop->id() . " _ ";
                }
                next($_POST);
            }
            //header('Location: ' . BASEURL. '/index.php/myprops');
        }
    }

    // SPECIAL ADMIN OPTIONS
    public function propositions() {
        if (!($_SESSION['nom'] == "admin")) {
            echo "Comment ?!";
        } else {
            $array_prop = Proposition::get_all_p();
            include 'views/all_propositions.php';
        }
    }

    public function archives() {
        if (!($_SESSION['nom'] == "admin")) {
            echo "Comment ?!";
        } else {
            $array_arch = Proposition::get_all_a();
            include 'views/all_archives.php';
        }
    }

    public function archive_prop() {
        if (!($_SESSION['nom'] == "admin")) {
            echo "Comment ?!";
        } else {
            if ((Proposition::arcmypropshive_prop()) === TRUE) {
                include 'views/all_archives.php';
            } else
                echo "erreur pour archiver les proposition ";
        }
    }

    public function accept_prop() {
        if (!isset($_SESSION['connect'])) {
            echo "Comment ?!";
        } else {
            if ((Proposition::acccept_prop_by_id($_POST['prop_id'])) === TRUE) {
                include 'views/myprops.php';
            } else
                echo "erreur pour accepter la proposition ";
        }
    }

}
