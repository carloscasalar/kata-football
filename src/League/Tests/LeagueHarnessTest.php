<?php

    use League\Match;
    use League\Team;
    use League\League;
    use League\Round;

    class LeagueHarnessTest extends \PHPUnit_Framework_TestCase {

        private $league;

        protected function setUp() {
            $this->setFixedRandomSeed();
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

            $this->league = new League($teams);

            $this->league->populateRounds();
        }

        /**
         * @test
         */
        public function should_generate_66_total_matches_for_12_teams() {
            $matchesCount = array_reduce($this->league->rounds, [$this,'sumAllMatches'], 0);

            $this->assertEquals(66, $matchesCount);
        }

        /**
         * @test
         */
        public function should_generate_11_rounds_for_12_teams() {
            $roundsCount = count($this->league->rounds);
            $this->assertEquals(11, $roundsCount);
        }

        /**
         * @test
         */
        public function should_generate_6_matches_per_round_for_12_teams() {
            $roundsCount = count($this->league->rounds);
            $matchesCount = array_reduce($this->league->rounds, [$this,'sumAllMatches'], 0);
            $matchesPerRound = $matchesCount / $roundsCount;
            $this->assertEquals(6, $matchesPerRound);
        }

        /**
         * @test
         */
        public function first_match_should_be_Young_Monarchs_Against_Storm_Hedgehogs() {
            $firstMatch = $this->league->rounds[0]->matches[0];

            $youngMonarchs = new Team("Young Monarchs");
            $stromHedgehogs = new Team("Storm Hedgehogs");

            $expectedFirstMatch = new Match($youngMonarchs, $stromHedgehogs, 2, 0);
            $this->assertEquals($expectedFirstMatch, $firstMatch);
        }


        /**
         * @test
         */
        public function last_match_home_team_should_be_The_Heavenly_Warhawks_Against_The_Brute_Comets() {
            $lastRound = array_pop($this->league->rounds);
            $lastMatch = array_pop($lastRound->matches);

            $theHeavenlyWarhawks = new Team("The Heavenly Warhawks");
            $theBruteComets = new Team("The Brute Comets");

            $expectedLastMatch = new Match($theHeavenlyWarhawks, $theBruteComets, 1, 0);
            $this->assertEquals($expectedLastMatch, $lastMatch);
        }

        private function setFixedRandomSeed() {
            mt_srand(0);

        }

        private function sumAllMatches(int $totalMatchesCount, Round $currentRound){
            return $totalMatchesCount + count($currentRound->matches);
        }
    }
