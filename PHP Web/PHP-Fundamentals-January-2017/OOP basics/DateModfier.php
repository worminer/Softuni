<?php
class DateModifier {
    private $fistDate;
    private $secondDate;

    /**
     * DateModifier constructor.
     * @param string $fistDate
     * @param string $secondDate
     */
    public function __construct(string $fistDate, string $secondDate)
    {
        $this->fistDate = date_create_from_format("Y m d",$fistDate);
        $this->secondDate = date_create_from_format("Y m d",$secondDate);
    }

    public function getDateDiff(){
        return date_diff($this->fistDate,$this->secondDate,true);
    }

    public function getDaysDiff(){
        return $this->getDateDiff()->days;
    }
}


$fistDate   = trim(fgets(STDIN));
$secondDate = trim(fgets(STDIN));

$dateModifier = new DateModifier($fistDate, $secondDate);

echo $dateModifier->getDaysDiff();