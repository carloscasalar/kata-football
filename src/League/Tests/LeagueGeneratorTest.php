<?php

    class LeagueGeneratorTest extends \PHPUnit_Framework_TestCase {
        /**
         * @test
         */
        public function origin_code_does_not_fail() {
            $leagueGenerator = new \League\LeagueGenerator();
            $leagueGenerator->execute();
        }
    }
