Information sur l'objet :

<ul>
    <li>Id : <?= $obj->id() ?></li>
    <li>Nom : <?= $obj->nom() ?></li>
    <li>Propriétaire : <?php echo User::get_usr_by_id($obj->id_usr())->nom(); ?></li>
    <li>Descriptif : <?= $obj->descriptif() ?></li>
    <li>Valeur : <?= $obj->valeur() ?></li>
    <li>Etat : <?= $obj->etat() ?></li>
    <li>Categorie : <?= $obj->cat() ?></li>
    <li>Photo(s):  <?= Object::get_photo_obj($obj->id())?></li>
</ul>