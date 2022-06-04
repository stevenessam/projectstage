<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\ContactService;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {

        //ContactService $contactService,
        $session = new Session();
        $contact = new Contact();
        $form = $this->createForm(ContactType::class,$contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // $contact = $form->getData();
            // $contactService->persistContact($contact);


            $email = (new TemplatedEmail())
            ->from(new Address('stevenessamlegion@hotmail.com', 'H.M.S RENOV'))
            ->to('manobalotalos@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Vous avez reçu une nouvelle demande de devis')
            ->htmlTemplate('contact/mail_devis.html.twig')
            //->text('Sending emails is fun again!')
          //  ->html('<p>See Twig integration for better HTML integration!</p>');
            ->context([
                'nom'=>$form->get('nom')->getData(),
                'telephone'=>$form->get('telephone')->getData(),
                'emailAddr'=>$form->get('email')->getData(),
                'message'=>$form->get('message')->getData(),
            ]);
        $mailer->send($email);

        $session->getFlashBag()->add('success', 'Votre message a été envoyé avec succès, Merci');

            return $this->redirectToRoute('app_contact');

        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
