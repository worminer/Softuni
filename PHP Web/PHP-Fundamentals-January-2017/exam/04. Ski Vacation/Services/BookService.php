<?php


namespace Service\Booking;

class BookService implements BookServiceInterface
{



    /**
     * @var DatabaseInterface
     */
    private $db;


    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }


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
    )
    {
        // TODO: Implement book() method.
    }
}