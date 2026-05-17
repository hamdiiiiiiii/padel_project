<?php
declare(strict_types=1);

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Venue.php';
require_once __DIR__ . '/../models/Court.php';

class VenueController extends Controller
{
    public function __construct(
        private readonly Venue $venueModel = new Venue(),
        private readonly Court $courtModel = new Court()
    ) {}

    public function show(int $id): void
    {
        $venue = $this->venueModel->find($id);

        if (!$venue) {
            $this->redirect('/home');
            return;
        }

        $courts = $this->courtModel->findByVenue($id);

        $this->render('venues/show', [
            'venue' => $venue,
            'courts' => $courts,
            'activePage' => 'booking',
        ]);
    }

    public function checkAvailability(): void
    {
        header('Content-Type: application/json');

        try {
            $courtId  = (int) ($_GET['court_id'] ?? 0);
            $date     = $_GET['date'] ?? date('Y-m-d');

            if ($courtId <= 0) {
                echo json_encode(['success' => false, 'message' => 'Invalid court ID']);
                return;
            }

            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                SELECT id, start_time, end_time, is_available 
                FROM time_slots 
                WHERE court_id = :court_id AND slot_date = :date
                ORDER BY start_time ASC
            ");
            $stmt->execute(['court_id' => $courtId, 'date' => $date]);
            $slots = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'slots' => $slots]);

        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
