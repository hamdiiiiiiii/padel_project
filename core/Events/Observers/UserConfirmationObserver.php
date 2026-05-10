<?php

require_once __DIR__ . '/../BookingObserver.php';

/**
 * UserConfirmationObserver
 *
 * Inserts a personalised confirmation notification into the
 * `notifications` table for the booking user (type = 'user').
 * The reservations page reads and displays these as a success banner,
 * then marks them as read.
 */
class UserConfirmationObserver implements BookingObserver
{
    public function __construct(private readonly \PDO $db) {}

    public function onReservationCreated(array $data): void
    {
        $message = sprintf(
            'Your booking for court "%s" on %s from %s to %s is confirmed! (Booking #%d)',
            $data['court_name'],
            $data['date'],
            substr($data['start_time'], 0, 5),
            substr($data['end_time'],   0, 5),
            $data['reservation_id']
        );

        $stmt = $this->db->prepare(
            'INSERT INTO notifications (type, user_id, message)
             VALUES (:type, :user_id, :message)'
        );
        $stmt->execute([
            'type'    => 'user',
            'user_id' => $data['user_id'],
            'message' => $message,
        ]);
    }
}
