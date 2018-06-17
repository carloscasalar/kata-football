<?php

    namespace League;

    class Run {
        public static function execute() {
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

            $league = new League($teams);
            $league->populateRounds();

            $printer = new LeaguePrinter($league);

            $printer->printAllRounds();
        }
    }
