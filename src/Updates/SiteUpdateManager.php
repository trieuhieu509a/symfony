<?php
namespace App\Updates;

use App\Service\MessageGenerator;

class SiteUpdateManager
{
    private $messageGenerator;
    private $mailer;
    private $adminEmail;

    public function __construct(MessageGenerator $messageGenerator, \Swift_Mailer $mailer, $adminEmail)
    {
        $this->messageGenerator = $messageGenerator;
        $this->mailer = $mailer;
        $this->adminEmail = $adminEmail;
    }

    public function notifyOfSiteUpdate()
    {
        $happyMessage = $this->messageGenerator->getHappyMessage();

        $message = (new \Swift_Message('Site update just happened!'))
            ->setFrom('admin@example.com')
            ->setTo($this->adminEmail)
            ->addPart(
                'Someone just updated the site. We told them: '.$happyMessage
            );

        return $this->mailer->send($message) > 0;
    }
}