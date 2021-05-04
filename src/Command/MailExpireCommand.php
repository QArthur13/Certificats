<?php

namespace App\Command;

use App\Repository\InformationRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MailExpireCommand extends Command
{
    protected static $defaultName = 'app:mail-expire';
    private $informationRepository;
    private $mailer;

    public function __construct(InformationRepository $informationRepository, MailerInterface $mailer)
    {
        $this->informationRepository = $informationRepository;
        $this->mailer = $mailer;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Send a mail for user')
            ->setHelp('This command allows for the use to receive a mail when a certificats is near of the expiration.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $today = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $fiveDaysDate = $this->informationRepository->fiveDaysExpire($today);
        $expireDate = $this->informationRepository->expire($today);

        $email = (new Email());

        if ($fiveDaysDate) {

            foreach ($fiveDaysDate as &$fiveDate) {

                if ($fiveDate['expiration'] == 5){

                    $output->writeln('Il reste ' . $fiveDate['expiration'] . ' jours avant l\'expiration!');

                    $email
                        ->from('qarthur@youpi.fr')
                        ->to($fiveDate['email'])
                        ->subject('Certificats expirer')
                        ->text('Bonjour '.$fiveDate['lastname'].' '.$fiveDate['firstname']. ' un de vos certificats va bientôt expirer!')
                    ;

                    $this->mailer->send($email);

                }
                //$output->writeln('Ce certificats N°'.$test['id'].' est expirer!');
            }

        }

        if ($expireDate){

            foreach ($expireDate as &$expire){

                if ($expire['expiration'] == 0){

                    $output->writeln('Certificats expirer!');

                    $email
                        ->from('qarthur@youpi.fr')
                        ->to($expire['email'])
                        ->subject('Certificats expirer')
                        ->text('Bonjour '.$expire['lastname'].' '.$expire['firstname']. ' un de vos certificats est expirer!')
                    ;

                    $this->mailer->send($email);
                }
            }
        }

        return Command::SUCCESS;
    }
}