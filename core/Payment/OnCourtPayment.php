<?php

require_once __DIR__ . '/PaymentStrategy.php';

/**
 * OnCourtPayment Strategy
 *
 * Represents cash payment made directly at the court.
 * No card details are required; payment is deferred.
 */
class OnCourtPayment implements PaymentStrategy
{
    /**
     * No validation needed — player pays at the venue.
     */
    public function validate(array $postData): void
    {
        // Nothing to validate for on-court (cash) payment.
    }

    public function getPaymentStatus(): string
    {
        return 'pending';
    }

    public function getType(): string
    {
        return 'on_court';
    }
}
