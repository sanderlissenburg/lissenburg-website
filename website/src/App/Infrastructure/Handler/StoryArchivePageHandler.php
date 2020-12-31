<?php
declare(strict_types=1);

namespace App\Infrastructure\Handler;

use App\Application\Repository\StoryRepository;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class StoryArchivePageHandler implements RequestHandlerInterface
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
     * @param TemplateRendererInterface $template
     * @param StoryRepository $storyRepository
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
        $stories = $this->storyRepository->getPaginated(1, 9999);

        return new HtmlResponse($this->template->render('app::archive-page', [
            'stories' => $stories
        ]));
    }
}
