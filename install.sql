CREATE TABLE `votes` (
	vid			VARCHAR(20) PRIMARY KEY,
	name		VARCHAR(1024),
	tally		INT,

	smallthumb	VARCHAR(1024), 	-- YouTube's 120x90  thumbnail
	bigthumb	VARCHAR(1024) 	-- YouTube's 320x180 thumbnail
);