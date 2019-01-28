<?php
namespace Jcallaway3\AuthorProject;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "Classes/autoload.php");

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
		if($authorHashInfo["algoName"] !== "argon2i") {
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

	/**
	 * constructor for this Author
	 *
	 * @param string|Uuid $newAuthorId id of this Author or null if a new Author
	 * @param string $newAuthorUrl string containing this Author's avatar URL
	 * @param $newAuthorActivationToken string for the Author activation token
	 * @param $newAuthorEmail string containing this Author's e-mail
	 * @param $newAuthorHash string containing the hash of this Author
	 * @param $newAuthorUsername string containing this Author's username
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

	public function __construct($newAuthorId, $newAuthorUrl, $newAuthorActivationToken, $newAuthorEmail, $newAuthorHash, $newAuthorUsername) {
		try {
			$this->setAuthorId($newAuthorId);
			$this->setAuthorAvatarUrl($newAuthorUrl);
			$this->setAuthorActivationToken($newAuthorActivationToken);
			$this->setAuthorEmail($newAuthorEmail);
			$this->setAuthorHash($newAuthorHash);
			$this->setAuthorUsername($newAuthorUsername);
		} //Determine what exception type was thrown.
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}



	/**
	 * Inserts this Author into MySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when MySQL-related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	/**
	 * PHASE 2
	 *
	public function insert(\PDO $pdo): void {

		//Create query template
		$query = "INSERT INTO author (authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername) VALUES(:authorId, :authorAvatarUrl, :authorActivationToken, :authorEmail, :authorHash, :authorUsername)";
		$statement = $pdo->prepare($query);

		$parameters = ["authorId" => $this->authorID->getBytes(), "authorAvatarURL" => $this->authorAvatarUrl, "authorActivationToken" => $this->authorActivationToken, "authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash, "authorUsername" => $this->authorUsername];
		$statement->execute($parameters);
	}

	/**
	 * Deletes this Author from MySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when MySQL-related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection
	 **/

	/**
	 *PHASE 2
	 *
	public function delete(\PDO $pdo): void {
		$query = "DELETE FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		//Bind the member variables to the place-holder in the template.
		$parameters = ["authorId" => $this->authorID->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * Updates this Author in MySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when MySQl-related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection
	 **/

	/**
	 * PHASE 2

	public function update(\PDO $pdo) : void{
		//Create a query template.
		$query = "UPDATE author SET authorId  = :authorId, authorAvatarUrl = :authorAvatarUrl, authorActivationToken = :authorActivationToken, authorEmail = :authorEmail, authorHash = :authorHash, authorUsername = :authorUsername WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		$parameters = ["authorId" => $this->authorID->getBytes(), "authorAvatarURL" => $this->authorAvatarUrl, "authorActivationToken" => $this->authorActivationToken, "authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash, "authorUsername" => $this->authorUsername];
		$statement->execute($parameters);
	}

	/**
	 * Gets the Author by authorId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid | string $authorId author ID for which to search
	 * @return Author \ null Author found or null if not found
	 * @throws \PDOException when MySQL-related errors occur
	 * @throws \TypeError when a variable is not the correct data type
	 **/
	/**
	 * PHASE 2
	 *
	 * public static function getAuthorByAuthorId(\PDO $pdo, $authorId) : ?Author {
		//Sanitize the authorId before searching
		try{
			$tweetId = self::validateUuid($authorId);
		}catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		//Create a query template.
		$query = "SELECT authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		//Bind the author ID to the place-holder in the template
		$parameters = ["authorId" => $authorId->getBytes()];
		$statement->execute($parameters);

		//Grab the author from MySQL
		try {
			$author = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$author = new Author($row["authorId"], $row["authorAvatarUrl"], $row["authorActivationToken"], $row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
			}
		} catch(\Exception $exception) {
			//If the row could not be converted, rethrow it.
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($author);
	}

	/**
	 * Gets the Author by
	 **/

}


