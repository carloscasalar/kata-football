<?php

    namespace League\Tests;

    use League\RoundTeamResult;
    use League\Team;
    use League\TeamResultOrder;

    class TeamResultOrderTest extends \PHPUnit_Framework_TestCase {
        private $order;

        protected function setUp() {
            $this->order = new TeamResultOrder();
        }

        /**
         * @test
         */
        public function most_points_result_should_be_ordered_first() {
            $mostPointTeam = new Team("Z: Most point team");
            $lessPointResult = new Team("A: less point team");

            $greatestPointResult = new RoundTeamResult($mostPointTeam);
            $greatestPointResult->points = TestConst::SIX_POINTS;
            $greatestPointResult->goalDifference = TestConst::ZERO_GOALS;
            $greatestPointResult->goalsFor = TestConst::ZERO_GOALS;

            $lessPointResult = new RoundTeamResult($lessPointResult);
            $lessPointResult->points = TestConst::THREE_POINTS;
            $lessPointResult->goalDifference = TestConst::THREE_GOALS;
            $lessPointResult->goalsFor = TestConst::THREE_GOALS;

            $results = [$lessPointResult, $greatestPointResult];

            $order = $this->order;
            usort($results, function (RoundTeamResult $firstResult, RoundTeamResult $lastResult) use ($order) {
                return $order->sort($firstResult, $lastResult);
            });

            $this->assertSame($results[0]->team->name, $greatestPointResult->team->name, "Greatest point team should be ordered first");
        }

        /**
         * @test
         */
        public function if_tie_in_points_differene_should_be_next_criteria(){
            $mostPointTeam = new Team("Z: six point with three goals difference");
            $lessPointResult = new Team("A: six point with zero goals difference");

            $greatestPointResult = new RoundTeamResult($mostPointTeam);
            $greatestPointResult->points = TestConst::SIX_POINTS;
            $greatestPointResult->goalDifference = TestConst::THREE_GOALS;
            $greatestPointResult->goalsFor = TestConst::ZERO_GOALS;

            $lessPointResult = new RoundTeamResult($lessPointResult);
            $lessPointResult->points = TestConst::SIX_POINTS;
            $lessPointResult->goalDifference = TestConst::ZERO_GOALS;
            $lessPointResult->goalsFor = TestConst::THREE_GOALS;

            $results = [$lessPointResult, $greatestPointResult];

            $order = $this->order;
            usort($results, function (RoundTeamResult $firstResult, RoundTeamResult $lastResult) use ($order) {
                return $order->sort($firstResult, $lastResult);
            });

            $this->assertSame($results[0]->team->name, $greatestPointResult->team->name, "Greatest difference team should be ordered first");
        }

        /**
         * @test
         */
        public function if_tie_in_points_and_differene_then_goalsFor_should_be_next_criteria(){
            $mostPointTeam = new Team("Z: six point with three goals difference and three goals for");
            $lessPointResult = new Team("A: six point with three goals difference and zero goals for");

            $greatestPointResult = new RoundTeamResult($mostPointTeam);
            $greatestPointResult->points = TestConst::SIX_POINTS;
            $greatestPointResult->goalDifference = TestConst::THREE_GOALS;
            $greatestPointResult->goalsFor = TestConst::THREE_GOALS;

            $lessPointResult = new RoundTeamResult($lessPointResult);
            $lessPointResult->points = TestConst::SIX_POINTS;
            $lessPointResult->goalDifference = TestConst::THREE_GOALS;
            $lessPointResult->goalsFor = TestConst::ZERO_GOALS;

            $results = [$lessPointResult, $greatestPointResult];

            $order = $this->order;
            usort($results, function (RoundTeamResult $firstResult, RoundTeamResult $lastResult) use ($order) {
                return $order->sort($firstResult, $lastResult);
            });

            $this->assertSame($results[0]->team->name, $greatestPointResult->team->name, "Greatest goal for team should be ordered first");
        }

    }
