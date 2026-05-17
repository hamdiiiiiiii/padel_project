<?php

require_once __DIR__ . '/PaymentStrategy.php';
require_once __DIR__ . '/OnCourtPayment.php';
require_once __DIR__ . '/OnlinePayment.php';

/**
 * PaymentStrategyFactory
 *
 * Sole responsibility: map a raw payment type string to the correct
 * PaymentStrategy instance. This is the only place in the codebase
 * that knows which concrete strategy classes exist.
 *
 * To add a new payment method (e.g. MobileWallet):
 *   1. Create MobileWalletPayment implements PaymentStrategy
 *   2. require_once it here
 *   3. Add 'mobile_wallet' => new MobileWalletPayment() to the match below
 *   Done — PaymentContext and process.php require zero changes.
 */
class PaymentStrategyFactory
{
    /**
     * Create and return the appropriate PaymentStrategy.
     *
     * @param  string $type  Raw type from $_POST (e.g. 'on_court', 'online', 'visa')
     * @return PaymentStrategy
     */
    public static function create(string $type): PaymentStrategy
    {
        // Normalise legacy alias used by the front-end toggle
        if ($type === 'visa') {
            $type = 'online';
        }

        return match ($type) {
            'online'   => new OnlinePayment(),
            'on_court' => new OnCourtPayment(),
            default    => new OnCourtPayment(),  // safe fallback
        };
    }
}
