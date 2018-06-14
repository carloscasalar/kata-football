<?php

    namespace League;

    class LeagueGenerator {
        public function execute() {

            function round_robin(array &$array) {
                array_unshift($array, array_splice($array, -2, 1)[0]);
            }

            $teams = [
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
            ];
            shuffle($teams);
            $matches = [];
            $totalRounds = count($teams) - !(count($teams) % 2);
            $matchesPerRound = floor(count($teams) / 2);
            for ($round = 0; $round < $totalRounds; $round++) {
                round_robin($teams);
                for ($match = 0; $match < $matchesPerRound; $match++) {
                    if ($round % 2) {
                        $homeTeam = $teams[$match];
                        $awayTeam = $teams[count($teams) - 1 - $match];
                    } else {
                        $homeTeam = $teams[count($teams) - 1 - $match];
                        $awayTeam = $teams[$match];
                    }
                    $matches[] = new Match(
                        $homeTeam,
                        $awayTeam,
                        rand(0, 5),
                        rand(0, 5));
                }
            }
        }
    }
