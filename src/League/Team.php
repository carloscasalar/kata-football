<?php

    namespace League;

    class Team {
        public function __construct(string $name) {
            $this->name = $name;
            $this->doPlay = true;
        }

        public function equals(Team $team): bool {
            return $this->name === $team->name;
        }

        public function doPlay(): bool {
            return $this->doPlay;
        }

        public static function NO_TEAM(): Team {
            $noTeam = new Team("NO TEAM");
            $noTeam->doPlay = false;
            return $noTeam;
        }
    }
