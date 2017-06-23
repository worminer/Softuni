<?php

namespace Telephony ;

interface BrowseInterface
{
    public function browse(string $url): string;
}

interface CallInterface
{
    public function call(string $number): string;
}

class SmartPhone implements CallInterface, BrowseInterface
{
    /**
     * @param string $url
     * @return string
     * @throws \Exception
     */
    public function browse(string $url): string
    {
        if (preg_match("/\\d/", $url)) {
            throw new \Exception("Invalid URL!");
        }

        return "Browsing: {$url}!";
    }

    /**
     * @param string $number
     * @return string
     * @throws \Exception
     */
    public function call(string $number): string
    {
        if (!preg_match("/^[\\d]+$/", $number)) {
            throw new \Exception("Invalid number!");
        }

        return "Calling... {$number}";
    }
}

$phone = new SmartPhone();

$phoneNumbers = explode(" ", readLine());
$websites = explode(" ", readLine());

foreach ($phoneNumbers as $phoneNumber) {
    try {
        writeLine($phone->call($phoneNumber));
    } catch (\Exception $ex) {
        writeLine($ex->getMessage());
    }
}

foreach ($websites as $website) {
    try {
        writeLine($phone->browse($website));
    } catch (\Exception $ex) {
        writeLine($ex->getMessage());
    }
}

function readLine(): string
{
    return trim(fgets(STDIN));
}

/**
 * @param $content mixed
 * @return void
 */
function writeLine($content)
{
    echo $content . PHP_EOL;
}
