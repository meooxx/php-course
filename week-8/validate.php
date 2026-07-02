
<?php

class Validate {
	public function checkEmpty($data, $fields) {
		$msg = null;
		foreach($fields  as $value)  {
			if(empty($data[$value])) {
				$msg .= "<p>$value field empty</p>";
			}
		}
		return $msg;
	}
	/**	
	 * check to see if the provide age 
	 * contain only numbers
	 * lusing preg_match
	 */
	public  function validAge($age) {
		/**
		 * preg_match uses regular expressions to look for text patterns
		 * "/^[0-9]+$/" 
		 * string only consists of number 0-9
		 */
		if(preg_match("/^[0-9]+$/", $age)) {
			return true;
		}
		return false;
	}
	/**
	 * filter_var is a built-in php function
	 * used to  sanitize and validate data
	 * FILTER_VALIDATION_EMAIL is a built-in php constant
	 */
	public function  validEmail($email) {
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		}
		return false;
	}
	

}


?>
