<?php

    namespace League;

    class LeaguePrinter {
        private $league;

        public function __construct(League $league) {
            $this->league = $league;
        }

        public function printAllRounds() {
            $this->printHeader();

            foreach ($this->league->rounds as $round) {
                $roundResults = $this->league->getTableResultsForRound($round->number);
                $this->printRoundResults($round, $roundResults);
            }
        }

        private function printHeader() {
            print("League results by round\n");
            print("=======================\n\n");
        }

        private function printRoundResults(Round $round, array $results) {
            print("Round $round->number\n");
            print("Position Team                       Played Won Draw Lost For Against Difference Points\n");
            print("======== =========================  ====== === ==== ==== === ======= ========== ======\n");

            foreach ($results as $index => $result) {
                $position = $index + 1;
                $this->printResultRow($position, $result);
            }

            print("======================================================================================\n\n");
        }

        private function printResultRow($position, RoundTeamResult $result) {
            printf("%s %s %s %s %s %s %s %s %s %s\n",
                str_pad($position, 8, " ", STR_PAD_LEFT),
                str_pad($result->team->name, 25, " ", STR_PAD_RIGHT),
                str_pad($result->numberOfMatchesPlayed, 7, " ", STR_PAD_LEFT),
                str_pad($result->wins, 3, " ", STR_PAD_LEFT),
                str_pad($result->draws, 4, " ", STR_PAD_LEFT),
                str_pad($result->lost, 4, " ", STR_PAD_LEFT),
                str_pad($result->goalsFor, 3, " ", STR_PAD_LEFT),
                str_pad($result->goalsAgainst, 7, " ", STR_PAD_LEFT),
                str_pad($result->goalDifference, 10, " ", STR_PAD_LEFT),
                str_pad($result->points, 6, " ", STR_PAD_LEFT)
            );
        }
    }