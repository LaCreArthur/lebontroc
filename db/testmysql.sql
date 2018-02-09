create table note 
(
   ID             	 INT            	 not null,
   etu_ID          	 INT				 not null,
   matiere           varCHAR(50)         not null,
   note           	 NUMBER              not null
);

/*==============================================================*/
/* Table : ARCHIVE                                              */
/*==============================================================*/
create table etu 
(
   ID               INT             	 not null,
   nom           	varCHAR(50)      	 not null,
   prenom           varCHAR(50)        	 not null,
   age	          	INT
);


INSERT INTO etu VALUES (1, 'hey','salut', 20);
INSERT INTO etu VALUES (2, 'magic','tutur', 20);
INSERT INTO etu VALUES (3, 'aix','ample', 20);

INSERT INTO note VALUES (1, 1,'mysql', 20);
INSERT INTO note VALUES (2, 1,'mysql', 10);
INSERT INTO note VALUES (3, 1,'mysql', 0);

INSERT INTO note VALUES (4, 2,'mysql', 5);
INSERT INTO note VALUES (5, 2,'mysql', 15);

INSERT INTO note VALUES (6, 3,'mysql', 7);
INSERT INTO note VALUES (7, 3,'mysql', 8);
INSERT INTO note VALUES (8, 3,'mysql', 12);
INSERT INTO note VALUES (9, 3,'mysql', 13);

