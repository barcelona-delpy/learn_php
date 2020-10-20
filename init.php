<?php

use Bookstore\Domain\Book;
use Bookstore\Domain\Customer;
use Bookstore\Domain\Payer;
use Bookstore\Domain\Customer\Basic;
use Bookstore\Domain\Customer\Premium;
use Bookstore\Exceptions\InvalidIdException;
use Bookstore\Exceptions\ExceededMaxAllowedException;
use Bookstore\Domain\Customer\CustomerFactory;
use Bookstore\Utils\Config;

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

//createBasicCustomer(1);
//createBasicCustomer(-1);
//createBasicCustomer(55);

//CustomerFactory::factory('basic', 2, 'mary', 'poppins', 'mary@poppins.com');
//CustomerFactory::factory('premium', null, 'james', 'bond', 'james@bond.com');

//$config = Config::getInstance();
//$dbConfig = $config->get('db');
//var_dump($dbConfig);

$dbConfig = Config::getInstance()->get('db');
//var_dump($dbConfig);

/*
PDO is abbreviation of "PHP Data Objects"
*/
$db = new PDO(
	'mysql:host=127.0.0.1;dbname=bookstore', /*DSN->data source name*/
	$dbConfig['user'],
	$dbConfig['password']
);

$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

/*
$rows = $db->query('select * from book order by title');
foreach($rows as $row){
	var_dump($row);
}
*/

/*
<<<SQL .... SQL; is a heredoc
The benefit of this is the ability to write strings in multiple
lines with tabulations or any other blank space,and PHP will respect it.
*/

/*
$query = <<<SQL
insert into book(isbn, title, author,price)
values("9788187981954", "Peter pan", "J. M. Barrie", 2.34)
SQL;

$result = $db->exec($query);
if($result){
	echo "exec $query success.\n";
}else{
	$error_str = $db->errorInfo()[2];
	echo "exec $query failed.error_str:$error_str \n";
}
*/


$query = 'select * from book where author = :author';
$statement = $db->prepare($query);
$statement->bindValue('author', 'George Orwell');
if($statement->execute()){
	$rows = $statement->fetchAll();
	var_dump($rows);

	echo "\n\n";
	foreach($rows as $row){
		foreach($row as $key => $value){
			echo "$key ===> $value.\n";
		}
	
		echo "\n";
	}
}


$query = <<<SQL
insert into book(isbn, title, author, price) 
values(:isbn, :title, :author, :price)
SQL;

$statement = $db->prepare($query);
$params = [
	'isbn' => '9781412108614',
	'title' => 'Iliad',
	'author' => 'Homer',
	'price' => 9.25
];

$statement->execute($params);
echo $db->lastInsertId(); // 8





?>





