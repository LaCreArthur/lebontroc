/*==============================================================*/
/* Nom de SGBD :  ORACLE Version 11g                            */
/* Date de cr�ation :  23/10/2014 12:50:33                      */
/*==============================================================*/


/*==============================================================*/
/* Table : PHOTO                                                */
/*==============================================================*/
create table PHOTO 
(
   ID_PHOTO             INTEGER                  not null, /* si l'id n'est pas dans la table phot_obj alors c'est une photo d'user*/
   PATH_PHOTO           VARCHAR2(99)		 DEFAULT NULL,
   constraint PK_PHOTO primary key (ID_PHOTO)
);

create sequence seqphoto start with 2 increment by 1;
/*==============================================================*/
/* Table : USR                                               */
/*==============================================================*/
create table USR 
(
   ID_USR               INTEGER              not null,
   ID_PHOTO             INTEGER              default 0, /* id 0 = photo generique */
   NOM_USR              VARCHAR2(50)         not null,
   COORDX_USR            NUMBER               not null,
   COORDY_USR            NUMBER               not null,
   NOTE_USR             NUMBER		     DEFAULT 3,
   PTROC_USR            INTEGER              default 0,
   PASS                 VARCHAR2(50)         not null,
   constraint PK_USER primary key (ID_USR),
   constraint FK_PHOTO foreign key (ID_PHOTO)
         references PHOTO (ID_PHOTO),
   constraint CK_note_usr
         CHECK (NOTE_USR <= 5 and NOTE_USR >=1)
);

create sequence sequsr start with 4 increment by 1;
/*==============================================================*/
/* Table : ARCHIVE                                              */
/*==============================================================*/
create table ARCHIVE 
(
   ID_ARCHIVE           INTEGER              not null,
   ID_ACHETEUR               INTEGER              ,
   ID_USR           INTEGER              ,
   PTROC_ACHETEUR            INTEGER    			 DEFAULT 0,
   ACCEPTER             number(1)            default -1,
   DATE_RDV             DATE				 DEFAULT NULL,
   COORDX_RDV            NUMBER               ,
   COORDY_RDV            NUMBER               ,
   PTROC_USR        INTEGER				 DEFAULT 0,
   prix_fin 			INTEGER				 ,
   constraint PK_ARCHIVE primary key (ID_ARCHIVE),
   constraint FK_a_USER foreign key (ID_ACHETEUR)
         references USR (ID_USR),
   constraint FK_a_VENDEUR foreign key (ID_USR)
         references USR (ID_USR)
);


create sequence seqarchive start with 1 increment by 1;
/*==============================================================*/
/* Table : CATEGORIE                                            */
/*==============================================================*/
create table CATEGORIE 
(
   ID_CAT               INTEGER              not null,
   ID_SUR_CAT           INTEGER				 DEFAULT NULL,
   NOM_CAT              VARCHAR2(50)         not null,
   constraint PK_CAT primary key (ID_CAT),
   constraint FK_SUR_CAT foreign key (ID_SUR_CAT)
         references CATEGORIE (ID_CAT)
);

create sequence seqcat start with 1 increment by 1;
/*==============================================================*/
/* Table : OBJET                                                */
/*==============================================================*/
create table OBJET 
(
   ID_OBJ               INTEGER              not null,
   ID_USR               INTEGER              not null,
   ID_CAT               INTEGER              not null,
   NOM_OBJ              VARCHAR2(50)         not null,
   DESC_OBJ             VARCHAR2(256)	     default '',
   ETAT_OBJ             VARCHAR2(50)		 default null,
   PRIX_DEP             INTEGER				 DEFAULT NULL,
   Service              Integer 			 default 0,
   VENDU                Number(1) 			 default 0,
   constraint PK_OBJET primary key (ID_OBJ),
   constraint FK_CAT foreign key (ID_CAT)
         references CATEGORIE (ID_CAT),
   constraint FK_USER foreign key (ID_USR)
         references USR (ID_USR),
   constraint CK_note
         CHECK (ETAT_OBJ IN ('Bon etat', 'Neuf', 'Abime', 'Service'))
);

create sequence seqobjet start with 1 increment by 1;
/*==============================================================*/
/* Table : COMMENTAIRE                                          */
/*==============================================================*/
create table COMMENTAIRE 
(
   ID_COM               INTEGER              not null,
   ID_USR               INTEGER              not null,
   ID_NOTEUR            INTEGER				 DEFAULT NULL,
   ID_OBJ               INTEGER  			 DEFAULT NULL,
   COMM                 VARCHAR2(256)	     default '',
   NOTE_COM             INTEGER 			 DEFAULT NULL,
   DATE_COM             TIMESTAMP(0)               default sysdate not null,
   constraint PK_COMMENTAIRE primary key (ID_COM),
   constraint FK_c_OBJET foreign key (ID_OBJ)
         references OBJET (ID_OBJ),
   constraint FK_c_USER foreign key (ID_USR)
         references USR (ID_USR),
   constraint FK_NOTEUR foreign key (ID_NOTEUR)
         references USR (ID_USR),
   constraint CK_note_com
         CHECK (NOTE_COM <= 5 and NOTE_COM >=1)
);

create sequence seqcom start with 1 increment by 1;
/*==============================================================*/
/* Table : EST_ARCHIVE                                          */
/*==============================================================*/
create table EST_ARCHIVE 
(
   ID_ARCHIVE           INTEGER              not null,
   ID_OBJ               INTEGER              not null,
   constraint PK_EST_ARCHIVE primary key (ID_ARCHIVE, ID_OBJ),
   constraint FK_TABLE_ARCHIVE foreign key (ID_ARCHIVE)
         references ARCHIVE (ID_ARCHIVE),
   constraint FK_a_OBJET foreign key (ID_OBJ)
         references OBJET (ID_OBJ)
);

/*==============================================================*/
/* Table : PHOTO_OBJET                                          */
/*==============================================================*/
create table PHOTO_OBJET 
(
   ID_PHOTO             INTEGER              not null,
   ID_OBJ               INTEGER              not null,
   constraint PK_PHOTO_OBJET primary key (ID_PHOTO, ID_OBJ),
   constraint FK_o_PHOTO foreign key (ID_PHOTO)
         references PHOTO (ID_PHOTO),
   constraint FK_OBJET foreign key (ID_OBJ)
         references OBJET (ID_OBJ)
);

/*==============================================================*/
/* Table : PROPOSITION                                          */
/*==============================================================*/
create table PROPOSITION 
(
   ID_PROP              INTEGER              not null,
   ID_ACHETEUR          INTEGER              not null,
   ID_USR               INTEGER              not null,
   PTROC_ACHETEUR       INTEGER				 default 0,
   ACCEPTER             number(1)            default 0,
   COORDX_RDV           NUMBER               not null,
   COORDY_RDV           NUMBER               not null,
   DATE_RDV             DATE 				 DEFAULT NULL,
   PTROC_USR            INTEGER				 default 0,
   constraint PK_PROPOSITION primary key (ID_PROP),
   constraint FK_p_acheteur foreign key (ID_ACHETEUR)
         references USR (ID_USR),
   constraint FK_p_VENDEUR foreign key (ID_USR)
         references USR (ID_USR)
);

create sequence seqprop start with 1 increment by 1;
/*==============================================================*/
/* Table : RECOIT_UNE                                           */
/*==============================================================*/
create table RECOIT_UNE 
(
   ID_OBJ               INTEGER              not null,
   ID_PROP              INTEGER              not null,
   constraint PK_RECOIT_UNE primary key (ID_OBJ, ID_PROP),
   constraint FK_p_OBJET foreign key (ID_OBJ)
         references OBJET (ID_OBJ),
   constraint FK_PROP foreign key (ID_PROP)
         references PROPOSITION (ID_PROP)
);

/*==============================================================*/
/* OTHER                                 				        */
/*==============================================================*/

