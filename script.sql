DROP TABLE ART;
DROP TABLE PHOTOGRAPHY;
DROP TABLE HISTORIC;
DROP TABLE AUTHOR;
DROP TABLE TYPE;
DROP TABLE MATERIAL;
DROP TABLE BE;
DROP TABLE DESIGN;
DROP TABLE COMPOSE;
DROP TABLE ARCHITECT;
DROP TABLE PARTICIPATE;
DROP TABLE VIDEO;
DROP TABLE REPORT;
DROP TABLE LOCATION;

CREATE TABLE TYPE (
  name VARCHAR(32),
  CONSTRAINT PK_TYPE PRIMARY KEY (name)
);

CREATE TABLE ART (
	name VARCHAR(150),
	creationDate NUMBER,
	presentationHTMLFile VARCHAR(32),
	historiqueHTMLFile VARCHAR(32),
	sonFile VARCHAR(32),
	isPublic NUMBER(1),
  type VARCHAR(32),
	CONSTRAINT PK_Art PRIMARY KEY (name),
  CONSTRAINT FK_Art_Type FOREIGN KEY (name) 
		REFERENCES TYPE(name) ON DELETE CASCADE
);

CREATE TABLE LOCATION (
	name VARCHAR(150),
	longitude FLOAT,
	latitude FLOAT,
	nameArt VARCHAR(150),
	CONSTRAINT PK_Location PRIMARY KEY (name),
	CONSTRAINT FK_Location_Art FOREIGN KEY (nameArt) 
		REFERENCES ART(name) ON DELETE CASCADE
);

CREATE TABLE VIDEO (
	titleFile VARCHAR(32),
	nameArt VARCHAR(32),
	CONSTRAINT PK_Video PRIMARY KEY (titleFile),
	CONSTRAINT FK_Video_Art FOREIGN KEY (nameArt) 
		REFERENCES ART(name) ON DELETE CASCADE
);

CREATE TABLE REPORT (
	titleFileVideo VARCHAR(32),
	nameArt VARCHAR(150),
	CONSTRAINT PK_Report PRIMARY KEY (titleFileVideo, nameArt),
	CONSTRAINT FK_Report_Art FOREIGN KEY (nameArt) 
		REFERENCES ART(name) ON DELETE CASCADE,
	CONSTRAINT FK_Report_Video FOREIGN KEY (titleFileVideo) 
		REFERENCES VIDEO(titleFile) ON DELETE CASCADE
);

CREATE TABLE ARCHITECT (
	fullName VARCHAR(100),
	nameArt VARCHAR(150),
	CONSTRAINT FK_Architect PRIMARY KEY (fullname),
	CONSTRAINT FK_Architect_Art FOREIGN KEY (nameArt) 
		REFERENCES ART(name) ON DELETE CASCADE
);

CREATE TABLE PARTICIPATE (
	fullName VARCHAR(100),
	nameArt VARCHAR(150),
	CONSTRAINT PK_Participate PRIMARY KEY (fullName, nameArt),
	CONSTRAINT FK_Participate_Art FOREIGN KEY (nameArt) 
		REFERENCES ART(name) ON DELETE CASCADE,
	CONSTRAINT FK_Participate_Video FOREIGN KEY (fullName) 
		REFERENCES ARCHITECT(fullName) ON DELETE CASCADE
);

CREATE TABLE PHOTOGRAPHY (
  nameFile VARCHAR(32),
  nameArt VARCHAR(150),
  CONSTRAINT PK_Photography PRIMARY KEY (nameFile),
  CONSTRAINT FK_Photographie_Art FOREIGN KEY (nameArt) 
		REFERENCES ART(name) ON DELETE CASCADE
);

CREATE TABLE HISTORIC (
  nameFile VARCHAR(32),
  nameArt VARCHAR(150),
  CONSTRAINT PK_Historic PRIMARY KEY (nameFile),
  CONSTRAINT FK_Historic_Art FOREIGN KEY (nameArt) 
		REFERENCES ART(name) ON DELETE CASCADE
);

CREATE TABLE AUTHOR (
  fullName VARCHAR(100),
  biographyHTMLFile VARCHAR(32),
  yearBirth NUMBER(4),
  yearDEATH NUMBER(4),
  CONSTRAINT PK_Author PRIMARY KEY (fullName)
);

CREATE TABLE DESIGN (
  nameAuthor VARCHAR(100),
  nameArt VARCHAR(150),
  CONSTRAINT PK_Design PRIMARY KEY (nameAuthor, nameArt),
	CONSTRAINT FK_Design_Art FOREIGN KEY (nameArt) 
		REFERENCES ART(name) ON DELETE CASCADE,
	CONSTRAINT FK_Design_Author FOREIGN KEY (nameAuthor) 
		REFERENCES AUTHOR(fullName) ON DELETE CASCADE
); 

CREATE TABLE MATERIAL (
  name VARCHAR(32),
  CONSTRAINT PK_Material PRIMARY KEY (name)
);

CREATE TABLE COMPOSE (
  nameMaterial VARCHAR(32),
  nameArt VARCHAR(150),
  CONSTRAINT PK_Compose PRIMARY KEY (nameArt, nameMaterial),
	CONSTRAINT FK_Compose_Art FOREIGN KEY (nameArt) 
		REFERENCES ART(name) ON DELETE CASCADE,
	CONSTRAINT FK_Compose_Material FOREIGN KEY (nameMaterial) 
		REFERENCES MATERIAL(name) ON DELETE CASCADE
); 

CREATE TABLE MATERIAL (
  name VARCHAR(32),
  CONSTRAINT PK_Material PRIMARY KEY (name)
);

CREATE TABLE COMPOSE (
  nameMaterial VARCHAR(32),
  nameArt VARCHAR(150),
  CONSTRAINT PK_Compose PRIMARY KEY (nameArt, nameMaterial),
	CONSTRAINT FK_Compose_Art FOREIGN KEY (nameArt) 
		REFERENCES ART(name) ON DELETE CASCADE,
	CONSTRAINT FK_Compose_Material FOREIGN KEY (nameMaterial) 
		REFERENCES MATERIAL(name) ON DELETE CASCADE
);