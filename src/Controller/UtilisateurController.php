<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use App\Entity\Conducteur;
use App\Entity\Utilisateur;
use App\Entity\Voiture;
use App\Form\ConducteurType;
use App\Form\CreerCompteType;
use App\Form\ModifProfilType;
use App\Form\UtilisateurType;
use App\Repository\ConducteurRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;


class UtilisateurController extends AbstractController
{
    #[Route('/login', name: 'app_utilisateur_login', methods: ['GET', 'POST'])]
    public function login(): Response
    {
        return $this->renderForm('utilisateur/login.html.twig', []);
    }

    #[Route('/admin/utilisateur', name: 'app_utilisateur_index', methods: ['GET'])]
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {
        $user = $this->getUser();
        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll(),
            'user' => $user
        ]);
    }

    #[Route('/creatCpt', name: 'app_utilisateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UtilisateurRepository $utilisateurRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->add('captcha', CaptchaType::class, [
            'label' => ' ',

            'attr' => [
                'placeholder' => 'Entre code'
            ]
        ]);

        $utilisateur->setRole("Client");
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword(
                $utilisateur,
                $utilisateur->getmdp()
            );
            $utilisateur->setMdp($hashedPassword);
            $utilisateurRepository->save($utilisateur, true);

            return $this->redirectToRoute('app_utilisateur_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('utilisateur/creatCpt.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/creatCptC', name: 'app_utilisateur_newC', methods: ['GET', 'POST'])]
    public function newC(Request $request, ConducteurRepository $cr, UtilisateurRepository $ur, UserPasswordHasherInterface $passwordHasher, SluggerInterface $slugger = null): Response
    {
        try {
            // Code that may throw an exception...
            $u = new Utilisateur();
            $c = new Conducteur();
            $formC = $this->createForm(ConducteurType::class);
            $formC->add('captcha', CaptchaType::class, [
                'label' => ' ',

                'attr' => [
                    'placeholder' => 'Entre code'
                ]
            ]);
            $formC->handleRequest($request);
            if ($formC->isSubmitted() && $formC->isValid()) {
                $data = $formC->getData();
                $u->setNom($data["nom"]);
                $u->setPrenom($data["prenom"]);
                $u->setMail($data["mail"]);
                $u->setNumTel($data["numTel"]);
                $u->setRole("Conducteur");
                $hashedPassword = $passwordHasher->hashPassword(
                    $u,
                    $data["mdp"]
                );
                $u->setMdp($hashedPassword);
                $ur->save($u, true);

                /** @var UploadedFile $image */
                /*   $image = $formC['b3']->getData();
                $destination = 'C:/uploadedFiles/Images/';
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = $originalFileName . '-' . uniqid() . '.' . $image->guessExtension();
                $image->move($destination, $fileName);
                $c->setB3('C:/uploadedFiles/Images/' . $fileName); */
                $image = $formC['b3']->getData();
                if ($image) {
                    $originalImgName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $newImgename = $originalImgName . '-' . uniqid() . '.' . $image->guessExtension();

                    if ($slugger) {
                        $safeImgname = $slugger->slug($originalImgName);
                        $newImgename = $safeImgname . '-' . uniqid() . '.' . $image->guessExtension();
                    }

                    try {
                        $image->move(
                            $this->getParameter('imgb_directory'),
                            $newImgename
                        );
                    } catch (FileException $e) {
                        // handle exception if something happens during file upload
                    }
                }
                $c->setB3($newImgename);

                /** @var UploadedFile $image */
                $image = $formC['permis']->getData();
                if ($image) {
                    $originalImgName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $newImgename = $originalImgName . '-' . uniqid() . '.' . $image->guessExtension();

                    if ($slugger) {
                        $safeImgname = $slugger->slug($originalImgName);
                        $newImgename = $safeImgname . '-' . uniqid() . '.' . $image->guessExtension();
                    }

                    try {
                        $image->move(
                            $this->getParameter('imgb_directory'),
                            $newImgename
                        );
                    } catch (FileException $e) {
                        // handle exception if something happens during file upload
                    }
                }
                $c->setPermis($newImgename);
                $c->setUtilisateur($u);
                $cr->save($c, true);

                return $this->redirectToRoute('app_utilisateur_login', [], Response::HTTP_SEE_OTHER);
            }
            return $this->renderForm('utilisateur/creatCptC.html.twig', [
                'form' => $formC,
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }


    #[Route('/choixrole', name: 'app_utilisateur_choix', methods: ['GET'])]
    public function choixR(Request $request): Response
    {
        return $this->render('utilisateur/choixrole.html.twig', []);
    }


    #[Route('/admin/utilisateur/{id}', name: 'app_utilisateur_show', methods: ['GET'])]
    public function show(Utilisateur $u, ConducteurRepository $cr): Response
    {
        $c = new Conducteur();
        if ($u->getRole() == "Conducteur") {
            /*  $c = $cr->gettcond($u->getId()); */
        }
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $u,
            'conducteur' => $c,
        ]);
    }
    #[Route('/utilisateur/{id}', name: 'app_utilisateur_showfr', methods: ['GET'])]
    public function showfr(Utilisateur $utilisateur): Response
    {
        return $this->render('utilisateur/showfront.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/admin/utilisateuredit/{id}', name: 'app_utilisateur_editb', methods: ['GET', 'POST'])]
    public function editB(Request $request, Utilisateur $utilisateur, UtilisateurRepository $utilisateurRepository): Response
    {
        $form = $this->createFormBuilder()
            ->add('role', ChoiceType::class, [
                'choices'  => [
                    'Conducteur' => 'Conducteur',
                    'Client' => 'Client',
                ],
                'label' => 'Rôle',
                'attr' => ['class' => 'row'],
                'multiple' => false,
                'expanded' => true
            ])->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $utilisateur->setRole($form->getData()['role']);
            $utilisateurRepository->save($utilisateur, true);

            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }
    #[Route('/utilisateur/{id}/edit/', name: 'app_utilisateur_edit', methods: ['GET', 'POST'])]

    public function edit(Request $request, Utilisateur $utilisateur, UtilisateurRepository $utilisateurRepository, UserPasswordHasherInterface $passwordHasher): Response
    {

        $form = $this->createForm(ModifProfilType::class, ["nom" => $utilisateur->getNom(), "prenom" => $utilisateur->getPrenom(), "numTel" => $utilisateur->getNumTel(), "mail" => $utilisateur->getMail(),]);
        $form->handleRequest($request);
        /* $formc = $this->createFormBuilder();
        $formc->add('chmdp', ChoiceType::class, ["choices" => ["Changer mot de passe" => true]]); */
        if ($form->isSubmitted()) {
            /* $hashedPassword = $passwordHasher->hashPassword(
                $utilisateur,
                $utilisateur->getmdp()
            );
            $utilisateur->setMdp($hashedPassword); */
            $data = $form->getData();
            $utilisateur->setNom($data["nom"]);
            $utilisateur->setPrenom($data["prenom"]);
            $utilisateur->setNumTel($data["numTel"]);
            $utilisateur->setMail($data["mail"]);
            $utilisateurRepository->save($utilisateur, true);
            return $this->redirectToRoute('app_utilisateur_showfr', ['id' => $utilisateur->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('utilisateur/editfront.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
            /* 'formc' => $formc, */
        ]);
    }

    #[Route('/admin/utilisateur/{id}', name: 'app_utilisateur_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateur $utilisateur, UtilisateurRepository $utilisateurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $utilisateur->getId(), $request->request->get('_token'))) {
            $utilisateurRepository->remove($utilisateur, true);
        }

        return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/admin/utilisateurbloque/{id}', name: 'app_utilisateur_bloquer')]
    public function bloquer(Request $request, Utilisateur $u, ManagerRegistry $doctrine): Response
    {
        $u->setBloque(!$u->isBloque());
        if ($u->isBloque()) {
            $u->setMdp('!' . $u->getmdp());
        } else
            $u->setMdp(substr($u->getmdp(), 1));
        $em = $doctrine->getManager();
        $em->flush();

        return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/mdp/Oublie/', name: 'app_utilisateur_mdpOb')]
    public function changemdp(Request $request, UtilisateurRepository $ur): Response
    {
        $err = '';
        $form = $this->createFormBuilder()
            ->add('mail', EmailType::class, ['label' => 'Mail:', 'attr' => [
                'placeholder' => 'saisir votre E-mail'
            ]])
            ->add('save', SubmitType::class, ['label' => 'Envoyer'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mail = $form->getData()['mail'];
            if ($ur->findBy(['mail' => $mail]) != null) {

                return $this->redirectToRoute('app_mail', ['to' => $mail]);
            } else {
                $err = "votre mail n'est pas valide ";
            }
        }

        return  $this->render('utilisateur/mdpOublier.html.twig', [
            'form' => $form,
            'err' => $err
        ]);
    }

    #[Route('/utilisateur/modifiermotdepasse/{id}', name: 'app_utilisateur_changemdp')]
    public function editPassword(Request $request,  Utilisateur $utilisateur, UtilisateurRepository $utilisateurRepository, UserPasswordHasherInterface  $passwordHasher)
    {
        $err = "";
        $form = $this->createFormBuilder()
            ->add('mdpA', PasswordType::class, ['label' => 'Ancien mot de passe :', 'attr' => [
                'placeholder' => 'saisir votre ancien mot de passe '
            ]])
            ->add('mdp', RepeatedType::class, [
                'type' => PasswordType::class,
                'label' => ' ',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe:',
                    'attr' => [
                        'placeholder' => 'saisir votre mot de passe'
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmez le mot de passe:',
                    'attr' => ['placeholder' => 'Confirmez mot de passe'],
                ]
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $oldpwd = $data['mdpA'];
            if ($passwordHasher->isPasswordValid($utilisateur, $oldpwd)) {
                $newpwd = $data['mdp'];
                $hashedPassword2 = $passwordHasher->hashPassword($utilisateur, $newpwd);
                $utilisateur->setMdp($hashedPassword2);
                $utilisateurRepository->save($utilisateur, true);
                return $this->redirectToRoute('app_utilisateur_showfr', ['id' => $utilisateur->getId()], Response::HTTP_SEE_OTHER);
            } else {
                $err = "Ancien mot de passe incorrect";
            }
        }
        return $this->renderForm('utilisateur/changermdpfront.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
            'err' => $err,
        ]);
    }
}
