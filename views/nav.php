
<nav>
    <ul>
<!--        <li><a href="<?= BASEURL ?>/index.php">Page principale</a></li>-->
        <?php if (isset($_SESSION['connect'])) { ?><li><a href="<?= BASEURL ?>/index.php/objet_form">Ajout d'un objet</a></li> 
        <?php } ?>
        <li><a href="<?= BASEURL ?>/index.php/all_object">Liste des objets</a></li>
        <?php if (!isset($_SESSION['connect'])) { ?> 
            <li id="signin"><a href="<?= BASEURL ?>/index.php/inscription">Pas encore inscrit ?</a></li>
            <li><button id="btnconnex" onclick="javascript:openconnect();">Connexion</button><?php include 'views/connexion_form.php'; ?></li>
        <?php } ?>
            
        <?php if (isset($_SESSION['connect'])) { ?>  
            <?php if ($_SESSION['nom'] == "admin") { ?>
                <li><a href="<?= BASEURL ?>/index.php/propositions">Propositions</a></li> 
                <li><a href="<?= BASEURL ?>/index.php/archives">Archives</a></li> 
            <?php } ?>
            <li><a href="<?= BASEURL ?>/index.php/myprops">Mes propositions</a></li>   
            <li><a href="<?= BASEURL ?>/index.php/myobj">Mes echanges</a></li>  
            <li><a href="<?= BASEURL ?>/index.php/user"><? echo $_SESSION['nom']?></a></li> 
            <li><a href="<?= BASEURL ?>/index.php/deconnexion">Déconnexion</a></li>
           
        <?php } ?>
    </ul>
</nav>