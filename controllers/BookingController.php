<?php

require_once __DIR__ . '/../core/Controller.php';

class BookingController extends Controller
{
    public function booking(): void
    {
        $this->render('booking/index', [
            'activePage' => 'booking',
            'pageStyles' => ['css/book.css'],
        ]);
    }

    public function payment(): void
    {
        $this->render('payment/index', [
            'activePage' => 'booking',
            'pageStyles' => ['css/payment.css'],
        ]);
    }

    public function reservation(): void
    {
        $this->render('reservation/index', [
            'activePage' => 'booking',
            'pageStyles' => ['css/reservation.css'],
        ]);
    }
}
