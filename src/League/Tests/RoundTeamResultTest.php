<?php

    namespace League\Tests;

    use League\League;
    use League\Match;
    use League\Round;
    use League\RoundTeamResult;
    use League\Team;

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
            $round = new Round(TestConst::FIRST_ROUND);

            $round->matches[] = new Match($this->teamA, $this->teamB, TestConst::TWO_GOALS, TestConst::ONE_GOAL);

            $league = new League([$this->teamA, $this->teamB]);
            $league->rounds[] = $round;

            $teamAResult = $league->getTeamResultForRound($this->teamA, TestConst::FIRST_ROUND);
            $this->assertSame(TestConst::ONE_MATCH, $teamAResult->numberOfMatchesPlayed, 'Team A should have play one match');
            $this->assertSame(TestConst::TWO_GOALS, $teamAResult->goalsFor, 'Team A should have score two goals');
            $this->assertSame(TestConst::ONE_GOAL, $teamAResult->goalsAgainst, 'Team A should have one goal against');
            $this->assertSame(TestConst::ONE_GOAL, $teamAResult->goalDifference, 'Team A difference should be 1 (= 2 for - 1 against)');
            $this->assertSame(TestConst::THREE_POINTS, $teamAResult->points, "Tam A should have 3 points as it has won the only match");
            $this->assertSame(TestConst::ONE_MATCH, $teamAResult->wins, "Tam A should have won one match");
            $this->assertSame(TestConst::ZERO_MATCHES, $teamAResult->lost, "Tam A should have lost zero matches");
            $this->assertSame(TestConst::ZERO_MATCHES, $teamAResult->draws, "Tam A should have tied zero matches");

            $teamBResult = $league->getTeamResultForRound($this->teamB, TestConst::FIRST_ROUND);
            $this->assertSame(TestConst::ONE_MATCH, $teamBResult->lost, "Tam B should have lost one matches");
            $this->assertSame(TestConst::ZERO_MATCHES, $teamBResult->draws, "Tam B should have tied zero matches");
        }

        /**
         * Creates a League of four teams: A, B, C, D
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
            $firstRound = new Round(TestConst::FIRST_ROUND);
            $firstRound->matches[] = new Match($this->teamA, $this->teamB, TestConst::ONE_GOAL, TestConst::ZERO_GOALS);
            $firstRound->matches[] = new Match($this->teamC, $this->teamD, TestConst::ZERO_GOALS, TestConst::ZERO_GOALS);

            $secondRound = new Round(TestConst::SECOND_ROUND);
            $secondRound->matches[] = new Match($this->teamA, $this->teamC, TestConst::TWO_GOALS, TestConst::ONE_GOAL);
            $secondRound->matches[] = new Match($this->teamB, $this->teamD, TestConst::TWO_GOALS, TestConst::TWO_GOALS);

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
                "A", TestConst::ONE_MATCH, // teamName, played
                TestConst::ONE_MATCH, TestConst::ZERO_MATCHES, TestConst::ZERO_MATCHES, // won, draw, lost
                TestConst::ONE_GOAL, TestConst::ZERO_GOALS, TestConst::ONE_GOAL, // for, against, diff
                TestConst::THREE_POINTS // points
            );

            $resultForTeamARoundOne = $this->formatResult($league->getTeamResultForRound($this->teamA, TestConst::FIRST_ROUND));
            $this->assertSame($expectedResultForTeamARoundOne, $resultForTeamARoundOne, "Team A results form round one does not match");

            $expectedResultForTeamARoundTwo = $this->resultString(
                "A", TestConst::TWO_MATCHES, // teamName, played
                TestConst::TWO_MATCHES, TestConst::ZERO_MATCHES, TestConst::ZERO_MATCHES, // won, draw, lost
                TestConst::THREE_GOALS, TestConst::ONE_GOAL, TestConst::TWO_GOALS, // for, against, diff
                TestConst::SIX_POINTS // points
            );

            $resultForTeamARoundTwo = $this->formatResult($league->getTeamResultForRound($this->teamA, TestConst::SECOND_ROUND));
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