<?php

interface Iapi {


	/**
	 * Confrim transaction.
	 * When a user trigger a payment opertation we'll reply back with the
	 * transaction ID in casses payment succeeded.
	 * User can confirm the payment operation by consuming this API and
	 * call the confirm function passing three parameters ( private key)
	 * (transaction_id) and (amount)
	 * 
	 * private key is generated for developer by encrypting the user ID
	 *
	 *
	 * @param string $private_key
	 * @param string $transaction_id
	 * @param decimal $amount
	 *
	 * @return boolean
	 *
	 */
	public function confirm($private_key, $transaction_id, $amount);




}










