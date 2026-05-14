<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Court.php';

class HomeController extends Controller
{
    public function index(): void
    {
        $courtModel = new Court();
        $courts = $courtModel->getAll();

        $this->render('home/home', [
            'activePage' => 'home',
            'pageStyles' => ['css/home.css'],
            'courts' => $courts,
        ]);
    }
}