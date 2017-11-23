<?php

namespace TwoDotsTwice\LQIPHP\ConsoleCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TwoDotsTwice\LQIPHP\LQIPHP;
use TwoDotsTwice\LQIPHP\PostProcessing\CompositePostProcessingStrategy;
use TwoDotsTwice\LQIPHP\PostProcessing\GaussianBlurPostProcessingStrategy;
use TwoDotsTwice\LQIPHP\PostProcessing\PassthroughPostProcessingStrategy;
use TwoDotsTwice\LQIPHP\SVGGeneration\PrimitiveSVGGenerationStrategy;

class PrimitiveConsoleCommand extends Command
{
    protected function configure()
    {
        $this->setName('lqiphp:primitive')
            ->setDescription('Generate an LQIP using Primitive')
            ->addArgument('inputFile', InputArgument::REQUIRED, 'Absolute path to the original image.')
            ->addOption('numberOfShapes', 'a', InputArgument::OPTIONAL, 'Number of shapes to generate.', 8)
            ->addOption('mode', 'm', InputArgument::OPTIONAL, 'What type of shapes to use.', 1)
            ->addOption('blur', 'b', InputArgument::OPTIONAL, 'Blur deviation', 0);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $primitiveStrategy = new PrimitiveSVGGenerationStrategy(
            'primitive',
            $input->getOption('mode'),
            $input->getOption('numberOfShapes')
        );

        $lqiphp = new LQIPHP(
            $primitiveStrategy,
            new CompositePostProcessingStrategy(
                new GaussianBlurPostProcessingStrategy($input->getOption('blur'))
            )
        );

        $svgContents = $lqiphp->generateFromFile(
            new \SplFileInfo($input->getArgument('inputFile'))
        );

        $output->writeln($svgContents);
    }
}
