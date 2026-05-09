<?php

require_once __DIR__ . '/../core/Controller.php';
//  We need to import the Court model to use it here
require_once __DIR__ . '/../models/Court.php'; 

class HomeController extends Controller
{
    public function index(): void
    {
        // 1. Create an instance of the Court model
        $courtModel = new Court(); 

        // 2. Fetch all courts from the database 
        $courts = $courtModel->getAll(); 

        // 3. Pass the $courts variable to the view
        $this->render('home/home', [
            'courts'     => $courts,      // This allows your foreach loop to work!
            'activePage' => 'home',
            'pageStyles' => ['css/home.css'],
        ]);
    }
}