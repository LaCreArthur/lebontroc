Information du compte :

<ul>
    <li>Id : <?= $usr->id_usr() ?></li>
    <li>Photo : <?= User::get_photo_usr($usr->id_pic()) ?></li>
    <li>Nom : <?= $usr->nom() ?></li>
<!--    <li>Mot de passe :  ?></li>  PAS LE MOT DE PASSE VOYONS -->
    <li>Coordonnées : 
        <ul>
            <li>X :<?= $usr->coordx_usr() ?> </li>
            <li>Y :<?= $usr->coordy_usr() ?> </li>
        </ul>
    <li>Note : <?= $usr->note() ?></li>
    <li>Point Troc : <?= $usr->ptroc() ?></li>
</ul>
<style>
    .rating {
        unicode-bidi: bidi-override;
        direction: rtl;
        text-align: center;
    }
    .rating > span {
        display: inline-block;
        position: relative;
        width: 1.1em;
    }
    .rating > span:hover,
    .rating > span:hover ~ span {
        color: transparent;
    }
    .rating > span:hover:before,
    .rating > span:hover ~ span:before {
        content: "\2605";
        position: absolute;
        left: 0;
        color: gold;
    }
</style>
<button type='button' style="margin-left: 40%" onclick="javascript:openDialog();">Commenter l'utilisateur</button>
<aside id="default-popupCoordUsr" class="avgrund-popup">
    <button type='button' id="close_inscr" class="button" onclick="javascript:closeDialog();">X</button>
    <form action="<?= BASEURL ?>/index.php/valid_com_usr" method="post" id="com_form">
    <div align="center" style="width: 100%; height: 85%;">
            <label for="com" >Commentaire : </label>
            <textarea name="com" id="com" cols="40" rows="5" maxlength="255" placeholder="Contenu du commentaire : (Max 255 c.)" style="width:100%;height:auto;resize:none;"></textarea>
            <span>Note :</span><label for="note" ></label><input type="text" name="note" id="note" value='3' style="width:8%"/>
            <div class="rating" style="font-size: 1.6em">
                <span onclick="javascript:$('#note').attr('value','5')">☆</span>
                <span onclick="javascript:$('#note').attr('value','4')">☆</span>
                <span onclick="javascript:$('#note').attr('value','3')">☆</span>
                <span onclick="javascript:$('#note').attr('value','2')">☆</span>
                <span onclick="javascript:$('#note').attr('value','1')">☆</span>
            </div>
    </div>
    <button type="submit" class="btn_submit" >Envoyer </button>
    <label for="id_note" ></label>
    <input type="text" name="id_note" id="id_note" value="<?= $usr->id_usr()?>" style="visibility: hidden"/>
    </form>
</aside>

