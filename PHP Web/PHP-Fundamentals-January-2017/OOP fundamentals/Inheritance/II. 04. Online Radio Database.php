<?php

namespace Radio ;
$radio = new App();
$radio->start();


class App
{
    const DELIMITER = ";";
    const TIME_DELIMITER = ":";
    const SUCCESS_MESSAGE = "Song added.";

    /**
     * @var $playlist Playlist
     */
    private $playlist = null;

    public function start()
    {
        $this->playlist = new Playlist();

        $this->processInput();
        $this->writeLine($this->playlist);
    }

    private function processInput()
    {
        $numOfSongs = intval($this->readLine());
        for ($i = 0; $i < $numOfSongs; $i++) {
            try {
                $songData = explode(self::DELIMITER, $this->readLine());

                $artist = $songData[0];
                $title = $songData[1];
                $duration = explode(self::TIME_DELIMITER, $songData[2]);
                $minutes = intval($duration[0]);
                $seconds = intval($duration[1]);

                $song = new Song($artist, $title, $minutes, $seconds);

                $this->playlist->AddMedia($song);
                $this->writeLine(self::SUCCESS_MESSAGE);
            } catch (\Exception $ex) {
                $this->writeLine($ex->getMessage());
            }
        }
    }

    private function readLine(): string
    {
        return trim(fgets(STDIN));
    }

    /**
     * @param $content mixed
     * @return void
     */
    private function writeLine($content)
    {
        echo $content . PHP_EOL;
    }
}

class Validator
{
    private function __construct()
    {
    }

    public static function numberIsInRange(int $value, int $min, int $max, bool $inclusive = true): bool
    {
        if ($inclusive) {
            return $value >= $min && $value <= $max;
        }

        return $value > $min && $value < $max;
    }
}







class Playlist
{
    /**
     * @var $songs Song[]
     */
    private $songs = [];
    private $totalMediaLength = 0;

    public function AddMedia(Song $song)
    {
        $this->songs[] = $song;
        $this->totalMediaLength += $song->getDuration();
    }

    public function __toString(): string
    {
        $duration = $this->getMediaDuration();
        $output = "Songs added: {$this->getMediaCount()}" . PHP_EOL;
        $output .= "Playlist length: {$duration["hours"]}h {$duration["minutes"]}m {$duration["seconds"]}s";

        return $output;
    }

    private function getMediaCount(): int
    {
        return count($this->songs);
    }

    private function getMediaDuration(): array
    {
        return [
            "hours" => floor(floor($this->totalMediaLength / 60) / 60),
            "minutes" => str_pad(floor($this->totalMediaLength / 60) % 60, 2, "0", STR_PAD_LEFT),
            "seconds" => str_pad($this->totalMediaLength % 60, 2, "0", STR_PAD_LEFT)
        ];
    }
}







class Song
{
    private $artist;
    private $title;

    /**
     * @var $duration int
     */
    private $duration;

    public function __construct(string $artist, string $title, int $minutes, int $seconds)
    {
        $this->setArtist($artist);
        $this->setTitle($title);
        $this->setDuration($minutes, $seconds);
    }

    protected function setArtist(string $artist)
    {
        if (!Validator::numberIsInRange(strlen($artist), 3, 20)) {
            throw new \Exception("Artist name should be between 3 and 20 symbols.");
        }

        $this->artist = $artist;
    }

    protected function setTitle(string $title)
    {
        if (!Validator::numberIsInRange(strlen($title), 3, 30)) {
            throw new \Exception("Song name should be between 3 and 30 symbols.");
        }

        $this->title = $title;
    }

    protected function setDuration(int $minutes, int $seconds)
    {
        if (!Validator::numberIsInRange($minutes, 0, 14)) {
            throw new \Exception("Song minutes should be between 0 and 14.");
        }

        if (!Validator::numberIsInRange($seconds, 0, 59)) {
            throw new \Exception("Song seconds should be between 0 and 59.");
        }

        $this->duration = $seconds + ($minutes * 60);
    }

    public function getDuration(): int
    {
        return $this->duration;
    }
}






