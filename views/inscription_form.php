<!--script reprit de http://www.afleurdepau.com/Cadeaux/coordonnees/coordonnees-google-maps.htm, modifié et adapté.-->
<script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAAjOPFqihV1_SYO99k_Y5rXhQa37IpzKhZZwgwV_9FKdr5j0_u8BTN9HS8BOm68VQ0JxzTKirhSarGYg" type="text/javascript"></script>
<script src="http://turing.u-strasbg.fr/~ascheidel/js/dragzoom.js" type="text/javascript"></script>
<script type="text/javascript">
    // pour afficher l'image dans round et pour pouvoir la modifier
    // pour que l'image ne soit pas deformer il faut la passer dans backgroundImage d'une div
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#usrpic')
                        .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
            $("#picbutton").replaceWith("<div class='round'><img id='usrpic' src='#' onclick=\"$('#img').click();\"/></div> ");
        }
    }
</script>

<style onLoad="load();"></style> 

<div class="avgrund-contents" >
    <!-- type='button' pour ne pas fermer le formulaire -->
    <form action="<?= BASEURL ?>/index.php/valid_inscription" method="post" id="inscr_form" enctype="multipart/form-data">

        <label for="user_nom" style="margin-left: 35.2%">Nom : </label>
        <input type="text" name="nom" id="user_nom" placeholder=" Max 50 c."/><p></p>
        <label for="user_pass" style="margin-left: 32%">Password : </label>
        <input type="password" name="password" id="user_pass" placeholder=" Max 50 c." /><p></p>

        <button type='button' style="margin-left: 40%" onclick="javascript:openDialog();">Ajouter coordonn&eacute;es</button>
        <p></p>
        <label for="coordx" style="margin-left: 38%"> X:</label>
        <input type="text" name="coordx" id="user_coordx" style="width:200px"/>
        <p></p>
        <label for="coordy" style="margin-left: 38.2%"> Y:</label>
        <input type="text" name="coordy" id="user_coordy" style="width:200px"/>

        <label for="img"></label>
        <input id="img" type='file' name="img" onchange="readURL(this);" style="visibility:hidden"/>
        <p></p>
        <button id='picbutton' type='button' style="float:left; margin: -15.5% 0 0 60%" onclick="$('#img').click();">Ajouter une photo</button>
        <p></p>
        <button type="submit" class="btn_submit" style="margin-left: 40%">Envoyer </button>

    </form></div>

<!--modal box de la map-->
<aside id="default-popupCoordUsr" class="avgrund-popup">
    <button type='button' id="close_inscr" class="button" onclick="javascript:closeDialog();">X</button>
    <div id="map2" align="center" style="width: 100%; height: 85%;"></div>
    <button type='button' class="btn_submit" onclick="javascript:closeDialog();" >Valider</button>
</aside>
