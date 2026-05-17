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


}
