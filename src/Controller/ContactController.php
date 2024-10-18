<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class ContactController extends AbstractController
{
    #[Route('/contact/submit', name: 'contact_submit', methods: ['POST'])]
    public function submitContactForm(Request $request, MailerInterface $mailer, ValidatorInterface $validator): Response
    {
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $message = $request->request->get('message');
        $selectedGame = $request->request->get('flexRadioDefault');

        // Validation de l'email
        $emailConstraint = new Assert\Email();
        $emailConstraint->message = 'L\'adresse e-mail fournie n\'est pas valide.';
        
        $errors = $validator->validate($email, $emailConstraint);

        // Vérification des champs
        if (empty($name) || empty($email) || empty($message) || count($errors) > 0) {
            $errorMessages = [];
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $errorMessages[] = $error->getMessage();
                }
            }
            return $this->json([
                'success' => false,
                'message' => 'Veuillez remplir tous les champs correctement.' . ($errorMessages ? ' Erreurs: ' . implode(', ', $errorMessages) : ''),
            ]);
        }

        // Création de l'email
        $emailMessage = (new Email())
            ->from($email) // Adresse de l'expéditeur fournie par l'utilisateur
            ->to('luciletrc@gmail.com') // Ton adresse e-mail
            ->subject('Nouveau message de contact')
            ->text("Nom: $name\nEmail: $email\nJeu: $selectedGame\nMessage: $message");

        // Envoi de l'email avec gestion des erreurs
        try {
            $mailer->send($emailMessage);
            return $this->json([
                'success' => true,
                'message' => 'Votre message a été envoyé avec succès!',
            ]);
        } catch (TransportExceptionInterface $e) {
            // Gérer l'erreur d'envoi
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de l\'envoi de votre message. Veuillez réessayer plus tard.',
            ]);
        }
    }
}
