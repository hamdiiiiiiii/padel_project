<?php

/**
 * PaymentStrategy Interface
 *
 * Defines the contract that every payment strategy must fulfil.
 * Add new payment methods (e.g. MobileWallet) by creating a new
 * class that implements this interface — zero changes to process.php.
 */
interface PaymentStrategy
{
    /**
     * Validate the raw POST data for this payment method.
     * Throws InvalidArgumentException with a user-readable message on failure.
     *
     * @param array $postData  Raw $_POST data from the payment form.
     * @throws \InvalidArgumentException
     */
    public function validate(array $postData): void;

    /**
     * Return the payment status string to be stored in the DB.
     *
     * @return string  'pending' | 'paid'
     */
    public function getPaymentStatus(): string;

    /**
     * Return the canonical payment type string for the DB.
     *
     * @return string  'on_court' | 'online'
     */
    public function getType(): string;
}
