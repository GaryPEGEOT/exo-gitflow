<?php

namespace App\Controller;

use App\Entity\Rack;
use App\Form\RackType;
use App\Repository\RackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/racks")
 */
class RackController extends AbstractController
{
    /**
     * @Route("/", name="rack_index", methods={"GET"})
     */
    public function index(RackRepository $rackRepository): Response
    {
        return $this->render('rack/index.html.twig', [
            'rack' => $rackRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="rack_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rack = new Rack();
        $form = $this->createForm(RackType::class, $rack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rack);
            $entityManager->flush();

            return $this->redirectToRoute('rack_index');
        }

        return $this->render('rack/new.html.twig', [
            'rack' => $rack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="rack_show", methods={"GET"})
     */
    public function show(Rack $rack): Response
    {
        return $this->render('rack/show.html.twig', [
            'rack' => $rack,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="rack_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rack $rack): Response
    {
        $form = $this->createForm(RackType::class, $rack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rack_index');
        }

        return $this->render('rack/edit.html.twig', [
            'rack' => $rack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="rack_delete", methods={"POST"})
     */
    public function delete(Request $request, Rack $rack): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rack->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rack_index');
    }
}
