<?php

require_once __DIR__ . '/PaymentStrategy.php';
require_once __DIR__ . '/OnCourtPayment.php';
require_once __DIR__ . '/OnlinePayment.php';

/**
 * PaymentContext
 *
 * Acts as the context in the Strategy pattern.
 * Given a raw payment type string from $_POST, it selects the
 * appropriate PaymentStrategy and delegates all calls to it.
 *
 * To add a new payment method:
 *   1. Create a class that implements PaymentStrategy.
 *   2. Add its type string to the factory match expression below.
 *   3. Done — process.php requires no changes.
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
        // Normalise legacy alias used by the front-end toggle
        if ($type === 'visa') {
            $type = 'online';
        }

        $this->strategy = match ($type) {
            'online'   => new OnlinePayment(),
            'on_court' => new OnCourtPayment(),
            default    => new OnCourtPayment(),   // safe fallback
        };

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
