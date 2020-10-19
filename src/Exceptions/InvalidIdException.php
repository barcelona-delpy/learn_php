<?php
namespace Bookstore\Exceptions;
use Exception;


class InvalidIdException extends Exception {
	public function __construct($message = null) {
		/*the ?: operator is a shorter version of a conditional,
		and works like this:the expression on the left is returned 
		if it does not evaluate to false.
		*/
		$message = $message ?: 'Invalid id provided.';
		parent::__construct($message);
	}
}

?>




