
<?php

class Model_Base {

    protected static $_db;

    public static function set_db() {
        $conn = oci_connect(SQL_USERNAME, SQL_PASSWORD, SQL_DSN) or die("Une erreur de connexion s'est produite.\n");
        self::$_db = $conn;
    }

    public static function close_db() {
        oci_close(self::$_db);
    }

    public function get_seq($seq) {

        $query = "select " . $seq . ".currval from dual";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("oci_parse get_seq - seq error" . oci_error($conn));
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
        $value = $row["CURRVAL"];
        return $value;
    }

    public function get_next_seq($seq) {

        $query = "select " . $seq . ".nextval from dual";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("oci_parse get_next_seq - seq error" . oci_error($conn));
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
        $value = $row["NEXTVAL"];
        return $value;
    }

    public function not_done_yet() {
        include 'views/not_done_yet.php';
    }

}
