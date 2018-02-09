Liste des propositions .. <br>
Les propositions de moins d'un mois qui sont déja validées sont encore visibles
<ul>
    <?php
    // 2 booleens pour afficher une seul fois le message de qui sont les propositions (car elles sont triées)
    $bool1 = FALSE;
    $bool2 = FALSE;
    foreach ($myprops as $obj) {
        if ((User::get_usr_by_id($obj->id_usr())->nom() === $_SESSION['nom']) && (!$bool1)) {
            $bool1 = TRUE;
            echo "<li>.. sur mes objets : </li>";
        } else if ((User::get_usr_by_id($obj->id_acheteur())->nom() === $_SESSION['nom']) && (!$bool2)) {
            $bool2 = TRUE;
            echo "<li>.. que j'ai faite : </li>";
        }
        ?>

        <br>
        <ul>
            <li><?= $obj->id() ?> : <?php
                if ($obj->accepter() == 1) {
                    echo"<blink style=' text-decoration: blink; color:red ';>Proposition déja acceptée</blink>";
                }
                ?> 
                <ul>
                    <li>Demandeur : <?php echo User::get_usr_by_id($obj->id_acheteur())->nom(); ?></li>
                    <li>Proposeur : <?php echo User::get_usr_by_id($obj->id_usr())->nom(); ?></li>
                    <li>Vous ajouter : <?= $obj->ptroc_acheteur() ?> Ptroc(s)</li>
                    <li>Vous demandez : <?= $obj->ptroc_usr() ?> Ptroc(s)</li>
                    
                    <!--on n'affiche le reste que si la proposition n'est pas deja acceptee-->
                        <?php if ($obj->accepter() == 0) { ?>
                        <li>date du rendez-vous: <?= $obj->date() ?></li> 
                        <li>coord x : <?= $obj->coordx() ?></li>
                        <li>coord y : <?= $obj->coordy() ?></li>
                        <?php
                        $objprop = Proposition::get_obj_by_propid($obj->id());
                        echo "<ul>Objet(s) dans la proposition :";
                        foreach ($objprop as $op) {
                            ?>
                            <li> <?php echo Object::get_by_id($op[0])->nom(); ?> </li>
        <?php } echo"</ul>"; ?>
        <?php if (!$bool2 && $bool1) { ?> 
                            <form action="<?= BASEURL ?>/index.php/accept_prop" method="post" style="margin:-50px 0px 0px -60px; padding:0;">
                                <p><label for="prop_id"></label><input type="text" name="prop_id" id="prop_id" style="visibility : hidden" value="<?= $obj->id() ?>" /></p>
                                <button class="btn_submit" type="submit">Acceptez la proposititon </button>
                                <i>Attention : entrainera le refus des autres proposition faites sur le(s) meme(s) objet(s)</i>
                            </form>
                            <br>
        <?php } ?>
    <?php } ?>  
                </ul>
        </ul>
    </li>
<?php } ?>
</ul>


