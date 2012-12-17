<?php

class return_from_error {

	private $ERRORS = array(
		'-1' => 'This email already exist',
		'-2' => 'This email is wrong',
		'-3' => 'This mobile number already exist',
		'-4' => 'Password and password repeat does not match ',
		'-5' => 'Password less than six characters',
		'-6' => 'Please fill all required fields',
		'-7' => 'login failed ,please check your information again',
		'-8' => 'Wrong verification code',
		'-9' => 'Sorry your account was blocked !',
		'-10' => 'Sorry this user not found !',
		'-21' => "Sorry you do not have enough balance !",
		'-22' => 'You have specified wrong amount !',
		'-23' => 'There are no user with this email/mobile ',
		'-24' => 'You can not transfer to your self ',
		'-25' => 'Operation faield please try again later',
		'-26' => 'Sorry this refund record does not exist',
		'-27' => 'Sorry your requested amount is less than minimum required amount to withdraw'
		
	);

	function __construct()
	{
		
	}

	public function message($code)
	{
		return $this->ERRORS[$code];
	}

}

?>
