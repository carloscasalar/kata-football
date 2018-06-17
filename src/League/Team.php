<?php

    namespace League;

    class Team {
        public function __construct(string $name) {
            $this->name = $name;
        }

        public function equals(Team $team): bool {
            return $this->name === $team->name;
        }
    }
