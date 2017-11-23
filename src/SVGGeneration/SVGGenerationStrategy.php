<?php

namespace TwoDotsTwice\LQIPHP\SVGGeneration;

interface SVGGenerationStrategy
{
    public function toSVG(\SplFileInfo $inputFile) : string;
}
