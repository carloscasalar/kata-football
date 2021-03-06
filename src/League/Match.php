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

        public function doTeamPlay(Team $team): bool {
            return $this->home_team->equals($team) || $this->away_team->equals($team);
        }

        public function goalsScoredBy(Team $team): int {
            $goals = 0;
            if ($this->home_team->equals($team)) {
                $goals = $this->home_score;
            } elseif ($this->away_team->equals($team)) {
                $goals = $this->away_score;
            }

            return $goals;
        }

        public function goalsScoredAgainst(Team $team): int {
            $goals = 0;
            if ($this->home_team->equals($team)) {
                $goals = $this->away_score;
            } elseif ($this->away_team->equals($team)) {
                $goals = $this->home_score;
            }

            return $goals;
        }

        public function points(Team $team): int {
            $points = 0;
            if ($this->home_team->equals($team)) {
                $points = $this->home_points;
            } elseif ($this->away_team->equals($team)) {
                $points = $this->away_points;
            }

            return $points;
        }

        public function didTeamWin(Team $team): bool {
            $didWin = false;
            if ($this->home_team->equals($team)) {
                $didWin = ($this->home_score > $this->away_score);
            } elseif ($this->away_team->equals($team)) {
                $didWin = ($this->away_score > $this->home_score);
            }

            return $didWin;
        }

        public function didTeamLost($team): bool {
            $didLost = false;
            if ($this->home_team->equals($team)) {
                $didLost = ($this->home_score < $this->away_score);
            } elseif ($this->away_team->equals($team)) {
                $didLost = ($this->away_score < $this->home_score);
            }

            return $didLost;
        }

        public function isDraw(): bool {
            return ($this->home_score === $this->away_score);
        }
    }
