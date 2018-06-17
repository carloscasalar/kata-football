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
            for ($matchIndex = 0; $matchIndex < $numberOfMatches; $matchIndex++) {
                if ($this->isOddRound()) {
                    $homeTeam = $teams[$matchIndex];
                    $awayTeam = array_reverse($teams)[$matchIndex];
                } else {
                    $homeTeam = array_reverse($teams)[$matchIndex];
                    $awayTeam = $teams[$matchIndex];
                }

                if($this->doBothTeamsPlay($homeTeam, $awayTeam)){
                    $this->matches[] = new Match(
                        $homeTeam,
                        $awayTeam,
                        rand(0, 5),
                        rand(0, 5));
                }
            }
        }

        private function doBothTeamsPlay(Team $homeTeam, Team $awayTeam): bool{
            return $homeTeam->doPlay() && $awayTeam->doPlay();
        }



        private function isEvenRound(): bool {
            return $this->number % 2;
        }

        private function isOddRound(): bool {
            return !$this->isEvenRound();
        }

        public function getMatchesPlayedBy(Team $team): array {
            return array_filter($this->matches, function (Match $match) use ($team){
                return $match->doTeamPlay($team);
            });
        }
    }