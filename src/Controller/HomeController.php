<?php 

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\RecettesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class HomeController extends AbstractController {

    //Affichera la page d'accueil 

    /**
     * @Route ("/", name= "home")
     * @param RecettesRepository $repository
     * @return Response
     */
    public function index (RecettesRepository $repository) : Response
    {
        $recettes = $repository->findLatest();
        return $this->render("pages/home.html.twig" , [
                    "recettes" => $recettes
        ]);
    }

    /**
     * @Route("/contact", name="pages_contact")
     */
    public function contact(Request $request, MailerInterface $mailer)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $message = (new Email())

                    ->from(new Address('hello@example.com'))
                    ->to(new Address($contact->getEmail()))
                    ->subject('Time for Symfony Mailer!')
                    ->text('Sending emails is fun again!')
                    ->html($this->render('/email/contact.html.twig', [
                        "contact" => $contact
                    ]),
                    'text/html'
                );

            $mailer->send($message);        

            try {
                $mailer->send($message);
            } catch (TransportExceptionInterface $e) {
                "Erreur lors de l'envoi : veuillez réessayer";
            }

        }

        return $this->render('pages/contact.html.twig', [
            "formContact" => $form->createView()
        ]);
    }

}