<script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAAjOPFqihV1_SYO99k_Y5rXhQa37IpzKhZZwgwV_9FKdr5j0_u8BTN9HS8BOm68VQ0JxzTKirhSarGYg" type="text/javascript"></script>
<script src="http://turing.u-strasbg.fr/~ascheidel/js/dragzoom.js" type="text/javascript"></script>
<style onLoad="load();"></style> 

 <form action="<?= BASEURL ?>/index.php/valid_proposition" method="post" id="prop_form">
    <?php $objprop = Object::get_by_id($idobj); ?>
    <div class="avgrund-contents" >
       
        <!-- type='button' pour ne pas fermer le formulaire -->
        <p style="text-align: center"> Faire une proposition a propos de : <?= $objprop->nom() ?>
            <br> Vous pouvez Rajouter des Ptroc au prix de depart si l'objet/le service pour être accepter en priorité
            <br> Vous pouvez demander a se que le vendeur rajoute des Ptroc si vous trouver l'objet/le service trop chere
            <br> Si vous voulez, vous pouvez aussi rajouter et/ou demander le rajout d'un(de plusieurs) objet(s)/service(s) !
        </p>
        <label for="ptroc_acheteur"></label>Rajout de votre par :<input type="number" name="ptroc_acheteur" id="ptroc_acheteur" value="0" min="0"/>
        <p></p>
        <label for="ptroc_vendeur"></label>Rajout de la part du vendeur :<input type="number" name="ptroc_vendeur" id="ptroc_vendeur" value="0" min="0" />
        <p></p>
        <button type='button'  onclick="javascript:openDialog1();">Ajouter un/des objet(s)/service(s) a vous</button>
        <p></p>
        <button type='button'  onclick="javascript:openDialog2();">Demander l'ajout d'objet(s)/service(s) du vendeur</button>
        <p></p>
        <button type='button'  onclick="javascript:openDialog();">Coordonn&eacute;es du rendez-vous</button>
        <p></p>
        <label for="coordx" > X:</label>
        <input type="text" name="coordx" id="user_coordx" style="width:200px"/>
        <p></p>
        <label for="coordy" > Y:</label>
        <input type="text" name="coordy" id="user_coordy" style="width:200px"/>        
        <p></p>
        <label for="date" > Date du rendez-vous :</label>
        <input type="datetime" name="date" id="date" style="width:200px"/>
        <label for="vendeur" ></label>
        <input type="text" name="vendeur" id="vendeur" value="<?= $objprop->id_usr() ?>" style="visibility: hidden"/>
        <label for="objprop" ></label>
        <input type="text" name="objprop" id="objprop" value="<?= $objprop->id() ?>" style="visibility: hidden"/>
        <p></p>
        <button type="submit" class="btn_submit" style="margin-left: 5%">Envoyer </button>    

    </div>

    <!--modal box de la map-->
    <aside id="default-popupCoordRdv" class="avgrund-popup" style="width: 480px;height: 400px;margin-top: -180px;">
        <button type='button' id="close_inscr" class="button" onclick="javascript:closeDialog();">X</button>
        <div id="map2" align="center" style="width: 100%; height: 85%;"></div>
        <button type='button' class="btn_submit" onclick="javascript:closeDialog();" >Valider</button>
    </aside>

    <!--modal box d'ajout acheteur-->
    <aside id="popup_acheteur" class="avgrund-popup">
        <button type='button' id="close_inscr" class="button" onclick="javascript:closeDialog();">X</button>
        <?php $my_obj = Object::get_my_all($_SESSION['id']); ?>
        <ul>
            <?php foreach ($my_obj as $obj) {
                ?>
                <label for="<?= $obj->id() ?>" ></label>

                <input type="checkbox" name="<?= $obj->id() ?>" id="<?= $obj->id() ?>">Nom : <?php echo $obj->nom();
            if ((Object::bonneaffaire($obj->id())) > 0)
                echo " <blink style=' text-decoration: blink; color:red ';>/!\\ Bonne affaire !!! </blink>";
            ?>
                <ul>
                    <li>Descriptif : <?= $obj->descriptif() ?></li>
                    <li>Valeur : <?= $obj->valeur() ?></li>
                    <li>Etat : <?= $obj->etat() ?></li>
                </ul>
        <?php } ?>    
        </ul>
        <button type='button' class="btn_submit" onclick="javascript:closeDialog();" >Valider</button>
    </aside>

    <!--modal box d'ajout vendeur-->
    <aside id="popup_vendeur" class="avgrund-popup">
        <button type='button' id="close_inscr" class="button" onclick="javascript:closeDialog();">X</button>
            <?php $vendeur_obj = Object::get_my_all($objprop->id_usr()); ?>
        <ul>
    <?php foreach ($vendeur_obj as $obj1) {
    if ($obj1 != $objprop) {
        ?>
                    <label for="<?= $obj1->id() ?>" ></label>

                    <input type="checkbox" name="<?= $obj1->id() ?>" id="<?= $obj1->id() ?>">Nom : <?php echo $obj1->nom();
            if ((Object::bonneaffaire($obj1->id())) > 0)
                echo " <blink style=' text-decoration: blink; color:red ';>/!\\ Bonne affaire !!! </blink>";
            ?>
                    <ul>
                        <li>Descriptif : <?= $obj1->descriptif() ?></li>
                        <li>Valeur : <?= $obj1->valeur() ?></li>
                        <li>Etat : <?= $obj1->etat() ?></li>
                    </ul>
    <?php } } ?>    
        </ul>
        <button type='button' class="btn_submit" onclick="javascript:closeDialog();" >Valider</button>
</aside>
 </form>