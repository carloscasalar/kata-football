<?php

    namespace League;

    class League {
        public $teams;
        public $rounds = [];

        public function __construct(array $teams) {
            $this->teams = $teams;
        }

        public function populateRounds() {
            $teams = $this->teams;
            shuffle($teams);
            $totalRounds = count($teams) - !(count($teams) % 2);
            $matchesPerRound = floor(count($teams) / 2);
            for ($roundIndex = 0; $roundIndex < $totalRounds; $roundIndex++) {
                $this->round_robin($teams);
                $numberOfRound = $roundIndex + 1;

                $round = new Round($numberOfRound);
                for ($match = 0; $match < $matchesPerRound; $match++) {
                    if ($roundIndex % 2) {
                        $homeTeam = $teams[$match];
                        $awayTeam = $teams[count($teams) - 1 - $match];
                    } else {
                        $homeTeam = $teams[count($teams) - 1 - $match];
                        $awayTeam = $teams[$match];
                    }
                    $round->matches[] = new Match(
                        $homeTeam,
                        $awayTeam,
                        rand(0, 5),
                        rand(0, 5));
                }
                $this->rounds[] = $round;
            }
        }

        private function round_robin(array &$array) {
            array_unshift($array, array_splice($array, -2, 1)[0]);
        }
    }