<?php
interface BookingObserver
{
    public function onReservationCreated(array $reservationData): void;
}
