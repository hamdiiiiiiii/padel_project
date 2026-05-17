<?php

require_once __DIR__ . '/../BookingObserver.php';

/**
 * EventLogObserver
 *
 * Appends a timestamped line to logs/events.log every time a new
 * reservation is created. Useful for system-level auditing.
 *
 * Log format:
 *   [2026-05-11 00:38:00] ReservationCreated | id=5 user_id=2 court="Court A" date=2026-05-15 time=10:00-11:00 payment=on_court price=200
 */
class EventLogObserver implements BookingObserver
{
    private string $logFile;

    public function __construct(?string $logFile = null)
    {
        // Default: <project_root>/logs/events.log
        $this->logFile = $logFile ?? dirname(__DIR__, 3) . '/logs/events.log';
    }

    public function onReservationCreated(array $data): void
    {
        // Ensure the logs directory exists
        $logDir = dirname($this->logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }

        $line = sprintf(
            '[%s] ReservationCreated | id=%d user_id=%d user="%s" court="%s" date=%s time=%s-%s payment=%s price=%.2f' . PHP_EOL,
            date('Y-m-d H:i:s'),
            $data['reservation_id'],
            $data['user_id'],
            $data['user_name'],
            $data['court_name'],
            $data['date'],
            substr($data['start_time'], 0, 5),
            substr($data['end_time'],   0, 5),
            $data['payment_type'],
            $data['total_price']
        );

        file_put_contents($this->logFile, $line, FILE_APPEND | LOCK_EX);
    }
}
