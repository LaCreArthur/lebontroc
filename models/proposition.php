<?php

require_once 'models/model_base.php';

class Proposition extends Model_Base {

    private $_id;
    private $_id_acheteur;
    private $_id_usr;
    private $_ptroc_acheteur;
    private $_accepter;
    private $_date_rdv;
    private $_coordx;
    private $_coordy;
    private $_ptroc_usr;
    private $_prix_fin;

    public function __construct($id, $id_acheteur, $id_usr, $ptroc_acheteur, $accepter, $date_rdv, $coordx, $coordy, $ptroc_usr, $prix_fin) {
        $this->_id = $id;
        $this->_id_acheteur = $id_acheteur;
        $this->_id_usr = $id_usr;
        $this->_ptroc_acheteur = $ptroc_acheteur;
        $this->_accepter = $accepter;
        $this->_date_rdv = $date_rdv;
        $this->_coordx = $coordx;
        $this->_coordy = $coordy;
        $this->_ptroc_usr = $ptroc_usr;
        $this->_prix_fin = $prix_fin;
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

    public function id_acheteur() {
        return $this->_id_acheteur;
    }

    public function set_id_acheteur($id) {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id_acheteur = $id;
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

    public function ptroc_acheteur() {
        return $this->_ptroc_acheteur;
    }

    public function set_ptroc_acheteur() {
        $pta = (int) $pta;
        if ($pta > 0) {
            $this->_ptroc_usr = $pta;
        }
    }

    public function accepter() {
        return $this->_accepter;
    }

    public function set_accepter($a) {
        $this->_accepter = $a;
    }

    public function date() {
        return $this->_date_rdv;
    }

    public function set_date($d) {
        $this->_date_rdv = $d;
    }

    public function coordx() {
        return $this->_coordx;
    }

    public function set_coordx($cx) {
        $this->_coordx = $cx;
    }

    public function coordy() {
        return $this->_coordy;
    }

    public function set_coordy($cy) {
        $this->_coordy = $cy;
    }

    public function ptroc_usr() {
        return $this->_ptroc_usr;
    }

    public function set_ptroc_usr() {
        $ptu = (int) $ptu;
        if ($ptu > 0) {
            $this->_ptroc_usr = $ptu;
        }
    }

    public function prix_fin() {
        return $this->_prix_fin;
    }

    public function set_prix_fin() {
        $pf = (int) $pf;
        if ($pf > 0) {
            $this->_prix_fin = $pf;
        }
    }

    public static function get_all_p() {
        $query = "SELECT * FROM proposition";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion " . oci_error($conn));
        oci_execute($stmt);

        $array_prop = array();
        while ($row = oci_fetch_assoc($stmt)) {
            $id = $row['ID_PROP'];
            $id_acheteur = $row['ID_ACHETEUR'];
            $id_usr = $row['ID_USR'];
            $ptroc_acheteur = $row['PTROC_ACHETEUR'];
            $accepter = $row['ACCEPTER'];
            $coordx = $row['COORDX_RDV'];
            $coordy = $row['COORDY_RDV'];
            $date_rdv = $row['DATE_RDV'];
            $ptroc_usr = $row['PTROC_USR'];
            $array_prop[] = new Proposition($id, $id_acheteur, $id_usr, $ptroc_acheteur, $accepter, $date_rdv, $coordx, $coordy, $ptroc_usr, 0);
        }
        return $array_prop;
    }

    public static function get_p_by_usrid($id) {
        $query = "SELECT * FROM proposition where id_usr = :id or id_acheteur = :id  order by id_acheteur, accepter asc";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion " . oci_error($conn));
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);

        $myprops = array();
        while ($row = oci_fetch_assoc($stmt)) {
            $id = $row['ID_PROP'];
            $id_acheteur = $row['ID_ACHETEUR'];
            $id_usr = $row['ID_USR'];
            $ptroc_acheteur = $row['PTROC_ACHETEUR'];
            $accepter = $row['ACCEPTER'];
            $coordx = $row['COORDX_RDV'];
            $coordy = $row['COORDY_RDV'];
            $date_rdv = $row['DATE_RDV'];
            $ptroc_usr = $row['PTROC_USR'];
            $myprops[] = new Proposition($id, $id_acheteur, $id_usr, $ptroc_acheteur, $accepter, $date_rdv, $coordx, $coordy, $ptroc_usr, 0);
        }
        return $myprops;
    }

    // NOT USED ??
    public static function get_obj_by_propid($id) {
        $query = "SELECT * FROM recoit_une where id_prop = :id";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur get_obj_by_propid " . oci_error($conn));
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);

        $objets = array();
        $i = 0;
        while ($row = oci_fetch_assoc($stmt)) {
            $objets[$i] = array($row['ID_OBJ'], $row['ID_PROP']);
            $i++;
        }
        return $objets;
    }

    public static function create_prop($id_acheteur, $id_usr, $ptroc_acheteur, $coordx, $coordy, $date_rdv, $ptroc_usr) {
        $query = "INSERT INTO proposition VALUES (seqprop.nextval,:id_acheteur,:id_usr,:ptroc_acheteur,0,:coordx,:coordy,:date_rdv,:ptroc_usr)";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur create_prop " . oci_error($conn));
        oci_bind_by_name($stmt, ":id_acheteur", $id_acheteur);
        oci_bind_by_name($stmt, ":id_usr", $id_usr);
        oci_bind_by_name($stmt, ":ptroc_acheteur", $ptroc_acheteur);
        oci_bind_by_name($stmt, ":coordx", $coordx);
        oci_bind_by_name($stmt, ":coordy", $coordy);
        oci_bind_by_name($stmt, ":date_rdv", $date_rdv);
        oci_bind_by_name($stmt, ":ptroc_usr", $ptroc_usr);
        oci_execute($stmt);
        $id_prop = Model_base::get_seq("seqprop");
        return new Proposition($id_prop, $id_acheteur, $id_usr, $ptroc_acheteur, 0, $date_rdv, $coordx, $coordy, $ptroc_usr, 0);
    }

    public static function create_recoit($id_obj, $id_prop) {
        $query = "insert into recoit_une values(:id_obj, :id_prop)";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur create_recoit_une " . oci_error($conn));
        oci_bind_by_name($stmt, ":id_obj", $id_obj);
        oci_bind_by_name($stmt, ":id_prop", $id_prop);
        oci_execute($stmt);
        return 0;
    }

    public static function get_all_a() {
        $query = "SELECT * FROM archive";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur get_all_a " . oci_error($conn));
        oci_execute($stmt);

        $array_prop = array();
        while ($row = oci_fetch_assoc($stmt)) {
            $id = $row['ID_ARCHIVE'];
            $id_acheteur = $row['ID_ACHETEUR'];
            $id_usr = $row['ID_USR'];
            $ptroc_acheteur = $row['PTROC_ACHETEUR'];
            $accepter = $row['ACCEPTER'];
            $coordx = $row['COORDX_RDV'];
            $coordy = $row['COORDY_RDV'];
            $date_rdv = $row['DATE_RDV'];
            $ptroc_usr = $row['PTROC_USR'];
            $prix_fin = $row['PRIX_FIN'];
            $array_prop[] = new Proposition($id, $id_acheteur, $id_usr, $ptroc_acheteur, $accepter, $date_rdv, $coordx, $coordy, $ptroc_usr, $prix_fin);
        }
        return $array_prop;
    }

    public static function archive_prop() {
        $query = "begin archi_prop; end;";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("archive_prop insertion " . oci_error($conn));
        
        if ((oci_execute($stmt)) === TRUE)
            return TRUE;
        else
            return FALSE;
    }

    public static function acccept_prop_by_id($prop_id) {
        $query = "update proposition set accepter = 1 where id_prop  = :prop_id";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur acccept_prop_by_id " . oci_error($conn));
        oci_bind_by_name($stmt, ":prop_id", $prop_id);
        if ((oci_execute($stmt)) === TRUE)
            return TRUE;
        else
            return FALSE;
    }

}
