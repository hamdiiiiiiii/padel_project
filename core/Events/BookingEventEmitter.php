<?php

require_once __DIR__ . '/BookingObserver.php';


class BookingEventEmitter
{
    /** @var BookingObserver[] */
    private array $observers = [];

    public function subscribe(BookingObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    /**
     * Notify all registered observers with the reservation data.
     * Failures in individual observers are caught and logged to
     * stderr so one bad observer never breaks the booking flow.
     *
     * @param array $reservationData  See BookingObserver for keys.
     */
    public function emit(array $reservationData): void
    {
        foreach ($this->observers as $observer) {
            try {
                $observer->onReservationCreated($reservationData);
            } catch (\Throwable $e) {
                // Never let an observer crash the main flow
                error_log(
                    '[BookingEventEmitter] Observer ' . get_class($observer) .
                    ' failed: ' . $e->getMessage()
                );
            }
        }
    }
}
