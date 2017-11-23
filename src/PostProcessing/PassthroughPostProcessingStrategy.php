<?php

namespace TwoDotsTwice\LQIPHP\PostProcessing;

class PassthroughPostProcessingStrategy implements PostProcessingStrategy
{
    public function process(string $svgContents): string
    {
        return $svgContents;
    }
}
