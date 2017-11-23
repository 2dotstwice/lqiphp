<?php

namespace TwoDotsTwice\LQIPHP\SVGGeneration;

class PrimitiveSVGGenerationStrategy implements SVGGenerationStrategy
{
    public const MODE_COMBO = 0;
    public const MODE_TRIANGLE = 1;
    public const MODE_RECT = 2;
    public const MODE_ELLIPSE = 3;
    public const MODE_CIRCLE = 4;
    public const MODE_ROTATEDRECT = 5;
    public const MODE_BEZIERS = 6;
    public const MODE_ROTATEDELLIPSE = 7;
    public const MODE_POLYGON = 8;

    /**
     * @var string
     */
    private $primitiveBinaryLocation;

    /**
     * @var int
     */
    private $mode;

    /**
     * @var int
     */
    private $numberOfShapes;

    public function __construct(
        string $primitiveBinaryLocation = 'primitive',
        int $mode = 1,
        int $numberOfShapes = 8
    ) {
        $this->primitiveBinaryLocation = $primitiveBinaryLocation;
        $this->mode = $mode;
        $this->numberOfShapes = $numberOfShapes;
    }

    /**
     * @inheritdoc
     */
    public function toSVG(\SplFileInfo $inputFile) : string
    {
        $inputPath = $inputFile->getRealPath();
        $outputPath = sys_get_temp_dir() . uniqid() . '.svg';

        exec(
            sprintf(
                '%s -i %s -o %s -m %d -n %d',
                $this->primitiveBinaryLocation,
                $inputPath,
                $outputPath,
                $this->mode,
                $this->numberOfShapes
            )
        );

        $contents = file_get_contents($outputPath);
        unlink($outputPath);

        return $contents;
    }
}
