<?php

    namespace League\Tests;

    use League\League;
    use League\Match;
    use League\Round;
    use League\RoundTeamResult;
    use League\Team;

    const FIRST_ROUND = 1;
    const SECOND_ROUND = 2;

    const ZERO_MATCHES = 0;
    const ONE_MATCH = 1;
    const TWO_MATCHES = 2;

    const ZERO_GOALS = 0;
    const ONE_GOAL = 1;
    const TWO_GOALS = 2;
    const THREE_GOALS = 3;

    const THREE_POINTS = 3;
    const SIX_POINTS = 6;

    class RoundTeamResultTest extends \PHPUnit_Framework_TestCase {
        private $teamA;
        private $teamB;
        private $teamC;
        private $teamD;

        protected function setUp() {
            $this->teamA = new Team("A");
            $this->teamB = new Team("B");
            $this->teamC = new Team("C");
            $this->teamD = new Team("D");
        }
        /**
         * @test
         */
        public function a_league_A_and_B_teams_with_one_round_where_A_wins() {
            $round = new Round(FIRST_ROUND);

            $round->matches[] = new Match($this->teamA, $this->teamB, TWO_GOALS, ONE_GOAL);

            $league = new League([$this->teamA, $this->teamB]);
            $league->rounds[] = $round;

            $teamAResult = $league->getTeamResultForRound($this->teamA, FIRST_ROUND);
            $this->assertSame(ONE_MATCH, $teamAResult->numberOfMatchesPlayed, 'Team A should have play one match');
            $this->assertSame(TWO_GOALS, $teamAResult->goalsFor, 'Team A should have score two goals');
            $this->assertSame(ONE_GOAL, $teamAResult->goalsAgainst, 'Team A should have one goal against');
            $this->assertSame(ONE_GOAL, $teamAResult->goalDifference, 'Team A difference should be 1 (= 2 for - 1 against)');
            $this->assertSame(THREE_POINTS, $teamAResult->points, "Tam A should have 3 points as it has won the only match");
            $this->assertSame(ONE_MATCH, $teamAResult->wins, "Tam A should have won one match");
            $this->assertSame(ZERO_MATCHES, $teamAResult->lost, "Tam A should have lost zero matches");
            $this->assertSame(ZERO_MATCHES, $teamAResult->draws, "Tam A should have tied zero matches");

            $teamBResult = $league->getTeamResultForRound($this->teamB, FIRST_ROUND);
            $this->assertSame(ONE_MATCH, $teamBResult->lost, "Tam B should have lost one matches");
            $this->assertSame(ZERO_MATCHES, $teamBResult->draws, "Tam B should have tied zero matches");
        }

        /**
         * Teams: A, B, C, D
         *
         * First round matches:
         *   A vs B: 1 - 0
         *   C vs D: 0 - 0
         *
         * Second round matches:
         *   A vs C: 2 - 1
         *   B vs D: 2 - 2
         *
         * Expected results for round one
         *
         *  Team  Played Won Draw Lost For Against Difference Points
         *   A      1     1    0   0    1    0         1        3
         *   B      1     0    0   1    0    1        -1        0
         *   C      1     0    1   0    0    0         0        1
         *   D      1     0    1   0    0    0         0        1
         *
         * Expected results for round two
         *
         *  Team  Played Won Draw Lost For Against Difference Points
         *   A      2     2    0   0    3    1         2        6
         *   B      2     0    1   1    2    3        -1        1
         *   C      2     0    1   1    0    1        -1        1
         *   D      2     0    2   0    2    2         0        2
         */
        private function ligueOfFourTeamsAndTwoRounds(): League {
            $firstRound = new Round(FIRST_ROUND);
            $firstRound->matches[] = new Match($this->teamA, $this->teamB, ONE_GOAL, ZERO_GOALS);
            $firstRound->matches[] = new Match($this->teamC, $this->teamD, ZERO_GOALS, ZERO_GOALS);

            $secondRound = new Round(SECOND_ROUND);
            $secondRound->matches[] = new Match($this->teamA, $this->teamC, TWO_GOALS, ONE_GOAL);
            $secondRound->matches[] = new Match($this->teamB, $this->teamD, TWO_GOALS, TWO_GOALS);

            $league = new League([$this->teamA, $this->teamB]);
            $league->rounds = [$firstRound, $secondRound];
            return $league;
        }

        /**
         * A Results test
         *
         * * First round matches:
         *   A vs B: 1 - 0
         *
         * Second round matches:
         *   A vs C: 2 - 1
         *
         * Expected results for round one
         *
         *  Team  Played Won Draw Lost For Against Difference Points
         *   A      1     1    0   0    1    0         1        3
         *
         * Expected results for round two
         *
         *  Team  Played Won Draw Lost For Against Difference Points
         *   A      2     2    0   0    3    1         2        6
         *
         * @test
         */
        public function league_with_four_teams_team_A_results() {
            $league = $this->ligueOfFourTeamsAndTwoRounds();

            $expectedResultForTeamARoundOne = $this->resultString(
                "A", ONE_MATCH, // teamName, played
                ONE_MATCH, ZERO_MATCHES, ZERO_MATCHES, // won, draw, lost
                ONE_GOAL, ZERO_GOALS, ONE_GOAL, // for, against, diff
                THREE_POINTS // points
            );

            $resultForTeamARoundOne = $this->formatResult($league->getTeamResultForRound($this->teamA, FIRST_ROUND));
            $this->assertSame($expectedResultForTeamARoundOne, $resultForTeamARoundOne, "Team A results form round one does not match");

            $expectedResultForTeamARoundTwo = $this->resultString(
                "A", TWO_MATCHES, // teamName, played
                TWO_MATCHES, ZERO_MATCHES, ZERO_MATCHES, // won, draw, lost
                THREE_GOALS, ONE_GOAL, TWO_GOALS, // for, against, diff
                SIX_POINTS // points
            );

            $resultForTeamARoundTwo = $this->formatResult($league->getTeamResultForRound($this->teamA, SECOND_ROUND));
            $this->assertSame($expectedResultForTeamARoundTwo, $resultForTeamARoundTwo, "Team A results form round two does not match");
        }

        private function resultString(string $teamName, int $played, int $won, int $draw, int $lost, int $for, int $against, int $diff, int $points) {
            return sprintf(
                "Team  Played Won Draw Lost For Against Difference Points\n"
                . " %s      %d     %d    %d   %d    %d    %d         %d        %d",
                $teamName, $played, $won, $draw, $lost, $for, $against, $diff, $points);
        }

        private function formatResult(RoundTeamResult $result) {
            return $this->resultString(
                $result->team->name, $result->numberOfMatchesPlayed,
                $result->wins, $result->draws, $result->lost,
                $result->goalsFor, $result->goalsAgainst, $result->goalDifference,
                $result->points);
        }

    }