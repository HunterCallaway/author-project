<?php

/**
* Cross section of a profile
*
* This is a cross section of a profile referred to as author. This entity is a strong entity.
*
* @author Hunter Callaway <jcallaway3@cnm.edu>
**/

class Author {

	/**
	 * id for the Author entity; this is the Primary Key
	 * @var Uuid $authorID
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
	 * e-mail address for this Author; this a unique key
	 * @var string $authorEmail
	 **/
	private $authorEmail;
	/**
	 * password for this Author
	 * @var string $authorHash
	 **/
	private $authorHash;

}


