<?php

/**
* Cross section of a profile
*
* This is a cross section of a profile referred to as author. This entity is a strong entity.
*
* @author Hunter Callaway <jcallaway3@cnm.edu>
**/

class Author {
	use ValidateUuid;
	/**
	 * id for the Author entity; this is the Primary Key
	 * @var string $authorID
	 **/
	private $authorID;
	/**
	 * avatar URL for this Author
	 * @var string $authorAvatarUrl
	 **/
	private $authorAvatarUrl;
	/**
	 * activation token for Author
	 * @var string $authorActivationtoken
	 **/
	private $authorActivationToken;
	/**
	 * e-mail address for this Author; this is a unique key
	 * @var string $authorEmail
	 **/
	private $authorEmail;
	/**
	 * password for this Author
	 * @var string $authorHash
	 **/
	private $authorHash;
	/**
	 * username for this Author; this is a unique key
	 * @var string $authorUsername
	 **/
	private $authorUsername;

	/**
	 * Accessor method for author ID
	 *
	 * @return Uuid for author ID(or null if it is a new Author)
	 **/
	public function getAuthorId(): Uuid {
		return ($this->authorID);
	}

	/**
	 * Mutator method for author ID
	 *
	 * @param Uuid || string $newAuthorId value of new Author Id
	 * @throws \RangeException if the Uuid is not positive
	 * @throws \TypeError if the Uuid is not a Uuid or string
	 **/

	public function setAuthorId($newAuthorId) {
		try {
			$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception)
	}

}


