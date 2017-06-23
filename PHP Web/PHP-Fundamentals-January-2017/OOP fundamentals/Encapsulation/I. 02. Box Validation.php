<?php
namespace boxvalidation;
class Box
{
    private $length;
    private $width;
    private $height;

    public function __construct(float $length, float $width, float $height)
    {
        $this->setLength($length);
        $this->setWidth($width);
        $this->setHeight($height);
    }

    public function getSurfaceArea(): float
    {
        return 2 * $this->length * $this->width
        + 2 * $this->length * $this->height
        + 2 * $this->width * $this->height;
    }

    public function getLateralSurfaceArea(): float
    {
        return 2 * $this->length * $this->height
        + 2 * $this->width * $this->height;
    }

    public function getVolume(): float
    {
        return $this->length * $this->height * $this->width;
    }

    private function setLength(float $length)
    {
        if ($length <= 0){
            throw new \Exception("Length cannot be zero or negative.");
        }
        $this->length = $length;
    }

    private function setWidth(float $width)
    {
        if ($width <= 0){
            throw new \Exception("Width cannot be zero or negative.");
        }
        $this->width = $width;
    }

    private function setHeight(float $height)
    {
        if ($height <= 0){
            throw new \Exception("Height cannot be zero or negative.");
        }
        $this->height = $height;
    }

    public function __toString()
    {
        $output = "Surface Area - " . number_format($this->getSurfaceArea(), 2, ".", "").PHP_EOL;
        $output .= "Lateral Surface Area - " . number_format($this->getLateralSurfaceArea(), 2, ".", "").PHP_EOL;
        $output .= "Volume - " . number_format($this->getVolume(), 2, ".", "").PHP_EOL;
        return $output;

    }
}


$length = trim(fgets(STDIN));
$width = trim(fgets(STDIN));
$height = trim(fgets(STDIN));

try {
    echo new Box($length, $width, $height);
} catch (\Exception $e) {
    echo $e->getMessage();
}