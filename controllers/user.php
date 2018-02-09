
<?php

require_once 'models/user_base.php';

class Controller_User {

    public function connexion() {
        if (isset($_SESSION['connect'])) {
            echo 'Vous êtes déja connecté.';
        } else {
            include 'views/connexion_form.php';
        }
    }

    public function deconnexion() {
        if (!isset($_SESSION['connect'])) {
            echo "Vous n'êtes pas connecté.";
        } else {
            $_SESSION['message'] = 'Vous êtes deconnecté';
            unset($_SESSION['connect']);
            header('Location: ' . BASEURL . '/index.php');
            exit();
        }
    }

    public function archives() {
        if (!($_SESSION['nom'] == "admin")) {
            echo "Comment ?!";
        } else {
            include 'views/archives.php';
        }
    }

    public function inscription() {
        if (!isset($_SESSION['connect']))
            include 'views/inscription_form.php';
        else
            echo "Comment ?!";
    }

    public function user() {
        if (isset($_SESSION['connect']))
            $usr = User::get_usr_by_id($_SESSION['id']);
        include 'views/user_info.php';
    }

    public function other($id) {
        if (isset($_SESSION['connect'])) {
            $usr = User::get_usr_by_id($id);
        }
        include 'views/other_info.php';
    }

    public function valid_com_usr() {
        if (isset($_SESSION['connect'])) {
            //var_dump($_POST);
            $usr = User::set_com_to_id($_POST['id_note'], $_SESSION['id'], $_POST['com'], $_POST['note']);
        }
        //include 'views/other_info.php';
    }

    public function connexion_valide() {
        if (isset($_SESSION['connect'])) {
            $content = 'Vous êtes deja connecté.';
        } else {
            if (($usr = User::get_usr($_POST['nom'], $_POST['password'])) != NULL) {
                $_SESSION['nom'] = $_POST['nom'];
                $_SESSION['id'] = $usr->id_usr();
                $_SESSION['message'] = 'Bonjour ' . $_POST['nom'];
                $_SESSION['connect'] = true;
                header('Location: ' . BASEURL . '/index.php/user');
                exit();
            } else {
                $_SESSION['message'] = 'Login ou mot de passe incorrect.';
                header('Location: ' . BASEURL . '/index.php');
                exit();
            }
        }
    }

    public function inscription_valide() {
        if (isset($_SESSION['connect'])) {
            $content = 'Comment ?!';
        } else {
            if ($_FILES['img']['error'] > 0)
                echo "Erreur lors du transfert";
            if ($_FILES['img']['size'] > 1048576)
                echo "Le fichier est trop gros";

            $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
            $extension_upload = strtolower(substr(strrchr($_FILES['img']['name'], '.'), 1));
            if (in_array($extension_upload, $extensions_valides))
                echo "Extension correcte";

            $nomphoto = "uploads/usr/{$_POST['nom']}.{$extension_upload}";
            $resultat = move_uploaded_file($_FILES['img']['tmp_name'], $nomphoto);
            if ($resultat)
                echo "Transfert réussi";

            if (($usr = User::inscr_usr($_POST['nom'], $_POST['password'], $_POST['coordx'], $_POST['coordy'], $nomphoto)) != NULL) {

                $_SESSION['nom'] = $_POST['nom'];
                $_SESSION['message'] = 'Bravo ' . $_POST['nom'] . ', vous êtes maintenant inscrit';
                $_SESSION['connect'] = true;
                $_SESSION['id'] = $usr->id_usr();
                header('Location: ' . BASEURL . '/index.php/user');
                exit();
//                }
            } else {
                $_SESSION['message'] = 'Probleme dans l\'inscription';
                header('Location: ' . BASEURL . '/index.php/inscriprion');
                exit();
            }
        }
    }

}
