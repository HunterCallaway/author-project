<?php
namespace Jcallaway3\AuthorProject;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
* Cross section of a profile
*
* This is a cross section of a profile referred to as author. This entity is a strong entity.
*
* @author Hunter Callaway <jcallaway3@cnm.edu>
**/

class Author {
	use ValidateUuid;
	use ValidateDate;
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
		//
		$newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_VALIDATE_URL);
		if(empty($newAuthorAvatarUrl === true)) {
			throw(new \InvalidArgumentException("This URL is invalid or insecure"));
		}
		//Verify the URL is no longer than 255 characters
		if(strlen($newAuthorAvatarUrl) > 255) {
			throw(new \RangeException("This URL is too long. It must be no longer than 255 characters."));
		}
		//Store the author avatar URL
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
		//Store the author activation token
		$this->authorActivationToken = $newAuthorActivationToken;
	}

/**
 * Accessor method for the author e-mail
 *
 * @return string value of the author e-mail
 */

public function getAuthorEmail(): string {
	return ($this->authorEmail);
}

/**
 * Mutator method for the author e-mail
 *
 * @param string $newAuthorEmail new value author e-mail
 * @throws \InvalidArgumentException if the author e-mail address is not valid or is insecure
 * @throws \RangeException if the author e-mail address is longer than 128 characters
 **/

public function setAuthorEmail(string $newAuthorEmail): void {
	$newAuthorEmail = trim($newAuthorEmail);
	$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
	if(empty($newAuthorEmail) === true) {
		throw(new \InvalidArgumentException("The author e-mail address is not valid or is insecure."));
	}
	//Verify that the e-mail address is no longer than 128 characters
	if(strlen($newAuthorEmail) > 128) {
		throw (new \RangeException("The e-mail address must be no longer than 128 characters."));
	}
	//Store the author e-mail
	$this->authorEmail = $newAuthorEmail;
}

	/**
	 * Accessor method for the authorHash
	 *
	 * @return string value of the author hash
	 **/

public function getAuthorHash(): string {
	return $this->authorHash;
}

/**
 * Mutator method for the author hash
 *
 * @param string $newAuthorHash new value for the author hash
 * @throws \InvalidArgumentException if the hash is not secure
 * @throws \RangeException if the hash is longer than 97 characters
 **/

public function setAuthorHash(string $newAuthorHash): void {
	//Ensure that the hash is formatted correctly
	$newAuthorHash = trim($newAuthorHash);
	if(empty($newAuthorHash) === true) {
		throw (new \InvalidArgumentException("The hash is empty or insecure."));
	}
	//Ensure the hash is an Argon hash
	$authorHashInfo = password_get_info($newAuthorHash);
	if($authorHashInfo["algoName"] !== "argon2i"){
		throw (new \InvalidArgumentException("This is not a valid hash."));
	}
	if(strlen($newAuthorHash) > 97) {
		throw (new \RangeException("The hash must be no longer than 97 characters."));
	}
	//Store the hash
	$this->authorHash = $newAuthorHash;
}

/**
 * Accessor method for the authorUsername
 *
 * @return string value or the author username
 **/

public function getAuthorUsername(): string {
	return $this->authorUsername;
}

/**
 * Mutator method for the author username
 *
 * @param string $newAuthorUsername new value for the author username
 * @throws \InvalidArgumentException if $newAuthorUsername is not a string or is insecure
 * @throws \RangeException if $newAuthorUsername is longer than 32 characters
 **/

public function setAuthorUsername(string $newAuthorUsername): void {
	//Ensure the username is formatted correctly
	$newAuthorUsername = trim($newAuthorUsername);
	$newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($newAuthorUsername) === true) {
		throw (new \InvalidArgumentException("The user name is invalid or insecure."));
	}
	//Verify the username is no longer than 32 characters.
	if(strlen($newAuthorUsername) > 32) {
		throw (new \RangeException("The username cannot be longer"));
		}
	//Store the username
	$this->authorUsername = $newAuthorUsername;
	}

	function __construct($idAuthor, $avatarUrlAuthor, $activationTokenAuthor, $emailAuthor, $hashAuthor, $usernameAuthor) {
		$this->authorID = $idAuthor;
		$this->authorAvatarUrl = $avatarUrlAuthor;
		$this->authorActivationToken = $activationTokenAuthor;
		$this->authorEmail = $emailAuthor;
		$this->authorHash = $hashAuthor;
		$this->authorUsername = $usernameAuthor;
	}

}



