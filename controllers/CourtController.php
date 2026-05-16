<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Court.php';

class CourtController extends Controller
{
    public function __construct(
        private readonly Court $courtModel = new Court()
    ) {}

    public function index(): void
    {
        $courts = $this->courtModel->getAll();

        $this->render('courts/index', [
            'courts' => $courts,
            'activePage' => 'courts',
        ]);
    }

    public function show(int $id): void
    {
        $court = $this->courtModel->find($id);

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
