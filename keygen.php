#!/usr/bin/env php
<?php
/**
 * Lead Manager
 * THIS FILE IS A PART OF LEAD MANAGER PROJECT
 * LEAD MANAGER PROJECT IS PROPERTY OF Legal One GmbH
 *
 * @copyright Copyright (c) 2020 Legal One GmbH (http://www.legal.one)
 */

declare(strict_types=1);

require __DIR__.'/vendor/autoload.php';

use ParagonIE\Halite\KeyFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;

(new SingleCommandApplication())
    ->setName('Lead Manager Encryption Key Generator')
    ->addOption('no-write', 'nw', InputOption::VALUE_NONE, 'Don\'t write to files.')
    ->setCode(function (InputInterface $input, OutputInterface $output) {
        $shouldWrite = false === ((bool)$input->getOption('no-write'));

        $keyPair = KeyFactory::generateEncryptionKeyPair();
        $secretKey = $keyPair->getSecretKey();
        $publicKey = $keyPair->getPublicKey();
        $exportablePubKey = sodium_bin2hex($publicKey->getRawKeyMaterial());

        if ($shouldWrite) {
            KeyFactory::save($secretKey, 'key.secret');
            file_put_contents('key.public', $exportablePubKey);
        }

        $secKeyStr = KeyFactory::export($secretKey)->getString();
        $output->writeln(
            ['Your private key is: ', $secKeyStr]
        );

        $output->writeln(['Your public key is:', $exportablePubKey]);

        return 0;
    })
    ->run();
