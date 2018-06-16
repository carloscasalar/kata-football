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

            $league->populateRounds();

            $roundsCount = count($league->rounds);
            $matchesCount = array_reduce($league->rounds, [$this,'sumAllMatches'], 0);
            $matchesPerRound = $matchesCount / $roundsCount;

            return [
                'rounds' => $roundsCount,
                'matchesPerRound' => $matchesPerRound,
                'matches' => $matchesCount,
                'league' => $league
            ];
        }

        private function sumAllMatches(int $totalMatchesCount, Round $currentRound){
            return $totalMatchesCount + count($currentRound->matches);
        }
    }
