<?php


namespace UserBundle\Manager;

use AppBundle\Entity\Player;
use Symfony\Bundle\TwigBundle\TwigEngine;

class MailManager
{
    private $mailer;
    private $mail_admin;
    private $template;

    public function __construct(\Swift_Mailer $mailer, $mail_admin, TwigEngine $template)
    {
        $this->mailer = $mailer;
        $this->mail_admin = $mail_admin;
        $this->template = $template;
    }

    public function sendMailToPlayer(Player $player)
    {
        $mail = (new \Swift_Message('Activation de votre compte ShinigamiLaser'))
            ->setFrom($this->mail_admin)
            ->setTo($player->getEmail())
            ->setBody(
                $this->template
                ->render(
                    'UserBundle:email:mail.activate.html.twig',
                    ['player' => $player]
                ),
                'text/html'
            );

        $this->mailer->send($mail);
    }

    public function sendMailLostPassword(Player $player)
    {
        $mail = (new \Swift_Message('Réinitialisation de votre mot de passe ShinigamiLaser'))
            ->setFrom($this->mail_admin)
            ->setTo($player->getEmail())
            ->setBody(
                $this->template
                ->render(
                    'UserBundle:email:mail.lost_password.html.twig',
                    ['player' => $player]
                ),
                'text/html'
            );
        $this->mailer->send($mail);
    }
}
