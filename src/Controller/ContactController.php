<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Bridge\Google\Smtp\GmailTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, MailerInterface $mailer)
    {

        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();


            $emailcontactform = $contactFormData['Email'];
            $nomcontactform = $contactFormData['Nom'];
            $prenomcontactform = $contactFormData['Prenom'];
            $telephonecontactform = $contactFormData['Telephone'];
            $typecontactform = $contactFormData['Type'];
            $messagecontactform = $contactFormData['Message'];

            $message = (new TemplatedEmail())
                ->from($this->getParameter('app.email_from'))
                ->to('ass.autoursdelafamille@gmail.com')
                ->replyTo($emailcontactform)
                //mettre le client en cc ? ->cc(...)
                //mettre le logo de l'entreprise (embed(fopen(chemin),'logo'))
                ->subject('Nouvelle demande de contact')
                ->htmlTemplate('/contact/email.html.twig')
                ->context([

                    'Expediteur' => $contactFormData['Email'], //. \PHP_EOL .
                    'Nom'  => $nomcontactform, //. \PHP_EOL .
                    'Prenom'  => $prenomcontactform, //. \PHP_EOL .
                    'Telephone'  => $telephonecontactform, // . \PHP_EOL .
                    'TypedeProjet' =>  $typecontactform, // . \PHP_EOL .
                    'Message'  => $messagecontactform
                ]);
            $mailer->send($message);

            return $this->redirectToRoute('home');
        }

        return $this->render('/contact/contact.html.twig', [
            'contacts_form' => $form->createView()
        ]);


        return  $this->addFlash('Demande traitée avec succès', 'Nous vous répondrons dans les plus brefs délais !');
        //return $this->render('contacts/contacts.html.twig', [
        //    'controller_name' => 'ContactsController',
        //]);
    }
}
