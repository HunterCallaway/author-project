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

}