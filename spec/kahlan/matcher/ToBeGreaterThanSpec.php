<?php
namespace spec\kahlan\matcher;

use kahlan\matcher\ToBeGreaterThan;

describe("toBeGreaterThan", function() {

    describe("::match()", function() {

        it("passes if 2 is > 1", function() {

            expect(2)->toBeGreaterThan(1);

        });

        it("passes if 1 > 0.999", function() {

            expect(1)->toBeGreaterThan(0.999);

        });

        it("passes if 2 is not > 2", function() {

            expect(2)->not->toBeGreaterThan(2);

        });

    });

    describe("::description()", function() {

        it("returns the description message", function() {

            $report['params'] = [
                'actual'   => 1,
                'expected' => 2
            ];

            $actual = ToBeGreaterThan::description($report);

            expect($actual)->toBe('be greater than expected.');

        });

    });

});
