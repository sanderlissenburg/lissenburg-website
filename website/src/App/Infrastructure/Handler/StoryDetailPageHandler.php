<?php
declare(strict_types=1);

namespace App\Infrastructure\Handler;

use App\Application\Repository\StoryRepository;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class StoryDetailPageHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private TemplateRendererInterface $template;

    /**
     * @var StoryRepository
     */
    private StoryRepository $storyRepository;

    /**
     * StoryDetailHandler constructor.
     * @param TemplateRendererInterface $template
     */
    public function __construct(
        TemplateRendererInterface $template,
        StoryRepository $storyRepository
    ) {
        $this->template = $template;
        $this->storyRepository = $storyRepository;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $story = $this->storyRepository->getBySlug($request->getAttribute('slug'));

        return new HtmlResponse($this->template->render('app::story-detail-page', [
            'story' => $story,
        ]));
    }
}
