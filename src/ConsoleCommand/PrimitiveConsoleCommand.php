<?php

namespace TwoDotsTwice\LQIPHP\ConsoleCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TwoDotsTwice\LQIPHP\LQIPHP;
use TwoDotsTwice\LQIPHP\PostProcessing\Base64EncodingPostProcessingStrategy;
use TwoDotsTwice\LQIPHP\PostProcessing\CompositePostProcessingStrategy;
use TwoDotsTwice\LQIPHP\PostProcessing\GaussianBlurPostProcessingStrategy;
use TwoDotsTwice\LQIPHP\SVGGeneration\PrimitiveSVGGenerationStrategy;

class PrimitiveConsoleCommand extends Command
{
    protected function configure()
    {
        $this->setName('lqiphp:primitive')
            ->setDescription('Generate an LQIP SVG using Primitive and various post-processors')
            ->addArgument('inputFile', InputArgument::REQUIRED, 'Absolute path to the original image.')
            ->addOption('numberOfShapes', 'a', InputOption::VALUE_REQUIRED, 'Number of shapes to generate.', 8)
            ->addOption('mode', 'm', InputOption::VALUE_REQUIRED, 'What type of shapes to use.', 1)
            ->addOption('blur', 'b', InputOption::VALUE_REQUIRED, 'Blur deviation', 0)
            ->addOption('base64', null, InputOption::VALUE_NONE, 'Encode as base64');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $primitiveStrategy = new PrimitiveSVGGenerationStrategy(
            'primitive',
            $input->getOption('mode'),
            $input->getOption('numberOfShapes')
        );

        $postProcessingStrategy = new CompositePostProcessingStrategy();

        if ($input->getOption('blur') > 0) {
            $postProcessingStrategy->register(
                new GaussianBlurPostProcessingStrategy($input->getOption('blur'))
            );
        }

        if ($input->getOption('base64')) {
            $postProcessingStrategy->register(
                new Base64EncodingPostProcessingStrategy()
            );
        }

        $lqiphp = new LQIPHP(
            $primitiveStrategy,
            $postProcessingStrategy
        );

        $svgContents = $lqiphp->generateFromFile(
            new \SplFileInfo($input->getArgument('inputFile'))
        );

        $output->writeln($svgContents);
    }
}
