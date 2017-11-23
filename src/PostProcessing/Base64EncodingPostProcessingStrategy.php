<?php

namespace TwoDotsTwice\LQIPHP\PostProcessing;

class Base64EncodingPostProcessingStrategy implements PostProcessingStrategy
{
    /**
     * @var string
     */
    private $prefix;

    public function __construct($prefix = 'data:image/svg+xml;base64,')
    {
        $this->prefix = $prefix;
    }

    public function process(string $svgContents): string
    {
        return $this->prefix . base64_encode($svgContents);
    }
}
