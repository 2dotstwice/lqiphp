<?php

namespace TwoDotsTwice\LQIPHP\PostProcessing;

use PHPUnit\Framework\TestCase;

class CompositePostProcessingStrategyTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_process_the_given_xml_string_by_chaining_every_registered_post_processor()
    {
        $original = '<svg></svg>';
        $afterPostProcessor1 = '<svg processed="1"></svg>';
        $afterPostProcessor2 = '<svg processed="2"></svg>';

        /* @var PostProcessingStrategy|\PHPUnit_Framework_MockObject_MockObject $postProcessor1 */
        $postProcessor1 = $this->createMock(PostProcessingStrategy::class);
        $postProcessor1->expects($this->once())
            ->method('process')
            ->with($original)
            ->willReturn($afterPostProcessor1);

        /* @var PostProcessingStrategy|\PHPUnit_Framework_MockObject_MockObject $postProcessor2 */
        $postProcessor2 = $this->createMock(PostProcessingStrategy::class);
        $postProcessor2->expects($this->once())
            ->method('process')
            ->with($afterPostProcessor1)
            ->willReturn($afterPostProcessor2);

        $compositePostProcessor = new CompositePostProcessingStrategy();
        $compositePostProcessor->register($postProcessor1);
        $compositePostProcessor->register($postProcessor2);

        $expected = $afterPostProcessor2;
        $actual = $compositePostProcessor->process($original);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function it_should_process_the_given_xml_string_by_chaining_every_injected_post_processor()
    {
        $original = '<svg></svg>';
        $afterPostProcessor1 = '<svg processed="1"></svg>';
        $afterPostProcessor2 = '<svg processed="2"></svg>';

        /* @var PostProcessingStrategy|\PHPUnit_Framework_MockObject_MockObject $postProcessor1 */
        $postProcessor1 = $this->createMock(PostProcessingStrategy::class);
        $postProcessor1->expects($this->once())
            ->method('process')
            ->with($original)
            ->willReturn($afterPostProcessor1);

        /* @var PostProcessingStrategy|\PHPUnit_Framework_MockObject_MockObject $postProcessor2 */
        $postProcessor2 = $this->createMock(PostProcessingStrategy::class);
        $postProcessor2->expects($this->once())
            ->method('process')
            ->with($afterPostProcessor1)
            ->willReturn($afterPostProcessor2);

        $compositePostProcessor = new CompositePostProcessingStrategy($postProcessor1, $postProcessor2);

        $expected = $afterPostProcessor2;
        $actual = $compositePostProcessor->process($original);

        $this->assertEquals($expected, $actual);
    }
}
