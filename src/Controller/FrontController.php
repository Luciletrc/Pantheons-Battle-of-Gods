<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontController extends AbstractController
{
    #[Route('/', name: 'app_home', defaults: ['_locale' => 'en'], requirements: ['_locale' => 'en|fr'])]
    public function index(): Response
    {
        return $this->render('front/home.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    #[Route('/pantheons', name: 'app_pantheons', defaults: ['_locale' => 'en'], requirements: ['_locale' => 'en|fr'])]
    public function pantheons(): Response
    {
        return $this->render('pages/pantheons/pantheons.html.twig');
    }

    #[Route('/boutique', name: 'app_boutique', defaults: ['_locale' => 'en'], requirements: ['_locale' => 'en|fr'])]
    public function boutique(): Response
    {
        return $this->render('pages/sidebar/boutique.html.twig');
    }

    #[Route('/Pantheon-grec', name: 'app_pgrec', defaults: ['_locale' => 'en'], requirements: ['_locale' => 'en|fr'])]
    public function pgrec(): Response
    {
        return $this->render('pages/pantheons/pantheon-grec.html.twig');
    }

    #[Route('/Pantheon-meso', name: 'app_pmeso', defaults: ['_locale' => 'en'], requirements: ['_locale' => 'en|fr'])]
    public function pmeso(): Response
    {
        return $this->render('pages/pantheons/pantheon-meso.html.twig');
    }

    #[Route('/Pantheon-egypt', name: 'app_pegypt', defaults: ['_locale' => 'en'], requirements: ['_locale' => 'en|fr'])]
    public function pegypt(): Response
    {
        return $this->render('pages/pantheons/pantheon-egypt.html.twig');
    }

    #[Route('/Pantheon-slave', name: 'app_pslave', defaults: ['_locale' => 'en'], requirements: ['_locale' => 'en|fr'])]
    public function pslave(): Response
    {
        return $this->render('pages/pantheons/pantheon-slave.html.twig');
    }

    #[Route('/faq', name: 'app_faq', defaults: ['_locale' => 'en'], requirements: ['_locale' => 'en|fr'])]
    public function faq(): Response
    {
        return $this->render('pages/sidebar/faq.html.twig');
    }

    #[Route('/maj', name: 'app_maj', defaults: ['_locale' => 'en'], requirements: ['_locale' => 'en|fr'])]
    public function maj(): Response
    {
        return $this->render('pages/sidebar/maj.html.twig');
    }

    #[Route('/actualites', name: 'app_actualites', defaults: ['_locale' => 'en'], requirements: ['_locale' => 'en|fr'])]
    public function actualites(): Response
    {
        return $this->render('pages/sidebar/actualites.html.twig');
    }

    #[Route('/jeux', name: 'app_jeux', defaults: ['_locale' => 'en'], requirements: ['_locale' => 'en|fr'])]
    public function jeux(): Response
    {
        return $this->render('pages/jeux.html.twig');
    }

    #[Route('/mentionslegales', name: 'app_mentions', defaults: ['_locale' => 'en'], requirements: ['_locale' => 'en|fr'])]
    public function mentions(): Response
    {
        return $this->render('pages/footer/mentionslegales.html.twig');
    }

    #[Route('/cgu', name: 'app_cgu', defaults: ['_locale' => 'en'], requirements: ['_locale' => 'en|fr'])]
    public function cgu(): Response
    {
        return $this->render('pages/footer/cgu.html.twig');
    }
}
