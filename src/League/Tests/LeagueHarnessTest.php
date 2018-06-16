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
            $league = $leagueGenerator->generate();
            $matches = $league['matches'];
            $this->assertEquals(66, count($matches));
        }

        /**
         * @test
         */
        public function should_generate_11_rounds_for_12_teams() {
            $leagueGenerator = new \League\LeagueGenerator();
            $league = $leagueGenerator->generate();
            $rounds = $league['rounds'];
            $this->assertEquals(11, $rounds);
        }

        /**
         * @test
         */
        public function should_generate_6_matches_per_round_for_12_teams() {
            $leagueGenerator = new \League\LeagueGenerator();
            $league = $leagueGenerator->generate();
            $matchesPerRound = $league['matchesPerRound'];
            $this->assertEquals(6, $matchesPerRound);
        }

        /**
         * @test
         */
        public function first_match_should_be_Young_Monarchs_Against_Storm_Hedgehogs() {
            $leagueGenerator = new \League\LeagueGenerator();
            $league = $leagueGenerator->generate();
            $matches = $league['matches'];
            $firstMatch = $matches[0];

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
            $league = $leagueGenerator->generate();
            $matches = $league['matches'];
            $lastMatchIndex = count($matches)-1;
            $firstMatch = $matches[$lastMatchIndex];

            $theHeavenlyWarhawks = new \League\Team("The Heavenly Warhawks");
            $theBruteComets = new \League\Team("The Brute Comets");

            $expectedLastMatch = new \League\Match($theHeavenlyWarhawks, $theBruteComets, 1, 0);
            $this->assertEquals($expectedLastMatch, $firstMatch);
        }

        private function setFixedRandomSeed() {
            mt_srand(0);

        }
    }
