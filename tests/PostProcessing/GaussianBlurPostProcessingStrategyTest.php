<?php

namespace TwoDotsTwice\LQIPHP\PostProcessing;

use PHPUnit\Framework\TestCase;

class GaussianBlurPostProcessingStrategyTest extends TestCase
{
    /**
     * @var GaussianBlurPostProcessingStrategy
     */
    private $postProcessor;

    public function setUp()
    {
        $this->postProcessor = new GaussianBlurPostProcessingStrategy(12, 'b');
    }

    /**
     * @test
     */
    public function it_should_apply_a_blur_to_the_root_group_tag_if_there_is_one()
    {
        $original = file_get_contents(__DIR__ . '/data/gaussian_blur/original_with_group.xml');
        $expected = file_get_contents(__DIR__ . '/data/gaussian_blur/blur_with_group.xml');
        $actual = $this->postProcessor->process($original);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function it_should_apply_a_blur_to_the_svg_tag_if_there_is_no_root_group_tag()
    {
        $original = file_get_contents(__DIR__ . '/data/gaussian_blur/original_without_group.xml');
        $expected = file_get_contents(__DIR__ . '/data/gaussian_blur/blur_without_group.xml');
        $actual = $this->postProcessor->process($original);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function it_should_return_the_injected_svg_string_as_is_if_the_configured_deviation_is_zero_or_lower()
    {
        $original = file_get_contents(__DIR__ . '/data/gaussian_blur/original_with_group.xml');
        $expected = $original;

        $postProcessorWithDeviationZero = new GaussianBlurPostProcessingStrategy(0, 'b');
        $actualWithDeviationZero = $postProcessorWithDeviationZero->process($original);

        $postProcessorWithNegativeDeviation = new GaussianBlurPostProcessingStrategy(-1, 'b');
        $actualWithNegativeDeviation = $postProcessorWithNegativeDeviation->process($original);

        $this->assertEquals($expected, $actualWithDeviationZero);
        $this->assertEquals($expected, $actualWithNegativeDeviation);
    }
}
