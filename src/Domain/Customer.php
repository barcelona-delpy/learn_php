<?php
namespace Bookstore\Domain;


/*
Note that an interface is very similar to an abstract class.
The differences are that it is defined with the keyword interface,and that its method
do not have the word abstract.Interfaces cannot be instantiated,since their methods 
are not implemented as with abstract classes.The only thing you can do with them is
make a class to implement them.
*/


/*
Interfaces can only extend from other interfaces,and classes can only extends from other classes.
*/
interface Customer extends Payer {
	public function getMonthlyFee(): float;
	public function getAmountToBorrow(): int;
	public function getType(): string;
}


?>




