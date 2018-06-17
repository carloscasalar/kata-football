# The exercise

This is the initial source code:
```php
<?php
    class Team {
        public function __construct(string $name) {
            $this->name = $name;
        }
    }

    class Match {
        public function __construct(Team $homeTeam, Team $awayTeam, int $homeScore, int $awayScore) {
            $this->home_team = $homeTeam;
            $this->away_team = $awayTeam;
            $this->home_score = $homeScore;
            $this->away_score = $awayScore;
            if ($this->home_score > $this->away_score) {
                $this->home_points = 3;
                $this->away_points = 0;
            } elseif ($this->home_score < $this->away_score) {
                $this->home_points = 0;
                $this->away_points = 3;
            } else {
                $this->home_points = 1;
                $this->away_points = 1;
            }
        }
    }

    function round_robin(array &$array) {
        array_unshift($array, array_splice($array, -2, 1)[0]);
    }

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
    shuffle($teams);
    $matches = [];
    $totalRounds = count($teams) - !(count($teams) % 2);
    $matchesPerRound = floor(count($teams) / 2);
    for ($round = 0; $round < $totalRounds; $round++) {
        round_robin($teams);
        for ($match = 0; $match < $matchesPerRound; $match++) {
            if ($round % 2) {
                $homeTeam = $teams[$match];
                $awayTeam = $teams[count($teams) - 1 - $match];
            } else {
                $homeTeam = $teams[count($teams) - 1 - $match];
                $awayTeam = $teams[$match];
            }
            $matches[] = new Match(
                $homeTeam,
                $awayTeam,
                rand(0, 5),
                rand(0, 5));
        }
    }
?>
```

This code can be refactored as long as there are test that support the refactor.

This code generates matches between some teams with a random result for each one.
 
Your task is to print a team list for a given journey a [regular liga table](https://en.wikipedia.org/wiki/Template:2018_Liga_1_table):
 * Position.
 * Team.
 * Played.
 * Won.
 * Draw.
 * Lost.
 * Goals for.
 * Goals against.
 * Goal difference.
 * Points.
 

The team list should by ordered by:
 * First descendant by points.
 * If there is a tie then by goals scored difference (also descendant).
 * If there is a tie then by goals scored by the team (also descendant).
 * If there is a tie then arbitrary.
 
Also there is a little bug if the number of teams are not even. It should be fixed. 

Final exercise could be launched through composer with the `run` script:

    docker run --rm -it -v /YOUR/LOCAL/PROJECTS/DIR/kata-football:/opt -w /opt shippingdocker/php-composer:latest composer run-script run