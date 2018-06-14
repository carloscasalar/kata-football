<?php

    namespace League;


    class Match {
        public function __construct(Team $homeTeam, Team $awayTeam, int $homeScore, int $awayScore) {
            $this->home_team = $homeTeam;
            $this->away_team = $awayTeam;
            $this->home_score = $homeScore;
            $this->away_score = $awayScore;
            if ($this->home_score > $this->away_score) {
                $this->home_points = 3;
                $this->away_points = 0;
            } elseif ($this->home_score < $this->away_score) {
                $this->home_points = 0;
                $this->away_points = 3;
            } else {
                $this->home_points = 1;
                $this->away_points = 1;
            }
        }
    }
