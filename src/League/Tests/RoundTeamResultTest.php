<?php

    namespace League\Tests;

    use League\League;
    use League\Match;
    use League\Round;
    use League\Team;

    const FIRST_ROUND = 1;

    const ONE_MATCH = 1;
    const ZERO_MATCHES = 0;

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

            $teamAResult = $league->getTeamResultForRound($teamA, FIRST_ROUND);
            $this->assertSame(ONE_MATCH, $teamAResult->numberOfMatchesPlayed, 'Team A should have play one match');
            $this->assertSame(TWO_GOALS, $teamAResult->goalsFor, 'Team A should have score two goals');
            $this->assertSame(ONE_GOAL, $teamAResult->goalsAgainst, 'Team A should have one goal against');
            $this->assertSame(ONE_GOAL, $teamAResult->goalDifference, 'Team A difference should be 1 (= 2 for - 1 against)');
            $this->assertSame(THREE_POINTS, $teamAResult->points, "Tam A should have 3 points as it has won the only match");
            $this->assertSame(ONE_MATCH, $teamAResult->wins, "Tam A should have won one match");
            $this->assertSame(ZERO_MATCHES, $teamAResult->lost, "Tam A should have lost zero matches");

            $teamBResult = $league->getTeamResultForRound($teamB, FIRST_ROUND);
            $this->assertSame(ONE_MATCH, $teamBResult->lost, "Tam B should have lost one matches");

        }
    }