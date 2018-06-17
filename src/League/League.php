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
                $round->populateMatches($teams, $matchesPerRound);

                $this->rounds[] = $round;

            }
        }

        public function getTeamResultForRound($team, $numberOfRound): RoundTeamResult {
            $roundsPlayed = array_filter($this->rounds, function (Round $round) use ($numberOfRound){
               return $round->number <= $numberOfRound;
            });

            $matchesPlayedByTeam = $this->matchesPlayedByTeamInRounds($team, $roundsPlayed);

            return new RoundTeamResult($team, $matchesPlayedByTeam);
        }

        private function matchesPlayedByTeamInRounds(Team $team, array $rounds): array {
            return array_reduce($rounds, function ($matches, Round $round) use ($team){
                return array_merge($matches, $round->getMatchesPlayedBy($team));
            }, []);
        }

        private function round_robin(array &$array) {
            array_unshift($array, array_splice($array, -2, 1)[0]);
        }

    }