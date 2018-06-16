<?php

    namespace League;

    class LeagueGenerator {
        public function generate(): array {
            $league = new League([
                new Team('The Creative Prowlers'),
                new Team('The Brute Comets'),
                new Team('The Heavenly Warhawks'),
                new Team('Spirit Squirrels'),
                new Team('Courageous Donkeys'),
                new Team('Magic Zebras'),
                new Team('Magic Hurricanes'),
                new Team('Storm Hedgehogs'),
                new Team('Young Monarchs'),
                new Team('Kalonian Hydras'),
                new Team('Eager Beluga Whales'),
                new Team('Ancient Trolls')
            ]);
            $teams = $league->teams;
            shuffle($teams);
            $matches = [];
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
                    $currentMatch = new Match(
                        $homeTeam,
                        $awayTeam,
                        rand(0, 5),
                        rand(0, 5));
                    $round->matches[] = $currentMatch;
                    $matches[] = $currentMatch;
                }
                $league->rounds[] = $round;
            }

            return [
                'rounds' => $totalRounds,
                'matchesPerRound' => $matchesPerRound,
                'matches' => $matches,
                'league' => $league
            ];
        }

        private function round_robin(array &$array) {
            array_unshift($array, array_splice($array, -2, 1)[0]);
        }
    }
