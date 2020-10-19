<?php

use Bookstore\Domain\Book;
use Bookstore\Domain\Customer;
use Bookstore\Domain\Payer;
use Bookstore\Domain\Customer\Basic;
use Bookstore\Domain\Customer\Premium;
use Bookstore\Exceptions\InvalidIdException;
use Bookstore\Exceptions\ExceededMaxAllowedException;


function autoloader($classname) {
	$lastSlash = strpos($classname, '\\') + 1;
	$classname = substr($classname, $lastSlash);
	$directory = str_replace('\\', '/', $classname);
	$filename = __DIR__ . '/src/' . $directory . '.php';
	//echo "$filename";
	require_once($filename);
}

spl_autoload_register('autoloader');



//require_once __DIR__ . '/Book.php';
//require_once __DIR__ . '/Customer.php';

//$book1 = new Book(9785267006323, "1984", "George Orwell", 12);
//$book2 = new Book(9780061120084, "To Kill a Mockingbird", "Harper Lee", 2);

//$customer1 = new Customer(1, 'John', 'Doe', 'johndoe@mail.com');
//$customer2 = new Customer(2, 'Mary', 'Poppins', 'mp@mail.com');



function checkIfValid(Customer $customer, array $books): bool {
	return $customer->getAmountToBorrow() >= count($books);
}

//$customer1 = new Basic(5, 'John', 'Doe', 'johndoe@mail.com');
//var_dump(checkIfValid($customer1, [$book1])); // ok
//$customer2 = new Premium(7, 'James', 'Bond', 'james@bond.com');
//var_dump(checkIfValid($customer2, [$book1])); // fails

function processPayment(Payer $payer, float $amount) {
	if($payer->isExtentOfTaxes()){
		echo "what a lucky one...";
	}else{
		$amount *= 1.16;
	}

	$payer->pay($amount);
}

//processPayment($customer1, 100);
//processPayment($customer2, 1000);

//var_dump($customer1 instanceof Payer);
//var_dump($customer2 instanceof Payer);


/*$basic1 = new Basic(1, "name", "surname", "email");
$basic2 = new Basic(NULL, "name", "surname", "email");

var_dump($basic1->getId()); // 1
var_dump($basic2->getId()); // 2

try {
	$excep_obj = new Basic(-1, "name", "surname", "email");
}catch(Exception $e){
	echo $e->getMessage();
}
*/

function createBasicCustomer($id){
	try{
		echo "\nTrying to create a new customer.\n";
		return new Basic($id, "name", "surname", "email");
	} catch (InvalidIdException $e){
		echo "You cannot provide a negative id.\n";
	} catch (ExceededMaxAllowedException $e){
		echo "No more customers are allowed.\n";
	} catch (Exception $e){
		echo "Unknown exception: " . $e->getMessage();
	} finally {
		echo "End of try...catch block.\n";
	}
}

createBasicCustomer(1);
createBasicCustomer(-1);
createBasicCustomer(55);



?>





