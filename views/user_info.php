Information de votre compte :
<br><br><br>
<ul>
    <li>Id : <?= $usr->id_usr() ?></li>
    <li>Photo : <?= User::get_photo_usr($usr->id_pic()) ?></li>
    <li>Nom : <?= $usr->nom() ?></li>
<!--    <li>Mot de passe : <?php //$usr->pass() ?></li>-->
    <li>Coordonnées : 
        <ul>
            <li>X :<?= $usr->coordx_usr() ?> </li>
            <li>Y :<?= $usr->coordy_usr() ?> </li>
        </ul>
    <li>Note : <?= $usr->note() ?></li>
    <li>Point Troc : <?= $usr->ptroc() ?></li>
</ul>

<p style="text-align: center "> Mes commentaire :
    <?php
    $com = User::see_com_of_id($_SESSION['id']);
    foreach ($com as $c) {
        echo "<ul> l'utilisateur : " . User::get_usr_by_id($c[0])->nom() . " a ecrit :";
        echo "<li style='
        border-style: solid;
        border-width: 1px;
        margin: 0px 400px 0px 0px;
        display : block;
        padding: 0px 2px 2px 2px;'>" . $c[1] . "</li>"
        . "<li>il vous a noté : " . $c[2] . " etoiles</li>";
        echo "<li> date : " . $c[3] . "</li><ul><br>";
    }
    ?>
</p>