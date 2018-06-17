<?php
    /**
     * Created by IntelliJ IDEA.
     * User: carloscasalar
     * Date: 16/6/18
     * Time: 23:32
     */

    namespace League;


    class RoundTeamResult {
        public $team;
        public $numberOfMatchesPlayed;
        public $goalsFor;

        public function __construct(Team $team, array $matchesPlayed) {
            $this->team = $team;

            $this->numberOfMatchesPlayed = count($matchesPlayed);

            $this->goalsFor = array_reduce($matchesPlayed, function(int $goalsFor, Match $match) use ($team){
                return $goalsFor + $match->goalsScoredBy($team);
            }, 0);
        }
    }