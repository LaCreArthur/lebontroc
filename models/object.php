<?php

require_once 'models/model_base.php';

/**
 * 
 */
class Object extends Model_Base {

    private $_id;
    private $_id_usr;
    private $_nom;
    private $_descriptif;
    private $_valeur;
    private $_etat;
    private $_cat;

    public function __construct($id, $id_usr, $nom, $desc, $val, $etat, $cat) {
        $this->_id = $id;
        $this->_id_usr = $id_usr;
        $this->_nom = $nom;
        $this->_descriptif = $desc;
        $this->_valeur = $val;
        $this->_etat = $etat;
        $this->_cat = $cat;
    }

    // Setter et Getter

    public function id() {
        return $this->_id;
    }

    public function set_id($id) {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        }
    }

    public function id_usr() {
        return $this->_id_usr;
    }

    public function set_id_usr($id) {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id_usr = $id;
        }
    }

    public function nom() {
        return $this->_nom;
    }

    public function set_nom($c) {
        $this->_nom = $c;
    }

    public function descriptif() {
        return $this->_descriptif;
    }

    public function set_descriptif($c) {
        $this->_descriptif = $c;
    }

    public function valeur() {
        return $this->_valeur;
    }

    public function set_valeur($val) {
        $val = (int) $val;
        if ($val > 0) {
            $this->_valeur = $val;
        }
    }

    public function etat() {
        return $this->_etat;
    }

    public function set_etat($etat) {
        $etat = (string) $etat;
        if ($etat > 0) {
            $this->_etat = $etat;
        }
    }

    public function cat() {
        return $this->_cat;
    }

    public function set_cat($cat) {
        $cat = (int) $cat;
        if ($cat > 0) {
            $this->_cat = $cat;
        }
    }

    public static function set_photo_obj($id, $path) {

        $id_photo = Model_Base::get_next_seq("seqphoto");

        // d'abord insert dans photo pour avoir l'id de la photo a mettre dans photo_objet
        $query = "insert into photo values (:photo, :path)";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur informations invalides" . oci_error($conn));
        oci_bind_by_name($stmt, ":photo", $id_photo);
        oci_bind_by_name($stmt, ":path", $path);
        oci_execute($stmt);

        $query = "insert into photo_objet values (:photo, :id)";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur informations invalides" . oci_error($conn));
        oci_bind_by_name($stmt, ":photo", $id_photo);
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);
        return;
    }

    public static function create($id_usr, $nom, $desc, $val, $etat, $service, $cat) {
        // insertion de l'objet 
        var_dump($cat);
        $query = "INSERT INTO objet VALUES (seqobjet.currval,:id_usr, :cat, :nom_obj,:desc_obj,:etat_obj,:prix_dep,:service, 0)";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("oci_parse create objet - insert error" . oci_error($conn));
        oci_bind_by_name($stmt, ":id_usr", $id_usr);
        oci_bind_by_name($stmt, ":nom_obj", $nom);
        oci_bind_by_name($stmt, ":desc_obj", $desc);
        oci_bind_by_name($stmt, ":etat_obj", $etat);
        oci_bind_by_name($stmt, ":prix_dep", $val);
        oci_bind_by_name($stmt, ":service", $service);
        oci_bind_by_name($stmt, ":cat", $cat);
        if ((oci_execute($stmt)) === TRUE)
            echo "ca a insere";
        else
            echo "ca a bug !";
        $id_obj = Model_base::get_seq("seqobjet");
        return new Object($id_obj, $id_usr, $nom, $desc, $val, $etat, $cat);
    }

    public static function get_photo_obj($id) {
        $query = "select * from photo_objet where id_obj=:id";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur informations invalides" . oci_error($conn));
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);
        $i = 0;
        while (($row = oci_fetch_assoc($stmt)) != null) {
            $photo = $row['ID_PHOTO'];
            $query = "select * from photo where id_photo=:photo";
            $stmt1 = @oci_parse(Model_Base::$_db, $query) or die("erreur informations invalides" . oci_error($conn));
            oci_bind_by_name($stmt1, ":photo", $photo);
            oci_execute($stmt1);

            if (($row1 = oci_fetch_assoc($stmt1)) != null) {
                if ($i == 0)
                    echo ("<div class='round' style='margin : 0;float:unset;'> <img src='" . BASEURL . "/" . $row1['PATH_PHOTO'] . "' /> </div>");
                else {
                    $marginleft = 200 * $i;
                    echo ("<div class='round' style='margin : -150px 0 0 " . $marginleft . "px'> <img src='" . BASEURL . "/" . $row1['PATH_PHOTO'] . "' /> </div>");
                }
                $i++;
            }
        }
    }

    public static function get_by_id($id) {
        $query = "SELECT * FROM objet WHERE id_obj=:id";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion " . oci_error($conn));
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
        if ($row != null) {
            $id = $row['ID_OBJ'];
            $id_usr = $row['ID_USR'];
            $nom = $row['NOM_OBJ'];
            $desc = $row['DESC_OBJ'];
            $val = $row['PRIX_DEP'];
            $etat = $row['ETAT_OBJ'];
            $cat = $row['ID_CAT'];
            $o = new Object($id, $id_usr, $nom, $desc, $val, $etat, $cat);
        } else {
            $o = null;
        }

        return $o;
    }

    public static function get_all() {
        $query = "SELECT * FROM objet where vendu = 0";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion " . oci_error($conn));
        oci_execute($stmt);

        $array_obj = array();
        while ($row = oci_fetch_assoc($stmt)) {
            $id = $row['ID_OBJ'];
            $id_usr = $row['ID_USR'];
            $nom = $row['NOM_OBJ'];
            $desc = $row['DESC_OBJ'];
            $val = $row['PRIX_DEP'];
            $etat = $row['ETAT_OBJ'];
            $cat = $row['ID_CAT'];
            $array_obj[] = new Object($id, $id_usr, $nom, $desc, $val, $etat, $cat);
        }
        return $array_obj;
    }

    public static function get_my_all($id) {
        $query = "SELECT * FROM objet where vendu = 0 and id_usr = :id";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion " . oci_error($conn));
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);

        $my_obj = array();
        while ($row = oci_fetch_assoc($stmt)) {
            $id = $row['ID_OBJ'];
            $id_usr = $row['ID_USR'];
            $nom = $row['NOM_OBJ'];
            $desc = $row['DESC_OBJ'];
            $val = $row['PRIX_DEP'];
            $etat = $row['ETAT_OBJ'];
            $cat = $row['ID_CAT'];
            $my_obj[] = new Object($id, $id_usr, $nom, $desc, $val, $etat, $cat);
        }
        return $my_obj;
    }

    public static function bonneaffaire($id) {
        $query = "select bonneaffaire(:id) from dual";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion " . oci_error($conn));
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);

        return $row["BONNEAFFAIRE(:ID)"];
    }

    public static function all_cat() {
        $query = "select * from categorie order by id_sur_cat desc";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion " . oci_error($conn));
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);

        $cats = array();
        $i = 0;
        while ($row = oci_fetch_assoc($stmt)) {
            $cats[$i] = array($row['ID_CAT'], $row['ID_SUR_CAT'], $row['NOM_CAT']);
            $i++;
        }
        return $cats;
    }

    public static function get_cat_name($cat) {
        $query = "select nom_cat from categorie where id_cat = :cat";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion " . oci_error($conn));
        oci_bind_by_name($stmt, ":cat", $cat);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);

        return $row['NOM_CAT'];
    }

}
