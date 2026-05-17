<?php

require_once __DIR__ . '/../core/Model.php';

class Reservation extends Model
{
    public function create(array $data): bool
    {
        $sql = 'INSERT INTO reservations (user_id, court_id, reservation_date, start_time, end_time, total_price, status, payment_type, payment_status) 
                VALUES (:user_id, :court_id, :reservation_date, :start_time, :end_time, :total_price, :status, :payment_type, :payment_status)';

        return $this->query($sql, [
            'user_id' => $data['user_id'],
            'court_id' => $data['court_id'],
            'reservation_date' => $data['reservation_date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'total_price' => $data['total_price'],
            'status' => $data['status'] ?? 'pending',
            'payment_type' => $data['payment_type'],
            'payment_status' => $data['payment_status'] ?? 'pending',
        ])->rowCount() > 0;
    }

    public function getUserReservations(int $userId): array
    {
        $sql = 'SELECT r.*, c.name AS court_name, v.name AS venue_name 
                FROM reservations r
                LEFT JOIN courts c ON c.id = r.court_id
                LEFT JOIN venues v ON v.id = c.venue_id
                WHERE r.user_id = :user_id
                ORDER BY r.reservation_date DESC, r.start_time DESC';

        $stmt = $this->query($sql, ['user_id' => $userId]);
        return $stmt->fetchAll();
    }
}
