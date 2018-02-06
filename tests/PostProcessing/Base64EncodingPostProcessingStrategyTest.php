<?php

namespace TwoDotsTwice\LQIPHP\PostProcessing;

use PHPUnit\Framework\TestCase;

class Base64EncodingPostProcessingStrategyTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_return_a_base64_encoded_string_for_the_given_xml_string()
    {
        $expected = file_get_contents(__DIR__ . '/data/base64/base64_result_with_default_prefix.txt');
        $expected = rtrim($expected);

        $source = file_get_contents(__DIR__ . '/data/base64/base64_source.xml');

        $processor = new Base64EncodingPostProcessingStrategy();
        $actual = $processor->process($source);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function it_should_be_configurable_to_use_a_specific_prefix()
    {
        $expected = file_get_contents(__DIR__ . '/data/base64/base64_result_with_custom_prefix.txt');
        $expected = rtrim($expected);

        $source = file_get_contents(__DIR__ . '/data/base64/base64_source.xml');

        $processor = new Base64EncodingPostProcessingStrategy('data:text/plain;base64,');
        $actual = $processor->process($source);

        $this->assertEquals($expected, $actual);
    }
}
