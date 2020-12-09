<?php

declare(strict_types=1);

namespace App\Infrastructure\Handler;

use App\Application\ReadModel\Story;
use App\Application\Repository\StoryRepository;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HomePageHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $template;

    /**
     * @var StoryRepository
     */
    private $overviewStoryRepository;

    /**
     * @param TemplateRendererInterface $template
     * @param StoryRepository $overviewStoryRepository
     */
    public function __construct(
        TemplateRendererInterface $template,
        StoryRepository $overviewStoryRepository
    ) {
        $this->template = $template;
        $this->overviewStoryRepository = $overviewStoryRepository;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $longStories = $this->overviewStoryRepository->getPaginated(1, 2, [Story::TYPE_LONG]);
        $shortStories = $this->overviewStoryRepository->getPaginated(1, 5, [Story::TYPE_SHORT]);

        return new HtmlResponse($this->template->render('app::home-page', [
            'longStories' => $longStories,
            'shortStories' => $shortStories,
        ]));
    }
}
