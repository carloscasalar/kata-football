<?php

    class LeagueGeneratorTest extends \PHPUnit_Framework_TestCase {

        protected function setUp() {
            $this->setFixedRandomSeed();
        }

        /**
         * @test
         */
        public function for_12_teams_should_generate_a_league_with_11_rounds() {
            $leagueGenerator = new \League\LeagueGenerator();
            $output = $leagueGenerator->generate();
            $league = $output['league'];
            $this->assertEquals(11, count($league->rounds));
        }


        /**
         * @test
         */
        public function for_12_teams_league_first_round_number_should_be_one() {
            $leagueGenerator = new \League\LeagueGenerator();
            $output = $leagueGenerator->generate();
            $league = $output['league'];
            $firstRound = $league->rounds[0];
            $this->assertEquals(1, $firstRound->number);
        }

        /**
         * @test
         */
        public function for_12_teams_league_last_round_number_should_be_eleven() {
            $leagueGenerator = new \League\LeagueGenerator();
            $output = $leagueGenerator->generate();
            $league = $output['league'];
            $lastRound = array_pop($league->rounds);
            $this->assertEquals(11, $lastRound->number);
        }

        private function setFixedRandomSeed() {
            mt_srand(0);
        }
    }
