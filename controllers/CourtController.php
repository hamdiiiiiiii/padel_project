<<<<<<< Updated upstream
<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Court.php';

class CourtController extends Controller
{
    public function index(): void
    {
        $courtModel = new Court();
        $courts = $courtModel->getAll();

        $this->render('courts/index', [
            'courts' => $courts,
            'activePage' => 'courts',
        ]);
    }

    public function show(int $id): void
    {
        $courtModel = new Court();
        $court = $courtModel->find($id);

        if (!$court) {
            http_response_code(404);
            echo 'Court not found.';
            return;
        }

        $this->render('courts/show', [
            'court' => $court,
            'activePage' => 'courts',
        ]);
    }
}
=======
<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Court.php';

class CourtController extends Controller
{
    public function index(): void
    {
        $courtModel = new Court();
        $courts = $courtModel->getAll();

        $this->render('courts/index', [
            'courts' => $courts,
            'activePage' => 'courts',
        ]);
    }

    public function show(int $id): void
    {
        $courtModel = new Court();
        $court = $courtModel->find($id);

        if (!$court) {
            http_response_code(404);
            echo 'Court not found.';
            return;
        }

        $this->render('courts/show', [
            'court' => $court,
            'activePage' => 'courts',
        ]);
    }
}
>>>>>>> Stashed changes
