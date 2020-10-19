<?php

use Bookstore\Domain\Book;
use Bookstore\Domain\Customer;
use Bookstore\Domain\Customer\Basic;
use Bookstore\Domain\Customer\Premium;




function autoloader($classname) {
	$lastSlash = strpos($classname, '\\') + 1;
	$classname = substr($classname, $lastSlash);
	$directory = str_replace('\\', '/', $classname);
	$filename = __DIR__ . '/src/' . $directory . '.php';
	require_once($filename);
}

spl_autoload_register('autoloader');



//require_once __DIR__ . '/Book.php';
//require_once __DIR__ . '/Customer.php';

$book1 = new Book(9785267006323, "1984", "George Orwell", 12);
$book2 = new Book(9780061120084, "To Kill a Mockingbird", "Harper Lee", 2);

//$customer1 = new Customer(1, 'John', 'Doe', 'johndoe@mail.com');
//$customer2 = new Customer(2, 'Mary', 'Poppins', 'mp@mail.com');



function checkIfValid(Customer $customer, array $books): bool {
	return $customer->getAmountToBorrow() >= count($books);
}

$customer1 = new Basic(5, 'John', 'Doe', 'johndoe@mail.com');
var_dump(checkIfValid($customer1, [$book1])); // ok
$customer2 = new Premium(7, 'James', 'Bond', 'james@bond.com');
var_dump(checkIfValid($customer2, [$book1])); // fails


?>





