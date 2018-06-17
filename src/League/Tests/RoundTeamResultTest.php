<?php

    namespace League\Tests;

    use League\League;
    use League\Match;
    use League\Round;
    use League\Team;

    const FIRST_ROUND = 1;

    const ONE_MATCH = 1;

    const ZERO_GOALS = 0;
    const ONE_GOAL = 1;
    const TWO_GOALS = 2;

    const THREE_POINTS = 3;

    class RoundTeamResultTest extends \PHPUnit_Framework_TestCase {

        /**
         * @test
         */
        public function a_league_A_and_B_teams_with_one_round_where_A_wins() {
            $teamA = new Team("A");
            $teamB = new Team("B");

            $round = new Round(FIRST_ROUND);

            $round->matches[] = new Match($teamA, $teamB, TWO_GOALS, ONE_GOAL);

            $league = new League([$teamA, $teamB]);
            $league->rounds[] = $round;

            $result = $league->getTeamResultForRound($teamA, FIRST_ROUND);

            $this->assertEquals(ONE_MATCH, $result->numberOfMatchesPlayed, 'Team A should have play one match');
            $this->assertEquals(TWO_GOALS, $result->goalsFor, 'Team A should have score two goals');
            $this->assertEquals(ONE_GOAL, $result->goalsAgainst, 'Team A should have one goal against');
            $this->assertEquals(ONE_GOAL, $result->goalDifference, 'Team A difference should be 1 (= 2 for - 1 against)');
            $this->assertEquals(THREE_POINTS, $result->points, "Tam A should have 3 points as it has won the only match");
            $this->assertSame(ONE_MATCH, $result->wins, "Tam A should have won one match");
        }
    }