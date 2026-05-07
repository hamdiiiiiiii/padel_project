<?php

require_once __DIR__ . '/../core/Controller.php';

class HomeController extends Controller
{
    public function index(): void
    {
        $this->render('home/home', [
            'activePage' => 'home',
            'pageStyles' => ['css/home.css'],
        ]);
    }
}