<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Court.php';

class BookingController extends Controller
{
    public function booking(): void
    {
        $courtModel = new Court();
        $courts = $courtModel->getAll();

        $this->render('booking/booking', [
            'activePage' => 'booking',
            'pageStyles' => ['css/book.css'],
            'courts' => $courts,
        ]);
    }

    public function payment(): void
    {
        $this->render('payment/payment', [
            'activePage' => 'booking',
            'pageStyles' => ['css/payment.css'],
        ]);
    }

    public function reservation(): void
    {
        $this->render('reservation', [
            'activePage' => 'booking',
            'pageStyles' => ['css/reservation.css'],
        ]);
    }
}