<?php

namespace App\Controller;

use App\Entity\Beer;
use App\Entity\Country;
use App\Form\ScoreType;
use App\Entity\Category;
use App\Entity\Statistic;
use App\Repository\BeerRepository;
use App\Repository\CountryRepository;
use App\Repository\CategoryRepository;
use App\Repository\StatisticRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BarController extends AbstractController
{
    private $countryRepo;

    private $beerRepo;

    private $categoryRepo;

    private $statisticRepo;

    private $em;

    public function __construct(
        CountryRepository $countryRepo,
        BeerRepository $beerRepo,
        CategoryRepository $categoryRepo,
        StatisticRepository $statisticRepo,
        EntityManagerInterface $em
    )
    {
        $this->countryRepo = $countryRepo;
        $this->beerRepo = $beerRepo;
        $this->categoryRepo = $categoryRepo;
        $this->statisticRepo = $statisticRepo;
        $this->em = $em;
    }

    /**
     * @Route("/", name="bar")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Beer::class);
        $beers = $repository->findAll();

        return $this->render('bar/index.html.twig', [
            'beers' => $beers,
        ]);
    }

    /**
     * @Route("/newbeer", name="create_beer")
     */
    public function createBeer(){
        $entityManager = $this->getDoctrine()->getManager();

        $beer = new Beer();
        $beer->setname('Super Beer');
        $beer->setPublishedAt(new \DateTime());
        $beer->setDescription('Ergonomic and stylish!');

        $entityManager->persist($beer);
        $entityManager->flush();

        return new Response('Saved new beer with id '.$beer->getId());
    }

    /**
     * @Route("/country/{id}", name="country_beer")
     */
    public function countryBeer(Country $country) {
        $beers = $country->getBeers();

        return $this->render('bar/country.html.twig', [
            'country' => $country,
            'beers' => $beers
        ]);
    }

    /**
     * @Route("/category/{id}", name="category_beer")
     */
    public function categoryBeer(Category $category) {
        $beers = $category->getBeers();

        return $this->render('bar/category.html.twig', [
            'category' => $category,
            'beers' => $beers
        ]);
    }

    /**
     * @Route("/menu", name="menu")
     */
    public function mainMenu(string $routeName, int $catId = null): Response
    {
        $categoriesNormal = $this->categoryRepo->findBy(['term' => 'normal']);
        $categoriesSpecial = $this->categoryRepo->findBy(['term' => 'special']);

        return $this->render('_main_menu.html.twig', [
            'route_name' => $routeName,
            'category_id' => $catId,
            'categories_normal' => $categoriesNormal,
            'categories_special' => $categoriesSpecial
        ]);
    }

    /**
     * @Route("/statistics", name="statistics")
     */
    public function statistics() {
        $statistics = $this->statisticRepo->findAll();

        return $this->render('bar/statistics.html.twig', [
            'statistics' => $statistics
        ]);
    }

    /**
     * @Route("/statistic/new/{id}", name="new_statistic")
     */
    public function newStatistic(Beer $beer, Request $request) {

        $statistic = (new Statistic())
            ->setBeer($beer)
            ->setClient($this->getUser()->getClient());

        $form = $this->createForm(ScoreType::class, $statistic);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->em->persist($statistic);
                $this->em->flush();

                $this->addFlash('success', 'Bière notée ! GG');
            } else {
                $errorMessage = $form->getErrors(true)->getChildren()->getMessage();

                $this->addFlash('danger', $errorMessage);
            }

            return $this->redirectToRoute('bar');
        }

        return $this->render('_score_form.html.twig', [
            'form' => $form->createView(),
            'beer_id' => $beer->getId()
        ]);
    }
}
