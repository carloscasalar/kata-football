<?php

    namespace League;


    class Round {

        public $number;
        public $matches;

        public function __construct(int $number) {
            $this->number = $number;
            $this->matches = [];
        }

        public function populateMatches($teams, $numberOfMatches) {
            for ($match = 0; $match < $numberOfMatches; $match++) {
                if ($this->isOddRound()) {
                    $homeTeam = $teams[$match];
                    $awayTeam = $teams[count($teams) - 1 - $match];
                } else {
                    $homeTeam = $teams[count($teams) - 1 - $match];
                    $awayTeam = $teams[$match];
                }
                $this->matches[] = new Match(
                    $homeTeam,
                    $awayTeam,
                    rand(0, 5),
                    rand(0, 5));
            }
        }

        private function isEvenRound(): bool {
            return $this->number % 2;
        }

        private function isOddRound(): bool {
            return !$this->isEvenRound();
        }
    }