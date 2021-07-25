#
# Table structure for table 'tx_heiner_domain_model_person'
#
CREATE TABLE tx_heiner_domain_model_person (

	anrede varchar(255) DEFAULT '' NOT NULL,
	vorname varchar(255) DEFAULT '' NOT NULL,
	nachname varchar(255) DEFAULT '' NOT NULL,
	email varchar(255) DEFAULT '' NOT NULL,
	telefon varchar(255) DEFAULT '' NOT NULL,
	handy varchar(255) DEFAULT '' NOT NULL,
	firma int(11) unsigned DEFAULT '0'

);

#
# Table structure for table 'tx_heiner_domain_model_company'
#
CREATE TABLE tx_heiner_domain_model_company (

	name varchar(255) DEFAULT '' NOT NULL,
	unterzeile varchar(255) DEFAULT '' NOT NULL,
	strasse varchar(255) DEFAULT '' NOT NULL,
	plz varchar(255) DEFAULT '' NOT NULL,
	ort varchar(255) DEFAULT '' NOT NULL,
	telefon varchar(255) DEFAULT '' NOT NULL,
	fax varchar(255) DEFAULT '' NOT NULL,
	web varchar(255) DEFAULT '' NOT NULL

);
