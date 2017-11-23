<?php

namespace TwoDotsTwice\LQIPHP\PostProcessing;

class GaussianBlurPostProcessingStrategy implements PostProcessingStrategy
{
    /**
     * @var int
     */
    private $deviation;

    /**
     * @var string
     */
    private $filterId;

    public function __construct(
        int $deviation = 12,
        string $filterId = 'b'
    ) {
        $this->deviation = $deviation;
        $this->filterId = $filterId;
    }

    public function process(string $svgContents): string
    {
        if ($this->deviation <= 0) {
            return $svgContents;
        }

        $dom = new \DOMDocument();
        $dom->loadXML($svgContents);

        $blur = $dom->createElement('feGaussianBlur');
        $blur->setAttribute('stdDeviation', $this->deviation);

        $filter = $dom->createElement('filter');
        $filter->setAttribute('id', $this->filterId);
        $filter->appendChild($blur);

        $svg = $dom->getElementsByTagName('svg')->item(0);
        $svg->insertBefore($filter, $svg->firstChild);

        $xpath = new \DOMXPath($dom);
        $xpath->registerNamespace('svg', 'http://www.w3.org/2000/svg');
        $gElements = $xpath->query('//svg:g');

        if ($gElements->length > 0) {
            $blurTarget = $gElements->item(0);
        } else {
            $blurTarget = $svg;
        }

        $blurTarget->setAttribute('filter', 'url(#' . $this->filterId . ')');
        $blurTarget->setAttribute('fill-opacity', '0.5');

        return $dom->saveXML();
    }
}
