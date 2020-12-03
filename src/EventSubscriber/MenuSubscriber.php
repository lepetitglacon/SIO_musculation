<?php

namespace App\EventSubscriber;

use App\Kernel;
use App\Repository\ArticleRepository;
use App\Repository\RubriqueRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class MenuSubscriber implements EventSubscriberInterface
{

    private $twig;
    private $articles;
    private $rubriques;

    public function __construct(Environment $twig, ArticleRepository $articles, RubriqueRepository $rubriques)
    {
        $this->twig = $twig;
        $this->articleRepositiory = $articles;
        $this->categoryRepository = $rubriques;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $this->twig->addGlobal('articles', $this->articleRepositiory->findAll());
        $this->twig->addGlobal('menu', $this->categoryRepository->findAll());
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController'
        ];
    }
}
