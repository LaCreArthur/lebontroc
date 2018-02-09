Liste des objets :
<ul>
    <?php $i = 0; foreach ($array_obj as $obj) {
        $i++; 
        $usr = User::get_usr_by_id($obj->id_usr());
        if ($usr->nom() === $_SESSION['nom']) continue; ?>
        

        <li>Nom : <?php echo $obj->nom(); if ((Object::bonneaffaire($obj->id())) > 0) echo " <blink style=' text-decoration: blink; color:red ';>/!\\ Bonne affaire !!! </blink>" ; ?>
            <ul>
                <li>Propriétaire : <a href="<?= BASEURL ?>/index.php/other/<?= $usr->id_usr()?>"><?= $usr->nom()?> </a></li>
                <li>Descriptif : <?= $obj->descriptif() ?></li>
                <li>Valeur : <?= $obj->valeur() ?></li>
                <li>Etat : <?= $obj->etat() ?></li>
                <li>Categorie : <?= Object::get_cat_name($obj->cat()) ?></li> 
                <li>Photo(s):  <?= Object::get_photo_obj($obj->id())?></li>
                <form action="<?=BASEURL?>/index/prop_form" methode="post"> <label for="obj<?=$i?>"></label> 
                    <button type="submit" id="obj<?=$i?>" name="obj<?=$i?>" value="<?= $obj->id() ?>" class="btn_submit" style="margin: -40px"> Faire une proposition !</button> </form>
            </ul></li>
    <?php } ?>    
</ul>