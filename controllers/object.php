
<?php

require_once 'models/object.php';

class Controller_Object {

    public function __construct() {
        
    }

    public function objet_form() {
        if (isset($_SESSION['connect'])) {
            include 'views/objet_form.php';
        } else {
            $_SESSION['message'] = 'Vous devez être connecté pour ajouter un objet';
            header('Location: ' . BASEURL . '/index.php');
            exit();
        }
    }

    public function objet() {
        if (!isset($_SESSION['connect'])) {
            $content = 'Comment ?!';
        } else {
            $nomphoto = array();
            $id_obj = Model_Base::get_next_seq("seqobjet");

            // ajoute d'abord l'objet pour la ref obj de photo_objet
            $obj = Object::create($_SESSION['id'], $_POST['nom'], $_POST['desc'], $_POST['val'], $_POST['etat'], 0 , $_POST['cat']);

            if (!$obj) {
                $_SESSION['message'] = 'Votre objet n\'a pas bien été ajouté';
                header('Location: ' . BASEURL . '/views/objet_form.php');
                exit();
            }
            // ajoute les photo dans photo et photo_objet
            for ($i = 1; $i < 4; $i++) {
                if (!isset($_FILES[$i])) {
                    $_SESSION['message'] .= "pas d'image " . $i . " ";
                    $nomphoto[$i] = "uploads/obj/default.jpeg";
                    continue;
                }
                if ($_FILES[$i]['error'] > 0) {
                    echo "Erreur lors du transfert, image par defaut mise a la place";
                    $nomphoto[$i] = "uploads/obj/default.jpeg";
                    continue;
                }
                if ($_FILES[$i]['size'] > 1048576) {
                    echo "Le fichier est trop gros";
                    continue;
                }

                $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
                $extension_upload = strtolower(substr(strrchr($_FILES[$i]['name'], '.'), 1));
                if (in_array($extension_upload, $extensions_valides))
                    echo "Extension correcte";

                $nomphoto[$i] = "uploads/obj/{$_POST['nom']}.$i.{$extension_upload}";
                $resultat = move_uploaded_file($_FILES[$i]['tmp_name'], $nomphoto[$i]);
                //if ($resultat)
                    //$_SESSION['message'] .= "Transfert réussi de img" . $i;
            }
            // ajoute les photo 
            foreach ($nomphoto as $n) {
                Object::set_photo_obj($id_obj, $n);
            }
            $_SESSION['message'] .= 'Votre objet a bien été ajouté : ';
            header('Location: ' . BASEURL . '/index.php/objet_id/' . $id_obj);
//            header('Location: ' . BASEURL . '/index.php/all_object');
            exit();
        }
    }

    public function objet_id($id) {
        $obj = Object::get_by_id($id);
        include 'views/un_object.php';
    }

    public function all_object() {
        $array_obj = Object::get_all();
        include 'views/all_object.php';
    }
    
    public function all_my_object() {
        $my_obj = Object::get_my_all($_SESSION['id']);
        include 'views/myobj.php';
    }

}
