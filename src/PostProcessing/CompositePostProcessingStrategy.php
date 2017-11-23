<?php

namespace TwoDotsTwice\LQIPHP\PostProcessing;

class CompositePostProcessingStrategy implements PostProcessingStrategy
{
    /**
     * @var PostProcessingStrategy[]
     */
    private $postProcessingStrategies;

    public function __construct(PostProcessingStrategy ...$postProcessingStrategies)
    {
        $this->postProcessingStrategies = $postProcessingStrategies;
    }

    public function register(PostProcessingStrategy $postProcessingStrategy)
    {
        $this->postProcessingStrategies[] = $postProcessingStrategy;
    }

    public function process(string $svgContents) : string
    {
        foreach ($this->postProcessingStrategies as $postProcessingStrategy) {
            $svgContents = $postProcessingStrategy->process($svgContents);
        }
        return $svgContents;
    }
}
