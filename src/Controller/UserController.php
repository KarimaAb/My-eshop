<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{

  /**
   * pr l'enregisterement d un nouvel user ns ne pouvons pas inserer le mdp en clair en BDD
   * symfony ns fournit un outil pour hasher(encrypter) le password.
   * pr l utiliser , nous avons juste à l'injecter coe dépendance (de notre fonction).
   * l injection de dependance se fait entre les paratheses de la fonction.
   * 
   * @Route("/inscription", name="user_register", methods={"GET|POST"})
   */
  public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $PasswordHasher): Response
  {
    #on creee un nlle instance 
    $user = new User();

    $form = $this->createForm(UserFormType::class, $user)
      ->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      # ns settons les proprietes qui ne font pas dans le form et donc auto-hydratés.
      # Les propriétes createdAt et updatedAt attendent un objet de type DateTime(.)
      $user->setCreatedAt(new DateTime());
      $user->setupdatedAt(new DateTime());
      #pr assurer un role utilisaateur à tous les utilisateurs , on set le role egalement.
      $user->setRoles(['ROLE_USER']);

      #on rcupere la valeur de l'input 'password' ds le formulaire
      $plainPassword = $form->get('password')->getData();

      #on reset le password de l'user en le hachant.
      #pour hacher ,on utilise l'outil de hashage qu'on a injecté ds notre action.
      $user->setPassword(
        $PasswordHasher->hashPassword(
          $user,
          $plainPassword

        )
      );
      # notre user st correctement setter on peut envoyer en bdd
      $entityManager->persist($user);
      $entityManager->flush();

      # Grace a la méthode addFlash(), vous pouvez stocker des messages dans la session destinés a etre affiches en front.
      $this->addFlash('success', 'Vous étes inscrit avec succès !');

      #on peut enfin retrun et rediriger l user la ou on le souhaite
      return $this->redirectToRoute('app_login');
    } # end if()

    # on rend la vue qui contient le form d inscripstion.
    return $this->render("user/register.html.twig", [
      'form_register' => $form->createView()
    ]);
  } # end function register()
} # end class
