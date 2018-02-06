<?php

namespace TwoDotsTwice\LQIPHP\PostProcessing;

use PHPUnit\Framework\TestCase;

class PassthroughPostProcessingStrategyTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_return_the_given_xml_string_without_making_any_changes()
    {
        $original = file_get_contents(__DIR__ . '/data/passthrough/original.xml');
        $expected = $original;

        $processor = new PassthroughPostProcessingStrategy();
        $actual = $processor->process($expected);

        $this->assertEquals($expected, $actual);
    }
}
