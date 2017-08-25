<?php 

class iplFixtureGenerator {

    public $finished;
    public $error;
    public $matchdaysCreated;
    public $rawMatchesCreated;
    public $matchdayCount;
    private $matchPointer;
    private $matchdayPointer;
    private $teams;
    private $teams1;
    private $teams2;
    public $matches;
    public $freeTicket;
    public $freeTicketIdentifer;

    public function __construct($passedTeams = null) {
        $this->teams = $passedTeams;
        $this->finished = false;
        $this->error = '';
        $this->matchdaysCreated = false;
        $this->rawMatchesCreated = false;
        $this->freeTicket = true;
        $this->freeTicketIdentifer = 'Freeeeeeeeee';
        $this->matchdayCount = 0;
        $this->matchdayPointer = 0;
        $this->matchPointer = 0;
        $this->matches = array();
    }

    public function createMatches() {
        if (!$this->validTeamArray())
            return false;

        $this->matches = array();

        if (count($this->teams) % 2) {
            $this->teams1 = array_slice($this->teams, 0, ceil(count($this->teams)/2));
            $this->teams2 = array_slice($this->teams, ceil(count($this->teams)/2));
            
        }
        else {
            $this->teams1 = array_slice($this->teams, 0, count($this->teams)/2);
            $this->teams2 = array_slice($this->teams, count($this->teams)/2);
        }

        if (!$this->matchdayCount) {
            for ($i = 2; $i < (count($this->teams1) * 2); $i++){
                $this->saveMatchday();
                $this->rotate();
            }
            $this->saveMatchday();
        }
        else {
            if ($this->matchdayCount < 0) {
                 $this->error = 'No negative matchDay count allowed';
                 $this->resetClassState();
                 return true;
            }
            shuffle($this->teams1);
            shuffle($this->teams2);

            if (count($this->teams) >= $this->matchdayCount) {
                for($i = 1; $i < $this->matchdayCount; $i++) {
                    $this->saveMatchday();
                    $this->rotate();
                }
                $this->saveMatchday();
            }
            else {
                for ($i = 2; $i < (count($this->teams1) * 2); $i++){
                    $this->saveMatchday();
                    $this->rotate();
                }
                $this->saveMatchday();
                $diff = $this->matchdayCount - count($this->teams);
                for ($i = 0; $i < $diff; $i++) {
                    $this->matches[] = array();
                }
            }
        }



        $this->finished = true;
        $this->rawMatchesCreated = false;
        $this->matchdaysCreated = true;
        $this->clearPointer();

        return $this->matches;
    }

    private function saveMatchday() {
        for ($i = 0; $i < count($this->teams1); $i++) {
            if ($this->freeTicket || ($this->teams1[$i] != $this->freeTicketIdentifer &&
                                       $this->teams2[$i] != $this->freeTicketIdentifer))
                $matches_tmp[] = array($this->teams1[$i], $this->teams2[$i]);
        }
        $this->matches[] = $matches_tmp;
        return true;
    }

    private function rotate() {
        $temp = $this->teams1[1];
        for($i = 1; $i < (count($this->teams1) - 1); $i++) {
            $this->teams1[$i] = $this->teams1[$i + 1];
        }
        $this->teams1[count($this->teams1) - 1] = end($this->teams2);
        for($i = (count($this->teams2) - 1); $i > 0; $i--) {
            $this->teams2[$i] = $this->teams2[$i - 1];
        }
        $this->teams2[0] = $temp;
        return true;
    }

    private function validTeamArray() {
         if (!is_array($this->teams) || count($this->teams) < 2) {
            $this->error = 'Not enough teams in array => shape passed';
            $this->resetClassState();
            return false;
        }
        return true;
    }

    private function resetClassState() {
        $this->finished = false;
        $this->rawMatchesCreated = false;
        $this->matchdaysCreated = false;
        $this->matches = array();
        $this->clearPointer();
        $this->matchdayCount = 0;
        return true;
    }

    private function clearPointer() {
        $this->matchdayPointer = 0;
        $this->matchPointer = 0;
        return true;
    }

    public function setDates($schedule, $startingDate) {

        $date = $startingDate;
        $schedule[0]['date'] = $date;

        $weekendCount = 0;
        for ($i=1; $i < count($schedule); $i++) { 

            (!$this->isWeekend($date)) ? $date = date('Y-m-d', strtotime('+1 day', strtotime($date))) : $weekendCount++ ;

            if($weekendCount == 2) {
                $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
                $weekendCount =  0;
            }
            $schedule[$i]['date'] = $date;
        }

        return $schedule;
        
    }

    private function isWeekend($date) {
        return (date('N', strtotime($date)) >= 6);
    }

}
?>
