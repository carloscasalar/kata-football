<?php

    class LeagueHarnessTest extends \PHPUnit_Framework_TestCase {

        protected function setUp() {
            $this->setFixedRandomSeed();
        }

        /**
         * @test
         */
        public function should_generate_66_total_matches_for_12_teams() {
            $leagueGenerator = new \League\LeagueGenerator();
            $generation = $leagueGenerator->generate();
            $matches = $generation['matches'];
            $this->assertEquals(66, $matches);
        }

        /**
         * @test
         */
        public function should_generate_11_rounds_for_12_teams() {
            $leagueGenerator = new \League\LeagueGenerator();
            $generation = $leagueGenerator->generate();
            $rounds = $generation['rounds'];
            $this->assertEquals(11, $rounds);
        }

        /**
         * @test
         */
        public function should_generate_6_matches_per_round_for_12_teams() {
            $leagueGenerator = new \League\LeagueGenerator();
            $generation = $leagueGenerator->generate();
            $matchesPerRound = $generation['matchesPerRound'];
            $this->assertEquals(6, $matchesPerRound);
        }

        /**
         * @test
         */
        public function first_match_should_be_Young_Monarchs_Against_Storm_Hedgehogs() {
            $leagueGenerator = new \League\LeagueGenerator();
            $generation = $leagueGenerator->generate();
            $league = $generation['league'];
            $firstMatch = $league->rounds[0]->matches[0];

            $youngMonarchs = new \League\Team("Young Monarchs");
            $stromHedgehogs = new \League\Team("Storm Hedgehogs");

            $expectedFirstMatch = new \League\Match($youngMonarchs, $stromHedgehogs, 2, 0);
            $this->assertEquals($expectedFirstMatch, $firstMatch);
        }


        /**
         * @test
         */
        public function last_match_home_team_should_be_The_Heavenly_Warhawks_Against_The_Brute_Comets() {
            $leagueGenerator = new \League\LeagueGenerator();
            $generation = $leagueGenerator->generate();
            $league = $generation['league'];
            $lastRound = array_pop($league->rounds);
            $lastMatch = array_pop($lastRound->matches);

            $theHeavenlyWarhawks = new \League\Team("The Heavenly Warhawks");
            $theBruteComets = new \League\Team("The Brute Comets");

            $expectedLastMatch = new \League\Match($theHeavenlyWarhawks, $theBruteComets, 1, 0);
            $this->assertEquals($expectedLastMatch, $lastMatch);
        }

        private function setFixedRandomSeed() {
            mt_srand(0);

        }
    }
