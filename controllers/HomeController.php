<<<<<<< HEAD
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
=======
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
>>>>>>> 33f0fd7199ed9b6d860ae47c0bc1bd16e492bba8
}