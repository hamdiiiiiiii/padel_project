<?php

/**
 * BookingObserver Interface
 *
 * Every observer that wants to react to a ReservationCreated event
 * must implement this interface.
 *
 * The $reservationData array contains:
 *   - reservation_id (int)
 *   - user_id        (int)
 *   - user_name      (string)
 *   - court_id       (int)
 *   - court_name     (string)
 *   - date           (string)  YYYY-MM-DD
 *   - start_time     (string)  HH:MM:SS
 *   - end_time       (string)  HH:MM:SS
 *   - payment_type   (string)  'on_court' | 'online'
 *   - total_price    (float)
 */
interface BookingObserver
{
    public function onReservationCreated(array $reservationData): void;
}
