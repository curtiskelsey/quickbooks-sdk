<?php

namespace QuickBooks\Exception\SdkExceptions;

use QuickBooks\Exception\SdkException;

/**
 * Represents an Exception raised when an invalid service request was made.
 */
class InvalidServiceRequestException extends SdkException
{
	/**
	 * Initializes a new instance of the InvalidServiceRequestException class.
	 *
	 * @param string $message string-based exception description
	 * @param int|string $code exception code
	 */
    public function __construct($message, $code = 0) {
        parent::__construct($message, $code);
    }

	/**
	 * Generates a string-based representation of the exception
	 */
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
