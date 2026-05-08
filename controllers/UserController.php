<<<<<<< Updated upstream
<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Reservation.php';

class UserController extends Controller
{
    public function dashboard(): void
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        $reservationModel = new Reservation();
        $bookings = $reservationModel->getUserReservations((int) $_SESSION['user']['id']);

        $this->render('user/dashboard', [
            'bookings' => $bookings,
            'user' => $_SESSION['user'],
        ]);
    }

    public function reservations(): void
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        $this->render('user/reservations', [
            'activePage' => '',
        ]);
    }
}
=======
<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Reservation.php';

class UserController extends Controller
{
    public function dashboard(): void
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        $reservationModel = new Reservation();
        $bookings = $reservationModel->getUserReservations((int) $_SESSION['user']['id']);

        $this->render('user/dashboard', [
            'bookings' => $bookings,
            'user' => $_SESSION['user'],
        ]);
    }

    public function reservations(): void
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        $this->render('user/reservations', [
            'activePage' => '',
        ]);
    }
}
>>>>>>> Stashed changes
