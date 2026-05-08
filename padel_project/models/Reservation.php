<?php

require_once __DIR__ . '/../core/Model.php';

class Reservation extends Model
{
    public function create(array $data): bool
    {
        $sql = 'INSERT INTO reservations (user_id, court_id, reservation_date, reservation_time) 
                VALUES (:user_id, :court_id, :reservation_date, :reservation_time)';

        return $this->query($sql, [
            'user_id' => $data['user_id'],
            'court_id' => $data['court_id'],
            'reservation_date' => $data['reservation_date'],
            'reservation_time' => $data['reservation_time'],
        ])->rowCount() > 0;
    }

    public function getUserReservations(int $userId): array
    {
        $sql = 'SELECT r.*, c.name AS court_name 
                FROM reservations r
                LEFT JOIN courts c ON c.id = r.court_id
                WHERE r.user_id = :user_id
                ORDER BY r.reservation_date DESC, r.reservation_time DESC';

        $stmt = $this->query($sql, ['user_id' => $userId]);
        return $stmt->fetchAll();
    }
}
