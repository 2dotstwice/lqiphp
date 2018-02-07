<?php
namespace TwoDotsTwice\LQIPHP\SVGGeneration;

use PHPUnit\Framework\TestCase;
use \TwoDotsTwice\LQIPHP\SVGGeneration\PrimitiveSVGGenerationStrategy as Strategy;

function sys_get_temp_dir() 
{
    return '/test';
}

function exec() 
{
    return null;
}

function file_get_contents() 
{
    return 'test';
}

function unlink() 
{
    return true;
}

function uniqid() 
{
    return '123';
}

class PrimitiveSVGGenerationStrategyTest extends TestCase
{
    /**
     * @test
     */
    public function it_reads_a_file_runs_the_generation_and_returns_content()
    {
        $fileMock = $this->prophesize(\SplFileInfo::class);
        $fileMock->getRealPath()->shouldBeCalled();
        $file = $fileMock->reveal();

        $process = new Strategy();
        $this->assertEquals('test', $process->toSVG($file));
    }
}
