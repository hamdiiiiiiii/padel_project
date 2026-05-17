<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Reservation.php';

class UserController extends Controller
{
    public function __construct(
        private readonly Reservation $reservationModel = new Reservation()
    ) {}

    public function dashboard(): void
    {
        $this->requireLogin();

        $bookings = $this->reservationModel->getUserReservations((int) $_SESSION['user']['id']);

        $this->render('user/reservations', [
            'bookings' => $bookings,
            'user' => $_SESSION['user'],
        ]);
    }



}
