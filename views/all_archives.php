Liste des archives :
<ul>
    <?php foreach ($array_arch as $obj) { ?>

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
                <li>prix_fin : <?= $obj->prix_fin() ?></li>
            </ul></li>
    <?php } ?>    
</ul>
