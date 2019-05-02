<?php

namespace App\Notification;

use App\Entity\Reserver;
use Twig\Environment;

class ReserverNotification{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     *@var Environment 
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer){
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }
    
    public function notify(Reserver $reserver){
        $message = (new \Swift_Message('Resto : ' . $reserver->getRestaurant()->getName()))
            //->setForm($contact->getEamil())
            ->setFrom('noreply@resto.fr')
            ->setTo('reserver@resto.fr')
            ->setReplyTo($reserver->getEmail())
            ->setBody($this->renderer->render('emails/reserver.html.twig',[
                'reserver' => $reserver
            ]),'text/html');

        $this->mailer->send($message);
    }
}