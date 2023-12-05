CREATE TABLE tt_content
(
	tx_otirrebuttons_domain_model_buttons int(11) unsigned default 0  not null,
	tx_otirrebuttons_button_size          varchar(10)      default '' not null,
);

CREATE TABLE tx_otirrebuttons_domain_model_button
(
	parent_id     int(11)       default '0' not null,
	parent_table  varchar(50)   default ''  not null,
	text          varchar(100)  default '',
	link          varchar(2048) default '',
	layout        varchar(100)  default '',
	position      varchar(20)   default '',
	icon          varchar(50)   default '',
	icon_position varchar(50)   default '',
);
