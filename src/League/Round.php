<?php

    namespace League;


    class Round {

        public $number;
        public $matches;

        public function __construct(int $number) {
            $this->number = $number;
            $this->matches = [];
        }
    }