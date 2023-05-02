<?php

namespace App\Controller;

// use MercurySeries\FlashyBundle\FlashyNotifier;
// use FlashyBundle\FlashyNotifier\FlashyNotifier;
use App\Entity\Livraison;
use App\Form\LivraisonType;
use App\Form\SmsType;
use App\Repository\LivraisonRepository;
use App\Repository\UtilisateurRepository;
use App\Service\TwilioClient;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;


class LivraisonController extends AbstractController
{



    #[Route('/livraison', name: 'app_livraison_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, LivraisonRepository $livraisonRepository, Request $request): Response
    { {
            $queryBuilder = $entityManager->createQueryBuilder()
                ->select('v')
                ->from(Livraison::class, 'v');
            // Pour faire le trie
            $sort = $request->query->get('sort');
            if ($sort) {
                $queryBuilder->orderBy('v.' . $sort, 'DESC');
            }

            $livraisons = $queryBuilder->getQuery()->getResult();
            return $this->render('livraison/index.html.twig', [
                'livraisons' => $livraisons,
            ]);
        }

        //   $livraisons = $livraisonRepository->findAll();

        // return $this->render('livraison/index.html.twig', [
        //     'livraisons' => $livraisons,
        // ]);
    }
    // #[Route('/livraison', name: 'app_livraison_index', methods: ['GET'])]
    // public function index(LivraisonRepository $livraisonRepository): Response
    // {

    //     $livraisons = $livraisonRepository->findAll();

    //     return $this->render('livraison/index.html.twig', [
    //         'livraisons' => $livraisons,
    //     ]);
    // }

    #[Route('/livraison/liste', name: 'app_livraisons_front', methods: ['GET'])]
    public function afficher(LivraisonRepository $livraisonRepository): Response
    {

        $livraisons = $livraisonRepository->findAll();

        return $this->render('livraison/list_all.html.twig', [
            'livraisons' => $livraisons,
        ]);
    }



    #[Route('/livraison/new', name: 'app_livraison_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UtilisateurRepository $userRepo, LivraisonRepository $livraisonRepository): Response
    {

        $livraison = new Livraison();
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $livraison->setEtat("En attente");
            $livraison->setIdClient($this->getUser());
            $id = $livraison->getClient()->getId();
            $livraisonRepository->save($livraison, true);
            // $flashy->success('Votre facture a bien été enregistrée!', 'http://your-awesome-link.com');

            return $this->redirectToRoute('app_livraison_byuser', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livraison/new.html.twig', [
            'livraison' => $livraison,
            'form' => $form,
        ]);
    }




    #[Route('/livraison/{id}', name: 'app_livraison_byuser', methods: ['GET'])]
    public function showfr(LivraisonRepository $livraisonRepository, $id): Response
    {

        return $this->render('livraison/list.html.twig', [
            'livraisons' => $livraisonRepository->findByUser($id),
        ]);
    }




    #[Route('/livraison/{idLivraison}', name: 'app_livraison_show', methods: ['GET'])]
    public function show(Livraison $livraison): Response
    {
        return $this->render('livraison/show.html.twig', [
            'livraison' => $livraison,
        ]);
    }

    #[Route('/livraison/{idLivraison}/edit', name: 'app_livraison_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livraison $livraison, LivraisonRepository $livraisonRepository): Response
    {
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $livraisonRepository->save($livraison, true);

            return $this->redirectToRoute('app_livraison_byuser', ['id' => $livraison->getIdClient()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livraison/edit.html.twig', [
            'livraison' => $livraison,
            'form' => $form,
        ]);
    }



    #[Route('/livraison/delete/{id}', name: 'app_livraison_delete')]
    public function delete(Request $request,  Livraison $livraison = null, ManagerRegistry $doctrine): RedirectResponse

    {

        $manager = $doctrine->getManager();
        $manager->remove($livraison);
        $manager->flush();

        return $this->redirectToRoute('app_livraison_byuser', ['id' => $livraison->getIdClient()->getId()], Response::HTTP_SEE_OTHER);
    }

    // #[Route('/livraison/{id}/alls/prix/{prixMin}/{prixMax}', name: 'app_livraison_prix')]
    // public function LivraisonByprix(ManagerRegistry $doctrine, $prixMin, $prixMax, LivraisonRepository $livraisonRepository): Response
    // {

    //     return $this->render('livraison/list.html.twig', [
    //         'livraisons' => $livraisonRepository->findLivraisonByPrixInterval($prixMin, $prixMax),
    //     ]);
    // }


    #[Route('/rechercheParPrix', name: 'app_livraison_prix')]
    public function RechercherPrix(Request $request, LivraisonRepository $livraisonRepository): Response
    {
        $minPrix = $request->get('min');
        $maxPrix = $request->get('max');

        return $this->render('livraison/list_all.html.twig', [
            'livraisons' => $livraisonRepository->findByPrix($minPrix, $maxPrix),



        ]);
    }
    #[Route('/rechercheDashbordParNom', name: 'app_recherche_dashboard_par_nom_du_produit')]
    public function recgercheParNomDuProduit(LivraisonRepository $livraisonRepository, Request $request)
    {

        $etat = $request->get('etat');
        $adresseDestinataire = $request->get('adresseDestinataire');

        return $this->render(
            'livraison/list.html.twig',
            [
                'livraisons' => $livraisonRepository->rechercheParetat($etat, $adresseDestinataire),

            ]
        );
    }
    #[Route('/sendsms', name: 'Password_send_sms')]
    // Send SMS notification to admin
    public function sendSms(Request $request, TwilioClient $twilioClient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SmsType::class);

        $form->handleRequest($request);
        $err = " ";
        if ($form->isSubmitted()) {
            $data = $form->getData();
            $num = $data['number'];
            $descripton = $data['description'];
            $accountSid = 'ACb41add57cfe9cce88d4b9dec32886a34';
            $authToken = 'aeefa0ce3b4a15611706b146cb4c2ef0';
            $client = new Client($accountSid, $authToken);
            $message = $client->messages->create(
                $num, // replace with admin's phone number
                [
                    'from' => '+15075858388', // replace with your Twilio phone number
                    'body' => $descripton,
                    // 'body' => 'Bonjour cher client, votre livraison est en route. Merci pour votre confiance !', // replace with your message
                ]
            );
            return $this->redirectToRoute('app_livraisons_front');
        } else {
            $err = "erreur";
        }

        return $this->renderForm('sms/index.html.twig', [

            'form' => $form,
            'err' => $err,
        ]);
    }
    // #[Route('/filtre_cat/{adresseExpedition}', name: 'filtre')]
    // function filtre(LivraisonRepository $repo, $adresseExpedition): Response
    // {
    //     $catego = $repo->find($adresseExpedition);
    //     $Offre = $repo->findByCat($catego);
    //     $cats = $repo->findAll();
    //     return $this->render(
    //         'livraison/index.html.twig',
    //         [
    //             'Livraison' => $Offre, 'adresseExpedition' => $cats
    //         ]
    //     );
    // }

}

// #[Route('/filtre_cat/{cat}', name: 'filtre')]
// function filtre(OffreRepository $repository, CategoriesRepository $repo, $cat)
// {
//     $catego = $repo->find($cat);
//     $Offre = $repository->findByCat($catego);
//     $cats = $repo->findAll();
//     return $this->render('Front/offreFront/frontaffiche.html.twig', [
//         'offre' => $Offre, 'cat' => $cats
//     ]);
// }
// #[Route('/filtre_cat/{adresseExpedition }', name: 'filtre')]
// function filtre(LivraisonRepository $repo, $adresseExpedition)
// {
//     $catego = $repo->find($adresseExpedition);
//     $Offre = $repo->findByCat($catego);
//     $cats = $repo->findAll();
//     return $this->render(
//         'livraison/index.html.twig',
//         [
//             'Livraison' => $Offre, 'adresseExpedition' => $cats
//         ]
//     );
// }
