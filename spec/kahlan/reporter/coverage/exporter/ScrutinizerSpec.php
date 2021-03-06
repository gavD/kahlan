<?php
namespace spec\kahlan\reporter\coverage;

use kahlan\reporter\coverage\Collector;
use kahlan\reporter\coverage\driver\Xdebug;
use kahlan\reporter\coverage\exporter\Scrutinizer;
use spec\fixture\reporter\coverage\NoEmptyLine;
use spec\fixture\reporter\coverage\ExtraEmptyLine;

describe("Scrutinizer", function() {

    beforeEach(function() {
        if (!extension_loaded('xdebug')) {
            skipIf(true);
        }
    });

    describe("::export()", function() {

        it("exports the coverage of a file with no extra end line", function() {

            $path = 'spec/fixture/reporter/coverage/NoEmptyLine.php';

            $collector = new Collector([
                'driver'    => new Xdebug(),
                'path'      => $path
            ]);

            $code = new NoEmptyLine();

            $collector->start();
            $code->shallNotPass();
            $collector->stop();

            $time = time();

            $xml = Scrutinizer::export([
                'collector' => $collector,
                'time'      => $time
            ]);

$expected = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<coverage generated="{$time}">
  <project timestamp="{$time}">
    <file name="spec/fixture/reporter/coverage/NoEmptyLine.php">
      <line num="8" type="stmt" count="1"/>
      <line num="10" type="stmt" count="0"/>
      <line num="12" type="stmt" count="1"/>
      <line num="13" type="stmt" count="0"/>
    </file>
    <metrics loc="15" ncloc="11" statements="4" coveredstatements="2"/>
  </project>
</coverage>

EOD;

            expect($xml)->toBe($expected);
        });

        it("exports the coverage of a file with an extra line at the end", function() {

            $path = 'spec/fixture/reporter/coverage/ExtraEmptyLine.php';

            $collector = new Collector([
                'driver'    => new Xdebug(),
                'path'      => $path
            ]);

            $code = new ExtraEmptyLine();

            $collector->start();
            $code->shallNotPass();
            $collector->stop();

            $time = time();

            $xml = Scrutinizer::export([
                'collector' => $collector,
                'time'      => $time
            ]);

$expected = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<coverage generated="{$time}">
  <project timestamp="{$time}">
    <file name="spec/fixture/reporter/coverage/ExtraEmptyLine.php">
      <line num="8" type="stmt" count="1"/>
      <line num="10" type="stmt" count="0"/>
      <line num="12" type="stmt" count="1"/>
      <line num="13" type="stmt" count="0"/>
    </file>
    <metrics loc="16" ncloc="12" statements="4" coveredstatements="2"/>
  </project>
</coverage>

EOD;

            expect($xml)->toBe($expected);

        });

    });

    describe("::write()", function() {

        beforeEach(function() {
            $this->output = tempnam("/tmp", "KAHLAN");
        });

        afterEach(function() {
            unlink($this->output);
        });

        it("writes the coverage to a file", function() {

            $path = 'spec/fixture/reporter/coverage/NoEmptyLine.php';

            $collector = new Collector([
                'driver'    => new Xdebug(),
                'path'      => $path
            ]);

            $code = new NoEmptyLine();

            $collector->start();
            $code->shallNotPass();
            $collector->stop();

            $time = time();

            $success = Scrutinizer::write([
                'collector' => $collector,
                'file'      => $this->output,
                'time'      => $time
            ]);

            expect($success)->toBe(461);

            $xml = file_get_contents($this->output);

$expected = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<coverage generated="{$time}">
  <project timestamp="{$time}">
    <file name="spec/fixture/reporter/coverage/NoEmptyLine.php">
      <line num="8" type="stmt" count="1"/>
      <line num="10" type="stmt" count="0"/>
      <line num="12" type="stmt" count="1"/>
      <line num="13" type="stmt" count="0"/>
    </file>
    <metrics loc="15" ncloc="11" statements="4" coveredstatements="2"/>
  </project>
</coverage>

EOD;

            expect($xml)->toBe($expected);

        });

    });

});
