<?php

namespace App\Command;

use App\Repository\InformationRepository;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MailExpireCommand extends Command
{
    protected static $defaultName = 'app:mail-expire';
    private $informationRepository;

    public function __construct(InformationRepository $informationRepository)
    {
        $this->informationRepository = $informationRepository;

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

        if ($fiveDaysDate) {

            foreach ($fiveDaysDate as &$fiveDate) {

                if ($fiveDate['expiration'] == 5){

                    $output->writeln('Il vous reste ' . $fiveDate['expiration'] . ' jours!');
                }
                //$output->writeln('Ce certificats N°'.$test['id'].' est expirer!');
            }

        }

        if ($expireDate){

            foreach ($expireDate as &$expire){

                if ($expire['expiration'] == 0){

                    $output->writeln('Certificats expirer!');
                }
            }
        }

        return Command::SUCCESS;
    }
}