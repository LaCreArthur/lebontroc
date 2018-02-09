Mes objets sur Lebontroc :
<ul>
    <?php foreach ($my_obj as $obj) {
        ?>

        <li>Nom : <?php echo $obj->nom(); if ((Object::bonneaffaire($obj->id())) > 0) echo " <blink style=' text-decoration: blink; color:red ';>/!\\ Bonne affaire !!! </blink>" ; ?>
            <ul>
                <li>Descriptif : <?= $obj->descriptif() ?></li>
                <li>Valeur : <?= $obj->valeur() ?></li>
                <li>Etat : <?= $obj->etat() ?></li>
               <li>Categorie : <?= Object::get_cat_name($obj->cat()) ?></li>
                <li>Photo(s):  <?= Object::get_photo_obj($obj->id())?></li>
            </ul></li>
    <?php } ?>    
</ul>