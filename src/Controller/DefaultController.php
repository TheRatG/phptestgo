<?php


namespace App\Controller;

use App\Manager\DataManager;
use Certificationy\Loaders\YamlLoader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;

class DefaultController extends Controller
{
    /**
     * @Route(path="/")
     */
    public function indexAction()
    {
        return $this->render(
            'base.html.twig',
            $this->get(DataManager::class)->getInitialData()
        );
    }
}
