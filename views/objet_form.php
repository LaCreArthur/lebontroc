<script type="text/javascript">
    // pour afficher l'image dans round et pour pouvoir la modifier
    // pour que l'image ne soit pas deformer il faut la passer dans backgroundImage d'une div
    function readURL1(input) {
        if (input.files && input.files[0]) {
            var reader1 = new FileReader();
            reader1.onload = function (e) {
                $('#usrpic1')
                        .attr('src', e.target.result);
            };
            reader1.readAsDataURL(input.files[0]);
            $("#picbutton1").replaceWith("<img id='usrpic1' src='#' onclick=\"$('#img1').click();\"/>");
        }
    }
    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader2 = new FileReader();
            reader2.onload = function (e) {
                $('#usrpic2')
                        .attr('src', e.target.result);
            };
            reader2.readAsDataURL(input.files[0]);
            $("#picbutton2").replaceWith("<img id='usrpic2' src='#' onclick=\"$('#img2').click();\"/>");
        }
    }
    function readURL3(input) {
        if (input.files && input.files[0]) {
            var reader3 = new FileReader();
            reader3.onload = function (e) {
                $('#usrpic3')
                        .attr('src', e.target.result);
            };
            reader3.readAsDataURL(input.files[0]);
            $("#picbutton3").replaceWith("<img id='usrpic3' src='#' onclick=\"$('#img3').click();\"/>");
        }
    }

</script>


<h2>Votre objet :</h2>
<p></p>
<form action="<?= BASEURL ?>/index.php/objet" method="post" enctype="multipart/form-data">
    <label for="obj_nom" ></label><input type="text" name="nom" id="obj_nom" placeholder="Nom : (Max 50 c.)" style=" width:100%"/>
    <label for="obj_desc"></label>
    <textarea name="desc" id="obj_desc" cols="40" rows="5" maxlength="255" placeholder="Descriptif : (Max 255 c.)" style="width:100%;height:auto;resize:none;"></textarea>
    <label for="obj_value"></label><input type="number" name="val" id="obj_value" placeholder="Prix :" min="0" />

    <span>Etat :</span>
    <select name="etat" >
        <option value="Neuf">Neuf</option>
        <option value="Bon etat">Bon etat</option>
        <option value="Abime">Abime</option>
    </select> 
    <span>Categorie :</span>
    <select name="cat" >
    <?php 
    $cats = Object::all_cat();
    foreach($cats as $c) {
       if($c[1] == 0) {
           echo "<option value=".$c[0]." style='background-color:grey'>".$c[2]."</option>" ;
           foreach($cats as $c1) {
               if($c1[1] == $c[0]) {
                   echo "<option value=".$c1[0].">".$c1[2]."</option>" ;
               }
           }
       }
    }
    ?>
    </select> 
    
    <p> Ajouter de une a trois photo(s)</p>
    <label for="img1"></label>
    <input id="img1" type='file' name="1" onchange="readURL1(this);" />
    <div class='round' style='margin : -10px 0 0 0px'>
        <img id='usrpic1' src='<?= BASEURL ?>/uploads/obj/default.jpeg'  onclick="$('#img1').click();"/>
    </div>

    <label for="img2"></label>
    <input id="img2" type='file' name="2" onchange="readURL2(this);" />
    <div class='round' style='margin : -10px 0 0 10px'>
        <img id='usrpic2' src='<?= BASEURL ?>/uploads/obj/default.jpeg' onclick="$('#img2').click();"/>
    </div>

    <label for="img3"></label>
    <input id="img3" type='file' name="3" onchange="readURL3(this);" />
    <div class='round' style='margin : -10px 0 0 10px'>
        <img id='usrpic3' src='<?= BASEURL ?>/uploads/obj/default.jpeg' onclick="$('#img3').click();"/>
    </div>

    <p></p>
    <div style="margin: 200px 0px -70px 400px; position: relative;">
    <button type="submit" class="btn_submit" onclick="javascript:closeDialog();">Envoyer </button>
    </div>
    
</form>
