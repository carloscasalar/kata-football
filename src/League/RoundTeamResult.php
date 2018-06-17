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
        public $wins;
        public $goalsFor;
        public $goalsAgainst;
        public $goalDifference;
        public $points;

        public function __construct(Team $team, array $matchesPlayed) {
            $this->team = $team;

            $this->numberOfMatchesPlayed = count($matchesPlayed);

            $this->goalsFor = array_reduce($matchesPlayed, function (int $totalGoalsFor, Match $match) use ($team) {
                return $totalGoalsFor + $match->goalsScoredBy($team);
            }, 0);

            $this->goalsAgainst = array_reduce($matchesPlayed, function (int $totalGoalsAgainst, Match $match) use ($team) {
                return $totalGoalsAgainst + $match->goalsScoredAgainst($team);
            }, 0);

            $this->goalDifference = $this->goalsFor - $this->goalsAgainst;

            $this->points = array_reduce($matchesPlayed, function (int $totalPoints, Match $match) use ($team) {
                return $totalPoints + $match->points($team);
            }, 0);

            $this->wins = array_reduce($matchesPlayed, function (int $totalwins, Match $match) use ($team) {
                return $totalwins + ($match->didTeamWin($team) ? 1 : 0);
            }, 0);

        }
    }