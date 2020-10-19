<?php
namespace Bookstore\Domain;


abstract class Customer extends Person{
	private $id;
	private $email;
	private static $lastId = 0;
	
	public function __construct(
		int $id,
		string $firstname,
		string $surname,
		string $email
	) {
		parent::__construct($firstname, $surname);
		
		if ($id == null){
			$this->id = ++self::$lastId;
		} else {
			$this->id = $id;
			if ($id > self::$lastId) {
				self::$lastId = $id;
			}
		}
		//$this->id = $id;
		$this->email = $email;
	}


	public function getId(): id {
		return $this->id;
	}


	
	public function getEmail(): string {
		return $this->email;
	}

	public function setEmail(string $email) {
		$this->email = $email;
	}

	public static function getLastId(): int{
		return self::$lastId;
	}

	abstract public function getMonthlyFee();
	abstract public function getAmountToBorrow();
	abstract public function getType();
}


?>




