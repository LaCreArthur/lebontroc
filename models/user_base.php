<?php

require_once 'models/model_base.php';

/**
 * 
 */
class User extends Model_Base {

    private $_id_usr;
    private $_id_pic;
    private $_nom;
    private $_pass;
    private $_coordx_usr;
    private $_coordy_usr;
    private $_note;
    private $_ptroc;

    public function __construct($id_usr, $id_pic, $nom, $pass, $coordx_usr, $coordy_usr, $note, $ptroc) {
        $this->_id_usr = $id_usr;
        $this->_id_pic = $id_pic;
        $this->_nom = $nom;
        $this->_pass = $pass;
        $this->_coordx_usr = $coordx_usr;
        $this->_coordy_usr = $coordy_usr;
        $this->_note = $note;
        $this->_ptroc = $ptroc;
    }

    public function id_usr() {
        return $this->_id_usr;
    }

    public function set_id_usr($id_usr) {
        $id = (int) $id_usr;
        if ($id_usr > 0) {
            $this->_id_usr = $id_usr;
        }
    }

    public function id_pic() {
        return $this->_id_pic;
    }

    public function set_id_pic($id_pic) {
        $id_ic = (int) $id_pic;
        if ($id_ic > 0) {
            $this->_id_pic = $id_pic;
        }
    }

    public function nom() {
        return $this->_nom;
    }

    public function set_nom($nom) {
        $this->_nom = $nom;
    }

    public function pass() {
        return $this->_pass;
    }

    public function set_pass($pass) {
        $this->_pass = $pass;
    }

    public function coordx_usr() {
        return $this->_coordx_usr;
    }

    public function set_coordx_usr($coordx_usr) {
        $this->_coordx_usr = $coordx_usr;
    }

    public function coordy_usr() {
        return $this->_coordy_usr;
    }

    public function set_coordy_usr($coordy_usr) {
        $this->_coordy_usr = $coordy_usr;
    }

    public function note() {
        return $this->_note;
    }

    public function set_note($note) {
        $this->_note = $note;
    }

    public function ptroc() {
        return $this->_ptroc;
    }

    public function set_ptroc($ptroc) {
        $this->_ptroc = $ptroc;
    }

    public static function get_usr($nom, $pass) {
        
        $hash = hash('md2',$pass);
        $query = "select * from usr where nom_usr=:nom and pass=:pass";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur informations invalides" . oci_error($conn));
        oci_bind_by_name($stmt, ":nom", $nom);
        oci_bind_by_name($stmt, ":pass", $hash);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);

        if ($row != null) {
            $id_usr = $row['ID_USR'];
            $id_pic = $row['ID_PHOTO'];
            $nom = $row['NOM_USR'];
            $pass = $row['PASS'];
            $coordx_usr = $row['COORDX_USR'];
            $coordy_usr = $row['COORDY_USR'];
            $note = $row['NOTE_USR'];
            $ptroc = $row['PTROC_USR'];
            $o = new User($id_usr, $id_pic, $nom, $pass, $coordx_usr, $coordy_usr, $note, $ptroc);
        } else {
            echo "get_usr n'a pas trouvé";
            $o = null;
        }
        return $o;
    }

    public static function get_usr_by_id($id) {
        $query = "select * from usr where id_usr=:id";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur informations invalides" . oci_error($conn));
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);

        if ($row != null) {
            $id_usr = $row['ID_USR'];
            $id_pic = $row['ID_PHOTO'];
            $nom = $row['NOM_USR'];
            $pass = $row['PASS'];
            $coordx_usr = $row['COORDX_USR'];
            $coordy_usr = $row['COORDY_USR'];
            $note = $row['NOTE_USR'];
            $ptroc = $row['PTROC_USR'];
            $o = new User($id_usr, $id_pic, $nom, $pass, $coordx_usr, $coordy_usr, $note, $ptroc);
        } else {
            echo "get_usr_by_id n'a pas trouvé";
            $o = null;
        }
        return $o;
    }

    public static function see_com_of_id($id) {
        $query = "Select * from commentaire where id_usr = :id";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur informations invalides" . oci_error($conn));
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);

        $com = array();
        while ($row = oci_fetch_assoc($stmt)) {
            $com[] = array($row['ID_NOTEUR'], $row['COMM'], $row['NOTE_COM'], $row['DATE_COM']);
        } 
            return $com;
    }

    public static function set_com_to_id($id_note, $id_notant, $com, $note) {
        $query = "INSERT INTO COMMENTAIRE VALUES (seqcom.nextval, :id_note, :id_notant, null, :com , :note, default)";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur informations invalides" . oci_error($conn));
        oci_bind_by_name($stmt, ":id_note", $id_note);
        oci_bind_by_name($stmt, ":id_notant", $id_notant);
        oci_bind_by_name($stmt, ":com", $com);
        oci_bind_by_name($stmt, ":note", $note);
        oci_execute($stmt);

        return $com = array($id_notant, $id_note, $com, $note);
    }

    public static function get_photo_usr($photo) {
        $query = "select * from photo where id_photo=:photo";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur informations invalides" . oci_error($conn));
        oci_bind_by_name($stmt, ":photo", $photo);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);

        if ($row != null) {
            echo ("<div class='round' style='position : absolute; margin : -65px 0 0 300px'> <img src='" . BASEURL . "/" . $row['PATH_PHOTO'] . "' />");
        }
    }

    public static function set_photo_usr($photo, $path) {
        $query = "insert into photo values (:photo, :path)";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur informations invalides" . oci_error($conn));
        oci_bind_by_name($stmt, ":photo", $photo);
        oci_bind_by_name($stmt, ":path", $path);
        oci_execute($stmt);
        return;
    }

    public static function inscr_usr($nom, $mdp, $coordx, $coordy, $photo) {
        // d'abord la photo sinon erreur de FK_PHOTO chez usr 
        $id_usr = Model_Base::get_next_seq("sequsr");
        $id_photo = Model_Base::get_next_seq("seqphoto");
        User::set_photo_usr($id_photo, $photo);
        
        $hash = hash('md2',$mdp);
        $query = "INSERT INTO usr VALUES (sequsr.currval,seqphoto.currval,:nom,:coordx,:coordy,3,0,:mdp)";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("oci_parse inscr_usr - insert error" . oci_error($conn));
        oci_bind_by_name($stmt, ":nom", $nom);
        oci_bind_by_name($stmt, ":coordx", $coordx);
        oci_bind_by_name($stmt, ":coordy", $coordy);
        oci_bind_by_name($stmt, ":mdp", $hash);
        oci_execute($stmt);

        return new User($id_usr, $id_photo, $nom, $mdp, $coordx, $coordy, null, 0);
    }

}
