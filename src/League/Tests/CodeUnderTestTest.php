<?php

    class CodeUnderTestTest extends \PHPUnit_Framework_TestCase {
        /**
         * @test
         */
        public function origin_code_does_not_fail() {
            $codeUnderTest = new \League\CodeUnderTest();
            $codeUnderTest->execute();
        }
    }
