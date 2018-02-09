<form action="<?= BASEURL ?>/index.php/archive_prop" method="post" style="margin:50px 0px 10px 75px; padding:0;">
    <button class="btn_submit" type="submit">Archiver les proposititons acceptées </button>
</form>
Liste des propositions :
<ul>
    <?php foreach ($array_prop as $obj) { ?>

        <li>Id : <?= $obj->id() ?>
            <ul>
                <li>Acheteur : <?php echo User::get_usr_by_id($obj->id_acheteur())->nom(); ?></li>
                <li>Vendeur : <?php echo User::get_usr_by_id($obj->id_usr())->nom(); ?></li>
                <li>ptroc_acheteur : <?= $obj->ptroc_acheteur() ?></li>
                <li>ptroc_usr : <?= $obj->ptroc_usr() ?></li>
                <li>accepter : <?= $obj->accepter() ?></li>
                <li>date : <?= $obj->date() ?></li> 
                <li>coordx : <?= $obj->coordx() ?></li>
                <li>coordy : <?= $obj->coordy() ?></li>
            </ul></li>
    <?php } ?>    
</ul>
