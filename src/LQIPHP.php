<?php

namespace TwoDotsTwice\LQIPHP;

use TwoDotsTwice\LQIPHP\PostProcessing\PostProcessingStrategy;
use TwoDotsTwice\LQIPHP\SVGGeneration\SVGGenerationStrategy;

class LQIPHP
{
    /**
     * @var SVGGenerationStrategy
     */
    private $svgGenerationStrategy;

    /**
     * @var PostProcessingStrategy
     */
    private $postProcessingStrategy;

    public function __construct(
        SVGGenerationStrategy $svgGenerationStrategy,
        PostProcessingStrategy $postProcessingStrategy
    ) {
        $this->svgGenerationStrategy = $svgGenerationStrategy;
        $this->postProcessingStrategy = $postProcessingStrategy;
    }

    /**
     * @param \SplFileInfo $fileInfo
     *   Input file in png, jpg or gif format.
     *
     * @return string
     *   SVG contents as a string.
     */
    public function generateFromFile(\SplFileInfo $fileInfo) : string
    {
        $svgString = $this->svgGenerationStrategy->toSVG($fileInfo);
        return $this->postProcessingStrategy->process($svgString);
    }
}
