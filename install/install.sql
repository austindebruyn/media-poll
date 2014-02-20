CREATE TABLE `votes` (
	vid			VARCHAR(20) PRIMARY KEY,
	name		VARCHAR(1024),
	tally		INT,
	views		INT,

	smallthumb	VARCHAR(1024), 	-- YouTube's 120x90  thumbnail
	bigthumb	VARCHAR(1024), 	-- YouTube's 320x180 thumbnail

	artist		VARCHAR(1024),
	artisturl	VARCHAR(1024),

	dAdded		DATE,
	dLastvoted	DATE,

	tainted 	BOOLEAN DEFAULT FALSE
);

CREATE TABLE `config` (
	description 	VARCHAR(1024),

	minVotes 		INT,
	maxVotes 		INT,
	forceMin		BOOLEAN,

	chk			 	BIT UNIQUE DEFAULT 1
);

CREATE TABLE `iptable` (
	ip 			VARCHAR(45) PRIMARY KEY
);