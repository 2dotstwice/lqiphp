<?php

namespace TwoDotsTwice\LQIPHP\PostProcessing;

interface PostProcessingStrategy
{
    public function process(string $svgContents) : string;
}
