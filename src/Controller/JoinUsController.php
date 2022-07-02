<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\JoinUsFormType;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Bridge\Google\Smtp\GmailTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class JoinUsController extends AbstractController
{
    /**
     * @Route("/join/us", name="joinus")
     */

    public function joinus(Request $request, MailerInterface $mailer)
    {

        $form = $this->createForm(JoinUsFormType::class);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $joinFormData = $form->getData();


            $emailform = $joinFormData['Email'];
            $nomform = $joinFormData['Nom'];
            $prenomform = $joinFormData['Prenom'];
            $telephoneform = $joinFormData['Telephone'];
            $messageform = $joinFormData['Message'];

            $message = (new TemplatedEmail())
                ->from($this->getParameter('app.email_from'))
                ->to('ass.autoursdelafamille@gmail.com')
                ->replyTo($emailform)
                //mettre le client en cc ? ->cc(...)
                //mettre le logo de l'entreprise (embed(fopen(chemin),'logo'))
                ->subject('Nouveau demande Membre (Bénévole)')
                ->htmlTemplate('/join_us/join_email.html.twig')
                ->context([

                    'Expediteur' => $joinFormData['Email'], //. \PHP_EOL .
                    'Nom'  => $nomform, //. \PHP_EOL .
                    'Prenom'  => $prenomform, //. \PHP_EOL .
                    'Telephone'  => $telephoneform, // . \PHP_EOL .
                    'Message'  => $messageform
                ]);
            $mailer->send($message);

            return $this->redirectToRoute('home');
        }

        return $this->render('join_us/joinus.html.twig', [
            'joinUs_form' => $form->createView()
        ]);


        return  $this->addFlash('Demande traitée avec succès', 'Nous vous répondrons dans les plus brefs délais !');
        //return $this->render('contacts/contacts.html.twig', [
        //    'controller_name' => 'ContactsController',
        //]);
    }
}
