<?php

namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
//use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\TestOnline;

class AppCronPingCommand extends ContainerAwareCommand {

    protected static $defaultName = 'app:cron-ping';

    protected function configure() {
        $this
                ->setDescription('Lance le ping à utiliser avec un cron, ajouter l`option -q en production')
                ->addArgument('type', InputArgument::OPTIONAL, 'Rang du ping à tester par defaut 1 ')
                ->addOption('dryrun', null, InputOption::VALUE_NONE, 'Pour tester, ne fait techniquement rien')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $io = new SymfonyStyle($input, $output);

        $type = $input->getArgument('type');
        if ($type == null) {
            $type = 1;
        }
        $em = $this->getContainer()->get('doctrine')->getManager();
        if ($input->getOption('dryrun')) {
           $io->success('piou piou');
            exit();
        }
        
        $repo = $em->getRepository('App:WebSite');
        $e = $repo->findByPingStatut($type);
        foreach ($e as $key => $v) {
            $m = $v->getStatutCode();
            $r = new TestOnline;            
            if ($m) {
                if ($m < 400) {
                  $r->setResult(true);  
                    $p = "OK";
                } else {
                    $r->setResult(false);  
                    $p = "ERROR";
                }                
            } else {
                $r->setResult(false);
                $p = "CASSE";    
            }  
            $r->setWebSite($v);
            $em->persist($r);
            $em->flush();
            $io->writeln($key ." | ".$p);
        }
        
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }

}
