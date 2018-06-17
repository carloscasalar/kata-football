<?php

    namespace League;


    class TeamResultOrder {
        public function sort(RoundTeamResult $firstResult, RoundTeamResult $secondResult): int {
            $compare = 0;
            if ($firstResult->points > $secondResult->points) {
                $compare = -1;
            } elseif ($firstResult->points < $secondResult->points) {
                $compare = 1;
            } elseif ($firstResult->goalDifference > $secondResult->goalDifference) {
                $compare = -1;
            } elseif ($firstResult->goalDifference < $secondResult->goalDifference) {
                $compare = 1;
            } elseif ($firstResult->goalsFor > $secondResult->goalsFor) {
                $compare = -1;
            } elseif ($firstResult->goalsFor < $secondResult->goalsFor) {
                $compare = 1;
            }

            return $compare;
        }
    }

