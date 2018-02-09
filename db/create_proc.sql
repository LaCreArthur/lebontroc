-- Arthur Scheidel 
-- Projet : Procédures et fonctions PL/SQL
set serveroutput on

/*1.
Définir une fonction qui arrondit une coordonnée géographique en degré décimale 
à trois chiffres après la virgule, le troisième chiffre après la virgule 
pouvant être 0 ou 5. Par exemple, pour la coordonnée(65.546677, -14.128904), 
la fonction renverra (65.545, -14.130).*/

CREATE OR REPLACE TRIGGER coordusr
BEFORE INSERT ON usr
FOR EACH ROW
DECLARE
 reste_x number;
 reste_y number;
 tmpx 	 number;
 tmpy 	 number;
BEGIN
 tmpx := :new.COORDX_USR * 10000;
 tmpy := :new.COORDY_USR *10000;
 reste_x := mod(tmpx,100);
 reste_y := mod(tmpy,100);

 IF reste_x < 25 THEN
	:new.COORDX_USR := (tmpx - reste_x) / 10000;
 ELSIF reste_x < 75 THEN 
	:new.COORDX_USR := (tmpx - reste_x + 50) / 10000; 
 ELSE
	:new.COORDX_USR := (tmpx - reste_x + 100) / 10000;
 END IF;

IF reste_y < 25 THEN
	:new.COORDY_USR := (tmpy - reste_y) / 10000;
 ELSIF reste_y < 75 THEN
	:new.COORDY_USR := (tmpy - reste_y + 50) / 10000;
 ELSE
	:new.COORDY_USR := (tmpy - reste_y + 100) / 10000;
 END IF;
END;
/
show ERRORS

-- pour mettre a jour la note d'un usr quand on le commente
CREATE OR REPLACE TRIGGER moynote
after INSERT or update ON commentaire 
FOR EACH ROW
DECLARE
 note_v number;
BEGIN
 select note_usr into note_v 
 from usr 
 where usr.id_usr = :new.id_usr;
 note_v := (note_v + :new.note_com) / 2; -- changer ce calcul
 
 update usr set note_usr = note_v
		where usr.id_usr = :new.id_usr;
END;
/
show ERRORS


set serveroutput on
Create or replace function calcdist 
(	coordx1 number,
	coordy1 number,
	coordx2 number,
	coordy2 number
) return number is
	dphi number;
	dalpha number;
	phi number;
	rad number;
	d number;
	coordx1r number;
	coordy1r number;
	coordx2r number;
	coordy2r number;
begin
	rad := 3.14159265359 / 180;
	coordx1r := coordx1 * rad ;
	coordy1r := coordy1 * rad ;
	coordx2r := coordx2 * rad ;
	coordy2r := coordy2 * rad ;
	phi := (coordx1r + coordx2r) / 2;
	--dbms_output.put_line('phi : ' || to_char(phi));
	dphi := (abs(coordx1r) - abs(coordx2r)) ;
	IF dphi < 0 
	THEN dphi := (abs(coordx2r) - abs(coordx1r)) ;
	END IF;
	--dbms_output.put_line('dphi : ' || to_char(dphi));
	dalpha := (abs(coordy1r) - abs(coordy2r)) ;
	IF dalpha < 0 
	THEN dalpha := (abs(coordy2r) - abs(coordy1r)) ;
	END IF;
	--dbms_output.put_line('dalpha : ' || to_char(dalpha));
	d := 6371 * sqrt((dphi*dphi) + (((cos(phi) * dalpha)) * (cos(phi) * dalpha)));
	--dbms_output.put_line('distance : ' || to_char(d));
	RETURN d;
end;
/
show errors

--  pour retourner la liste des objets proche d'un objet et dans une categorie (package)
CREATE or REPLACE PACKAGE objproch_pkg is
	
	type objproch is record (nom_obj char(50),nom_usr char(50), coordx_usr number, coordy_usr number);
	TYPE objprochcur IS REF CURSOR RETURN objproch;
	function liObjProche(coordx number,coordy number,cat_v categorie.nom_cat%type, dist_v number) return objprochcur;
	
END;
/
show ERRORS
 -- body du package (fonction)
set serveroutput on
CREATE or REPLACE PACKAGE BODY objproch_pkg is
	
	function liObjProche
	(	coordx number,
		coordy number,
		cat_v categorie.nom_cat%type,
		dist_v number 
		) return objprochcur
	is
	obj_c objprochcur;
	begin
		open obj_c for
			select nom_obj, nom_usr, coordx_usr, coordy_usr
			from  objet natural join categorie natural join usr
			where nom_cat = cat_v and calcdist(coordx,coordy,coordx_usr,coordy_usr) < dist_v;
		return obj_c;
	end;
END;
/
show ERRORS

-- pour mettre vendu = 1 a l'objet de la prop acceptee 
CREATE OR REPLACE TRIGGER valid_prop
AFTER UPDATE 
	ON proposition
	FOR EACH ROW
DECLARE
	cursor obj_c is	
		select id_obj, id_usr, id_prop, service
		from objet natural join recoit_une;
        service_v integer;
BEGIN
        for obj_r in obj_c 
	loop
		if obj_r.id_prop = :new.id_prop 
		then
                        if obj_r.service > 0
			then
                                update objet 
				set service = service-1 
				where id_obj = obj_r.id_obj;				
                        end if;
                            -- pour mettre a jour les service qui n'ont plus de place ->
                        select service into service_v 
                        from objet 
                        where objet.id_obj = obj_r.id_obj;
                
                        if (obj_r.service = 0) or (service_v = 0)
                        then
                                update objet 
				set vendu = 1 
				where id_obj = obj_r.id_obj;
			end if;
			
		end if;
	end loop;
END;
/
show ERRORS


-- POUR ARCHIVER LES PROP
CREATE OR REPLACE procedure archi_prop
is
	bool integer;
	prix_fin_v number;
	id_vendeur_v integer;
	id_arch_v integer;
	
	cursor prop_c is
		select * from proposition natural join recoit_une; 
	
	cursor obj_c is
		select * from objet natural join recoit_une
		where vendu = 1;
BEGIN
	for prop_r in prop_c
	loop	
		id_vendeur_v := prop_r.id_usr;
		bool := 0;
		id_arch_v := 0;
		prix_fin_v := 0;
		for obj_r in obj_c
		loop
			if obj_r.id_prop = prop_r.id_prop
			then 
				bool := 1;

				if id_vendeur_v = obj_r.id_usr
				then -- l'objet est au vendeur donc sa valeur s'ajoute au prix final
					prix_fin_v := prix_fin_v + obj_r.prix_dep;
				else -- l'objet est a l'acheteur donc sa valeur se deduit au prix final
					prix_fin_v := prix_fin_v - obj_r.prix_dep;
				end if;
				
				if id_arch_v = 0 -- init l'id et ajoute une seul fois l'archive
				then 
					id_arch_v := seqarchive.nextval;
					insert into archive 
						VALUES (id_arch_v, 
						prop_r.ID_ACHETEUR, 
						prop_r.id_usr,
						prop_r.ptroc_acheteur,
						prop_r.ACCEPTER,
						prop_r.DATE_RDV,
						prop_r.COORDX_RDV,
						prop_r.COORDY_RDV,
						prop_r.PTROC_USR,
						(prix_fin_v + prop_r.PTROC_USR - prop_r.ptroc_acheteur));
						
						dbms_output.put_line('proposition '|| to_char(prop_r.id_prop) || ' est archivee');
                                        
                                        -- pour ajouter un ptroc a chaque usr qui valide un troc
                                        update usr set ptroc_usr = ptroc_usr + 1
                                        where usr.id_usr = prop_r.id_usr;
                                        dbms_output.put_line('un ptroc pour : '|| to_char(prop_r.id_usr));
				end if;
				
				-- reference les plusieurs obj concerne par la prop
				dbms_output.put_line('-- objet de la proposition : ' || to_char(obj_r.id_obj));
				insert into est_archive
				values (id_arch_v, obj_r.id_obj); 
			end if;
		end loop;
		if bool = 1
		then 
			delete from recoit_une
				where id_prop = prop_r.id_prop; 
			
			delete from proposition
				where id_prop = prop_r.id_prop;
		end if;
		
	end loop;
END;
/
show ERRORS


--UTILISATEUR DE CONFIANCE ( + de 20 ventes et note >= 4)
set serveroutput on
Create or replace function usrdeconf (usr_v usr.id_usr%type, nom_obj_v objet.nom_obj%type)
	return integer
	is
	nbdevente_v integer;
	bool integer;
	note_v number;
	nb_vente_v number;
Begin
	bool := 0;
	select count(*) into nbdevente_v 
	from objet 
	where usr_v = id_usr and vendu = 1;
	if nbdevente_v > 1 -- remplacer par 19  
	then 
		select note_usr into note_v from usr where id_usr = usr_v ;
		if note_v >= 4
		then 
			select max(prix_dep) into bool from objet where id_usr = usr_v and nom_obj = nom_obj_v;
			--dbms_output.put_line('user de confiance ' || to_char(usr_v));
		end if;
	end if;
	return bool;
end;
/
show ERRORS

-- CREATE or REPLACE PACKAGE bonne_affaire_pkg is
-- 	TYPE bon_tab IS TABLE OF objet.id_obj%TYPE;
-- 	function  bonneaffaire return bon_tab;
-- END;
-- /
-- show ERRORS
 -- body du package (fonction)
set serveroutput on
-- CREATE or REPLACE PACKAGE BODY bonne_affaire_pkg is
-- BONNE AFFAIRE
create or replace function bonneaffaire (id_obj_p integer)
    RETURN integer
    IS
        usrdeconf_v integer;
        nb_vente_v integer;
        avg_prix_v number;
        id_obj_v integer;
        id_usr_v integer;
        nom_obj_v objet.nom_obj%type;
        prix_dep_v objet.prix_dep%type;
    Begin
        id_obj_v := 0;
        select id_usr, nom_obj, prix_dep 
                into id_usr_v, nom_obj_v, prix_dep_v
                from objet
                where prix_dep < 200 and id_obj = id_obj_p;

	select usrdeconf(id_usr_v, nom_obj_v) into usrdeconf_v from dual;
        if prix_dep_v <= usrdeconf_v -- si le vendeur a déja vendu un objet + chere 
	then 
            select count(*), avg(prix_dep)
                into nb_vente_v, avg_prix_v
                from objet 
                where nom_obj = nom_obj_v and vendu = 1;
            -- si lobjet a deja ete vendu 10x et est 15% moins chere
            if nb_vente_v > 1 and prix_dep_v <= (avg_prix_v - (avg_prix_v * 0.15)) 
            -- remplacer par nb_vente_v > 10
            then 
                select id_obj into id_obj_v from objet where id_obj = id_obj_p;
                dbms_output.put_line(to_char(nom_obj_v) || ' (id : ' || to_char(id_obj_v) ||') est une bonne affaire !!!');
            end if;			
        end if;
    return id_obj_v;
end;
/
show ERRORS

set serveroutput on
CREATE OR REPLACE TRIGGER anti_spam
BEFORE insert
	ON commentaire
	FOR EACH ROW
DECLARE
    time_v TIMESTAMP(0);
    mess_v integer;
BEGIN
    select max(date_com) into time_v
	from commentaire
        where id_usr = :new.id_usr;
    
    -- si le comm est posté moin de 30s , 
	-- remplacer par 30 minutes
    if (:new.date_com - time_v) < '000000000 00:00:30.000000000'
        then
            select count(id_usr) into mess_v
                from commentaire
                where id_usr = :new.id_usr and (:new.date_com - date_com) < '000000000 00:00:30.000000000';
            
            -- si le compte de message postés il y a moin de 30s est supperieur a 3, 
			-- remplacer par 1 minutes et 20 messages
            if mess_v > 3
            then
                RAISE_APPLICATION_ERROR( -20001,'plus de 3 commentaires dans un intervalle inferieur a 30 secondes' ) ;
            end if;
    end if;
END;
/
show ERRORS