<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Intelligent\SettingBundle\Cmd;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of GreetCommand
 *
 * @author shashankd
 */
class ImportCommand extends ContainerAwareCommand {

    //put your code here

    protected function configure() {

        $this->setName('intelligent:import')
                ->setDescription('Upload data to Aizan')
                ->addOption(
                        'path', null, InputOption::VALUE_OPTIONAL, 'Relative File Path'
                )
                ->addOption(
                        'module', null, InputOption::VALUE_OPTIONAL, 'Module Name like customer, Campaign, etc'
                )
                ->addOption(
                        'config_test_header', null, InputOption::VALUE_OPTIONAL, ''
                )
                ->addOption(
                        'config_delete_existing_before_insert', null, InputOption::VALUE_OPTIONAL, ''
                )
//                ->addOption(
//                        'customer', null, InputOption::VALUE_OPTIONAL, 'Customer name'
//                )
                ->addOption(
                        'console_customer_id', null, InputOption::VALUE_REQUIRED, 'Customer Id'
                )
                ->addOption(
                        'foreign_key', null, InputOption::VALUE_OPTIONAL, 'Quickbase Foreign Key Id enter, ex:relationship_module|csv_column_name(campaign|Campaign ID#)'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        // ...

        $input->getOption('path');
        $optons = $input->getOptions();

        $path = $input->getOption('path');
        $m = $input->getOption('module');
        $c_delete = $input->getOption('config_delete_existing_before_insert');
        $c_test_header = $input->getOption('config_test_header');
        //$customer = $input->getOption('customer');
        $f = trim($input->getOption('foreign_key'));
        $console_customer_id = $input->getOption('console_customer_id');
        
//        $session = $this->getContainer()->get('session');
//        $session->set('console_cusotmer_id',$console_customer_id);


        //var_dump($optons);
        //exit;

        //$user_permission = $this->getContainer()->get("user_permissions");
        //echo $active_customer_filter = $user_permission->getCurrentViewCustomer()->getId();

//        if ($active_customer_filter != $customer) {
//            echo 'customer dont match';
//        } else 
            {

            //var_dump($c);
            if ( ! empty($m) and ! empty($path)) {
                $import = $this->getContainer()->get('intelligent.import.module');
                //if (!empty($c_delete)) {

                    $import->setTestOnlyHeader(!empty($c_test_header));
                    $import->setDeleteBeforeInsert(!empty($c_delete));
                //}
                if (!empty($f) and strpos($f, '|') !== false) {
                    $f2 = explode('|', $f);
                    $import->setForeignKey(array($f2[0] => $f2[1]));
                }
                $import->setConsoleCustomer($console_customer_id);
                $import->init($m);

                $import->csvUpload($path);
            } else {
                throw new \Exception('Missing parameters');
            }
        }
    }

}
