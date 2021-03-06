<?php
namespace spec\kahlan\matcher;

use stdClass;
use kahlan\matcher\ToBeAnInstanceOf;

describe("toBeAnInstanceOf", function() {

    describe("::match()", function() {

        it("passes if an instance of stdClass is an object", function() {

            expect(new stdClass())->toBeAnInstanceOf('stdClass');

        });

        it("passes if an instance of stdClass is not a Exception", function() {

            expect(new stdClass())->not->toBeAnInstanceOf('Exception');

        });

    });


    describe("::description()", function() {

        it("returns the description message", function() {

            $report['params'] = [
                'actual'   => new stdClass(),
                'expected' => 'Exception'
            ];

            $actual = ToBeAnInstanceOf::description($report);

            expect($actual)->toBe('be an instance of expected.');

        });

    });

});
