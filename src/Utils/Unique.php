<?php
namespace Bookstore\Utils;
use Bookstore\Exceptions\InvalidIdException;
use Bookstore\Exceptions\ExceededMaxAllowedException;


/*
trait can't be instantiated,we cannot add a constructor.
The scenario where the trait and the class implement the same
method is easy.The method implemented explicitly in the class
is the one with more precedence,followed by the method implemented
in the trait,and finally,the method inherited from the parent class.
Let's see how it works.Take for example the following trait and 
class definitions.
*/
trait Unique {
	private static $lastId = 0;
	protected $id;

	public function setId(int $id = null) {
		if($id < 0){
			throw new InvalidIdException('Id cannot be negative.');
		}
		if (empty($id)) {
			$this->id = ++self::$lastId;
		} else {
			$this->id = $id;
			if ($id > self::$lastId) {
				self::$lastId = $id;
			}
		}
		
		if ($this->id > 50){
			throw new ExceededMaxAllowedException('Max number of users is 50.');
		}
	}

	public static function getLastId(): int {
		return self::$lastId;
	}

	public function getId(): int {
		return $this->id;
	}
}

?>




