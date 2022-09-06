<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\BlockBundle\Block;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\BlockContextManagerInterface;
use Sonata\BlockBundle\Block\BlockRendererInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Block\Service\BlockServiceInterface;
// use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Setono\PhpTemplates\Engine\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

class ReferenceBlockService extends AbstractBlockService implements BlockServiceInterface
{
    protected $blockRenderer;

    protected $blockContextManager;

    /**
     * @param string                       $name
     * @param EngineInterface              $templating
     * @param BlockRendererInterface       $blockRenderer
     * @param BlockContextManagerInterface $blockContextManager
     */
    public function __construct($name, EngineInterface $templating, BlockRendererInterface $blockRenderer, BlockContextManagerInterface $blockContextManager, $projectDir)
    {
        $templatePath = $projectDir.'/templates';

        $loader = new \Twig\Loader\FilesystemLoader($templatePath);
        $templating = new \Twig\Environment($loader);
        $templating->addExtension(new \Sonata\BlockBundle\Twig\Extension\BlockExtension());

        parent::__construct($templating);
        $this->blockRenderer = $blockRenderer;
        $this->blockContextManager = $blockContextManager;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, ?Response $response = null): Response
    {
        if (!$response) {
            $response = new Response();
        }

        // if the reference target block does not exist, we just skip the rendering
        if ($blockContext->getBlock()->getEnabled() && null !== $blockContext->getBlock()->getReferencedBlock()) {
            $referencedBlockContext = $this->blockContextManager->get($blockContext->getBlock()->getReferencedBlock());

            $response = $this->blockRenderer->render($referencedBlockContext);
        }

        return $response;
    }
}
