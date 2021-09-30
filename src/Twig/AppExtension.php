<?php

namespace App\Twig;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use App\Repository\StatisticRepository;

class AppExtension extends AbstractExtension
{
    private $statisticRepo;
    public function __construct(StatisticRepository $statisticRepo)
    {
        $this->statisticRepo = $statisticRepo;
    }
    public function getFunctions()
    {
        return [
            new TwigFunction('check_statistic_exists', [$this, 'checkStatisticExists']),
        ];
    }

    public function checkStatisticExists(int $idBeer, int $idClient)
    {
        return $this->statisticRepo->checkIfAlreadyScored($idBeer, $idClient);
    }
}