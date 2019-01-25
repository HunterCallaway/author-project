<?php

/**
 * Trait to validate a UUID
 *
 * This trait will validate a UUID in any of the following three formats
 *
 * 1. Human-readable string (36 bytes)
 * 2. Binary string (16 bytes)
 * 3. Ramsey\Uuid\Uuid object
 *
 * @author Hunter Callaway <jcallaway3@cnm.edu>
 **/

trait ValidateUuid {
	/**
	 * Validates a UUID irrespective of the format
	 *
	 * @param string|Uuid $new uuid to validate
	 * @return Uuid object with validated uuid
	 * @throws \InvalidArgumentException if $newUuid is not a valid uuid
	 * @throws \RangeException if $newUuid is not a valid uuid v4
	 **/
	private static function validateUuid($newUuid) {
		//Verify a string uuid
		if(gettype($newUuid) === "string") {
			// Sixteen characters is binary data from mySQL - convert to string and fall to next if block
			if(strlen($newUuid) === 16) {
				$newUuid = bin2hex($newUuid);
				$newUuid = substr($newUuid, 0, 8) . "-" . substr($newUuid, 8, 4) . "-" . substr($newUuid, 12, 4) . "-" . substr($newUuid, 16, 4) . "-" . substr($newUuid, 20, 12);
			}
			//Thirty-six characters is a human-readable uuid
			if(strlen($newUuid) === 36) {
				if(Uuid::isValid)
			}
		}
	}
}