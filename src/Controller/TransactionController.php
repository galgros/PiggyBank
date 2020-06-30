<?php

namespace App\Controller;

use App\Entity\PiggyBank;
use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\TransactionRepository;
use App\Services\TransactionChecker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/transaction")
 */
class TransactionController extends AbstractController
{
    /**
     * @Route("/", name="transaction_index", methods={"GET"})
     */
    public function index(TransactionRepository $transactionRepository): Response
    {
        $pb = $this->getDoctrine()
            ->getRepository(PiggyBank::class)
            ->findOneBy([]);

        return $this->render('transaction/index.html.twig', [
            'transactions' => $transactionRepository->findAll(),
            "piggyBank" => $pb
        ]);
    }

    /**
     * @Route("/new", name="transaction_new", methods={"GET","POST"})
     */
    public function new(Request $request, TransactionChecker $tc): Response
    {
        $transaction = new Transaction();
        $pb = $this->getDoctrine()
            ->getRepository(PiggyBank::class)
            ->findOneBy([]);
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $data = $form->getData();

            if ($tc->isAllowed($pb, $data->getType(), $data->getAmount())) {

                $avant = $pb->getBalance();
                if($data->getType() == "credit") {
                    $resultat = $avant + $data->getAmount();
                } else {
                    $resultat = $avant - $data->getAmount();
                }
                $pb->setBalance($resultat);
                $entityManager->persist($transaction);
                $entityManager->persist($pb);
                $entityManager->flush();

                return $this->redirectToRoute('transaction_index');
            }

            $this->addFlash('danger', 'oula oula, c\'est pas permis ce que tu fais');
        }

        return $this->render('transaction/new.html.twig', [
            'transaction' => $transaction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="transaction_show", methods={"GET"})
     */
    public function show(Transaction $transaction): Response
    {
        return $this->render('transaction/show.html.twig', [
            'transaction' => $transaction,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="transaction_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Transaction $transaction): Response
    {
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('transaction_index');
        }

        return $this->render('transaction/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="transaction_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Transaction $transaction): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transaction->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($transaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('transaction_index');
    }
}
