<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mail")
 */
class MailerController extends AbstractController
{

    /**
     * @Route("/send/{de}&{a}&{objet}&{texte}", name="send_mail", methods={"GET","POST"})
     * @param MailerInterface $mailer
     * @param string $de
     * @param string $a mail du receveur
     * @param string $objet
     * @param string $texte
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendEmail(string $de, string $a, string $objet, string $texte, MailerInterface $mailer)
    {
        $email = (new Email())
            ->from($de)
            ->to($a)
            ->subject($objet)
            ->text($texte)
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);
    }
}
