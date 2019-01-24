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
	 * Accessor method for the author ID
	 *
	 * @return Uuid for author ID(or null if it is a new Author)
	 **/
	public function getAuthorId(): string {
		return ($this->authorID);
	}

	/**
	 * Mutator method for author ID
	 *
	 * @param Uuid || string $newAuthorId value of new author Id
	 * @throws \InvalidArgumentException if the id is not a string or is insecure
	 * @throws \RangeException if the Uuid is not positive
	 * @throws \TypeError if the Uuid is not a Uuid or string
	 **/

	public function setAuthorId($newAuthorId) {
		try {
			$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//Convert and store the author id
		$this->authorID = $uuid;
	}

	/**
	 * Accessor method for the author avatar url
	 *
	 * @return string value of author avatar url
	 **/

	public function getAuthorAvatarUrl(): string {
		return ($this->authorAvatarUrl);
	}

	/**
	 * Mutator function for the author avatar url
	 *
	 * @param string $newAuthorAvatarUrl new value author avatar url
	 * @throws \InvalidArgumentException if the author url is not a string or is insecure
	 * @throws \RangeException if the url is longer than 255 characters
	 **/

	public function setAuthorAvatarUrl(string $newAuthorAvatarUrl): void {
		$newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_VALIDATE_URL);
		if(empty($newAuthorAvatarUrl === true)) {
			throw(new \InvalidArgumentException("This URL is invalid or insecure"));
		}
		//Verify the URL is no longer than 255 characters
		if(strlen($newAuthorAvatarUrl) > 255) {
			throw(new \RangeException("This URL is too long. It must be no longer than 255 characters."));
		}
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
	}

	/**
	 * Accessor method for the author activation token
	 *
	 * @return string value of the author activation token
	 **/

	public function getAuthorActivationToken(): string {
		return ($this->authorActivationToken);
	}

	/**
	 * Mutator function for the author activation token
	 *
	 * @param string $newAuthorActivationToken new value author activation token
	 * @throws \InvalidArgumentException if the author activation token isn't a string or is insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 **/

	public function setAuthorActivationToken(string $newAuthorActivationToken): void {
		if($newAuthorActivationToken === null) {
			$this->authorActivationToken = null;
			return;
		}
		$newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
		if(ctype_xdigit($newAuthorActivationToken) === false) {
			throw(new \RangeException("User activation is not valid."));
		}
		//Verify the activation token is only 32 characters long
		if(strlen($newAuthorActivationToken) !== 32) {
			throw (new \RangeException("The user activation token must be 32 characters long."));
		}
	}


}


