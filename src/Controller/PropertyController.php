<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/biens", name="property.index")
     */
    public function index(): Response
    {
        $properties = $this->repository->findAllOrderBy('created_at', 'DESC');
        return $this->render('property/index.html.twig', [
            'properties' => $properties
        ]);
    }

    /**
     * @Route("/biens/bien/{id}", name="property.showone")
     * @param type $id
     * @return Response
     */
    public function showOne($id): Response
    {
        $property = $this->repository->find($id);
        return $this->render('property/unique.html.twig', [
            'property' => $property
        ]);
    }

    /**
     * @Route("/biens/recherche/{champ}", name="properties.findallequal")
     * @param type $champ
     * @param Request $request
     * @return Response
     */
    public function findAllEqual($champ, Request $request): Response
    {
        $valeur = $request->get("recherche");
        $properties = $this->repository->findByEqualValue($champ, $valeur);
        return $this->render('property/by_city.html.twig', [
            'properties' => $properties
        ]);
    }

    /**
     * @Route("/biens/recherche/{champ}", name="properties.findbyprice")
     * @param type $champ
     * @param Request $request
     * @return Response
     */
    public function findByPrice($champ, Request $request): Response
    {
        $valeur = $request->get("recherche");
        $properties = $this->repository->findByPrice($champ, $valeur);
        return $this->render('property/by_city.html.twig', [
            'properties' => $properties
        ]);
    }

    /**
     * @Route("/biens/tri/{champ}/{ordre}", name="properties.sort")
     * @param type $champ
     * @param type $ordre
     * @return Response
     */
    public function sort($champ, $ordre): Response
    {
        $properties = $this->repository->findAllOrderBy($champ, $ordre);
        return $this->render('property/index.html.twig', [
            'properties' => $properties
        ]);
    }
}
