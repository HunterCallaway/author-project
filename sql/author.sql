/*
  creates an Author entity
 */
CREATE TABLE author(
/*
  creates the attributes
 */

	authorId BINARY(16) NOT NULL,
	authorAvatarUrl VARCHAR(255),
	authorActivationToken CHAR(32),
	authorEmail VARCHAR(128) NOT NULL,
	authorHash CHAR(97) NOT NULL,
	authorUsername VARCHAR(32) NOT NULL,
	UNIQUE(authorEmail),
	UNIQUE(authorUsername),
	INDEX(authorEmail),
	/*
	creates a primary key
	*/
	PRIMARY KEY(authorId)
	);