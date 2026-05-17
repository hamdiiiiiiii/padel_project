<?php

require_once __DIR__ . '/../BookingObserver.php';

/**
 * AdminNotificationObserver
 *
 * Inserts a notification into the `notifications` table targeted at
 * admin users (type = 'admin', user_id = NULL) whenever a new
 * reservation is created.
 */
class AdminNotificationObserver implements BookingObserver
{
    public function __construct(private readonly \PDO $db) {}

    public function onReservationCreated(array $data): void
    {
        $message = sprintf(
            'New booking #%d: %s booked court "%s" on %s from %s to %s.',
            $data['reservation_id'],
            $data['user_name'],
            $data['court_name'],
            $data['date'],
            substr($data['start_time'], 0, 5),
            substr($data['end_time'],   0, 5)
        );

        $stmt = $this->db->prepare(
            'INSERT INTO notifications (type, user_id, message)
             VALUES (:type, NULL, :message)'
        );
        $stmt->execute([
            'type'    => 'admin',
            'message' => $message,
        ]);
    }
}
