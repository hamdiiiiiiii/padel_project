<?php

require_once __DIR__ . '/PaymentStrategy.php';

/**
 * OnlinePayment Strategy
 *
 * Validates Visa card details submitted via the payment form.
 * Throws InvalidArgumentException with a user-readable message
 * on any validation failure so the outer try/catch in process.php
 * can surface it cleanly.
 */
class OnlinePayment implements PaymentStrategy
{
    /**
     * Validate card holder name, card number, expiry date, and CVV.
     *
     * @throws \InvalidArgumentException
     */
    public function validate(array $postData): void
    {
        $cardHolderName = trim($postData['card_holder_name'] ?? '');
        $cardNumber     = preg_replace('/\D/', '', (string) ($postData['card_number'] ?? ''));
        $expiryDate     = trim($postData['expiry_date'] ?? '');
        $cvv            = trim($postData['cvv'] ?? '');

        if ($cardHolderName === '') {
            throw new \InvalidArgumentException('Cardholder name is required.');
        }

        if (!preg_match('/^\d{13,19}$/', $cardNumber)) {
            throw new \InvalidArgumentException('Card number must be between 13 and 19 digits.');
        }

        if (!preg_match('/^(0[1-9]|1[0-2])\\/(\d{2}|\d{4})$/', $expiryDate)) {
            throw new \InvalidArgumentException('Expiry date must be in MM/YY or MM/YYYY format.');
        }

        if (!preg_match('/^\d{3,4}$/', $cvv)) {
            throw new \InvalidArgumentException('CVV must be 3 or 4 digits.');
        }

        // Check the card has not expired
        [$expiryMonth, $expiryYear] = explode('/', $expiryDate);
        $expiryMonth = (int) $expiryMonth;
        $expiryYear  = (int) $expiryYear;
        if ($expiryYear < 100) {
            $expiryYear += 2000;
        }

        $expiry  = \DateTime::createFromFormat('Y-m-d', sprintf('%04d-%02d-01', $expiryYear, $expiryMonth));
        $current = new \DateTime('first day of this month');

        if ($expiry === false || $expiry < $current) {
            throw new \InvalidArgumentException('The Visa card has expired.');
        }
    }

    public function getPaymentStatus(): string
    {
        return 'paid';
    }

    public function getType(): string
    {
        return 'online';
    }
}
