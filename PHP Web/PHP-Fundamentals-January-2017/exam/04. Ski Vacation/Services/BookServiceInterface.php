<?php


namespace Service\Booking;

interface BookServiceInterface
{


    public function book(string $firstName,
                             string $lastName,
                             string $phone,
                             string $email,
                             int $accommodation,
                             int $childNumber,
                             int $adultNumber,
                             int $roomNumber,
                             \DateTime $checkIn,
                             \DateTime $checkOut,
                             bool $liftPass,
                             bool $skiInstructor
    );


}