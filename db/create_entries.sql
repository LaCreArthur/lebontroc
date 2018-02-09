insert into photo values (0,'/uploads/usr/default.jpeg');
insert into photo values (1,'/uploads/obj/default.jpeg');

INSERT INTO categorie VALUES ( 0, NULL, 'Toutes categories');
INSERT INTO categorie VALUES ( seqcat.nextval, NULL, 'Vehicules');
INSERT INTO categorie VALUES ( seqcat.nextval, NULL, 'Multimedia');
INSERT INTO categorie VALUES ( seqcat.nextval, NULL, 'Maison');
INSERT INTO categorie VALUES ( seqcat.nextval, NULL, 'Loisirs');
INSERT INTO categorie VALUES ( seqcat.nextval, NULL, 'Services');
INSERT INTO categorie VALUES ( seqcat.nextval, NULL, 'Autres');

INSERT INTO categorie VALUES ( seqcat.nextval, 1, 'Voiture');
INSERT INTO categorie VALUES ( seqcat.nextval, 1, 'Camion');
INSERT INTO categorie VALUES ( seqcat.nextval, 1, 'Ovni');
INSERT INTO categorie VALUES ( seqcat.nextval, 2, 'Informatique');
INSERT INTO categorie VALUES ( seqcat.nextval, 2, 'Jeux-video electronique');
INSERT INTO categorie VALUES ( seqcat.nextval, 2, 'Audio-Visuel ViruelSound fx4000');
INSERT INTO categorie VALUES ( seqcat.nextval, 3, 'Canapee');
INSERT INTO categorie VALUES ( seqcat.nextval, 3, 'Fauteille');
INSERT INTO categorie VALUES ( seqcat.nextval, 3, 'Lit');
INSERT INTO categorie VALUES ( seqcat.nextval, 4, 'DVD/CD');
INSERT INTO categorie VALUES ( seqcat.nextval, 4, 'Dinausores');
INSERT INTO categorie VALUES ( seqcat.nextval, 4, 'Jeux trop bien');
INSERT INTO categorie VALUES ( seqcat.nextval, 5, 'Ufologie');
INSERT INTO categorie VALUES ( seqcat.nextval, 5, 'Reunion anonyme');
INSERT INTO categorie VALUES ( seqcat.nextval, 5, 'Cours particuliers');

INSERT INTO usr VALUES ( 1, 0,'admin', 48.5608, 7.7629, 5, 0,'3e3e6b0e5c1c68644fc5ce3cf060211d');
INSERT INTO usr VALUES ( 2, 0,'jeanguy', 47.9883, 6.9628, 5, 0,'bf9457b3748d91317779826ce026ba1e');
INSERT INTO usr VALUES ( 3, 0,'barnabe', 49.1655, 8.2678, 3, 0,'0acf7828b8a05ace732412c6408f47eb');

-- test deux obj dans la meme prop
insert into objet values (seqobjet.nextval, 2, 0,'bon','premier objet sur le site','Neuf', 10, 0, 0);
insert into proposition values (seqprop.nextval,3,2, 0,0,48.662544, 7.832544,'01-NOV-2014',0);
insert into recoit_une values(seqobjet.currval, seqprop.currval);
insert into objet values (seqobjet.nextval, 1, 0,'bon','objet de ladmin sur le site','Neuf', 5, 0, 0);
insert into recoit_une values(seqobjet.currval, seqprop.currval);
update proposition set accepter = 1 where id_prop  = 2;
-- ok

-- ajout de plusieur obj du meme nom pour tester "bonne affaire"
insert into objet values (seqobjet.nextval, 3, 0,'bon','deuxieme objet sur le site','Neuf', 15, 0, 0);
insert into proposition values (seqprop.nextval,2,3, 0,0,47.662544, 7.832544,'01-NOV-2014',0);
insert into recoit_une values(seqobjet.currval, seqprop.currval);
update proposition set accepter = 1 where id_prop  = 3;


insert into objet values (seqobjet.nextval, 3, 0,'bon','troisieme objet sur le site','Neuf', 20, 0, 0);
insert into proposition values (seqprop.nextval,2,3, 0,0,49.662544, 7.832544,'01-NOV-2014',0);
insert into recoit_une values(seqobjet.currval, seqprop.currval);
update proposition set accepter = 1 where id_prop  = 4;


-- test d'archivage de prop refusee
insert into objet values (seqobjet.nextval, 3, 0,'bon','quatrieme objet sur le site','Neuf', 10, 0, 0); 
-- est une bonne affaire
insert into proposition values (seqprop.nextval,2,3, 0,0,50.662544, 7.832544,'01-NOV-2014',0);
 -- prop refusee
insert into recoit_une values(seqobjet.currval, seqprop.currval);
insert into proposition values (seqprop.nextval,1,3, 0,0,51.662544, 7.832544,'02-NOV-2014',0);
insert into recoit_une values(seqobjet.currval, seqprop.currval);
update proposition set accepter = 1 where id_prop  = 6;
-- ok 


-- test d'evaluation pour tester utilisateur de confiance
INSERT INTO COMMENTAIRE VALUES (seqcom.nextval, 3,1,null, 'com d admin sur barnabe', 4, default);
INSERT INTO COMMENTAIRE VALUES (seqcom.nextval, 3,2,null, 'com de jeanguy sur barnabe', 5, default);
INSERT INTO COMMENTAIRE VALUES (seqcom.nextval, 2,3,null, 'com de barnabe sur jeanguy trop de swag', 5, default);
-- ok


-- teste un service avec plusieurs places
insert into objet values (seqobjet.nextval, 2, 0,'service','premier service sur le site',default, 10, 3, 0);
insert into proposition values (seqprop.nextval,3,2, 0,0,52.662544, 7.832544,'03-NOV-2014',0);
insert into recoit_une values(seqobjet.currval, seqprop.currval);
insert into proposition values (seqprop.nextval,1,2, 0,0,53.662544, 7.832544,'04-NOV-2014',0);
insert into recoit_une values(seqobjet.currval, seqprop.currval);
update proposition set accepter = 1 where id_prop  = 7;
update proposition set accepter = 1 where id_prop  = 8;
insert into proposition values (seqprop.nextval,1,2, 0,0,54.662544, 7.832544,'05-NOV-2014',0);
insert into recoit_une values(seqobjet.currval, seqprop.currval);
update proposition set accepter = 1 where id_prop  = 9; 
-- plus de place, archivage ok

insert into objet values (seqobjet.nextval, 3, 0,'bon','Un bon pour une bonne affaire ! (test de bonne affaire)','Neuf', 10, 0, 0);
insert into objet values (seqobjet.nextval, 2, 0,'Du swag','Jean guy Swag propose du swag parce quil en a trop','Abime', 150, 0, 0); 
insert into objet values (seqobjet.nextval, 2, 0,'Un cartable hello kitty','le top du swag','Neuf', 99, 0, 0); 
insert into objet values (seqobjet.nextval, 3, 0,'Une casquette a helice','Je lechange contre un jeux video electronique virtuel !','Neuf', 10, 0, 0);
