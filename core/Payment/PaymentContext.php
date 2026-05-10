<?php

require_once __DIR__ . '/PaymentStrategy.php';
require_once __DIR__ . '/PaymentStrategyFactory.php';

/**
 * PaymentContext
 *
 * Acts as the context in the Strategy pattern.
 * It receives a validated strategy from PaymentStrategyFactory and
 * delegates all payment-related calls to it.
 *
 * To add a new payment method: see PaymentStrategyFactory — this
 * class requires no changes.
 */
class PaymentContext
{
    private PaymentStrategy $strategy;

    /**
     * @param string $type      Raw payment_type from $_POST (e.g. 'on_court', 'online', 'visa')
     * @param array  $postData  The full $_POST array for validation delegation
     */
    public function __construct(string $type, array $postData)
    {
        // Delegate strategy creation to the factory
        $this->strategy = PaymentStrategyFactory::create($type);

        // Eagerly validate so the constructor throws if data is bad
        $this->strategy->validate($postData);
    }

    /**
     * Return the DB-ready payment status string.
     */
    public function getPaymentStatus(): string
    {
        return $this->strategy->getPaymentStatus();
    }

    /**
     * Return the DB-ready payment type string.
     */
    public function getType(): string
    {
        return $this->strategy->getType();
    }
}
