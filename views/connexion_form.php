</div>
<aside id="connect-popup" class="avgrund-popup">

    <button id="close_form_obj" class="button" type='button' onclick="javascript:closeDialog();">X</button>

    <form action="<?= BASEURL ?>/index.php/valid_connect" method="post" style="margin-top: -10px;">
        <h2 style="margin: -57px 60px 55px;"> Connexion </h2>
        <p><label for="user_nom"></label><input type="text" placeholder="Nom :" name="nom" id="user_nom" size="25" /></p>

        <p><label for="user_pass"></label><input type="password" placeholder="Mot de passe :" name="password" id="user_pass" size="25" /></p>

        <p><a href="<?= BASEURL ?>/index.php/not_done_yet"> Mot de passe oublié ?</a></p>
        <br>
        <p><button class="btn_submit" type="submit">Envoyer </button></p>
    </form>

</aside>
<div class="avgrund-contents"> 