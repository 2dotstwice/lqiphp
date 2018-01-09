<?php

namespace TwoDotsTwice\LQIPHP\PostProcessing;

class SVGOPostProcessingStrategy implements PostProcessingStrategy
{
    /**
     * @var string
     */
    private $svgoLocation;

    public function __construct(string $svgoLocation)
    {
        $this->svgoLocation = $svgoLocation;
    }

    public function process(string $svgContents): string
    {
        $output = array();

        exec(
            sprintf(
                '%s -s %s -o - --precision=1 --multipass',
                $this->svgoLocation,
                escapeshellarg($svgContents)
            ),
            $output
        );

        return $output[0];
    }
}
