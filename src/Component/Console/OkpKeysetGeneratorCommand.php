<?php

declare(strict_types=1);

namespace Jose\Component\Console;

use InvalidArgumentException;
use function is_int;
use function is_string;
use Jose\Component\Core\JWKSet;
use Jose\Component\KeyManagement\JWKFactory;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class OkpKeysetGeneratorCommand extends GeneratorCommand
{
    protected static $defaultName = 'keyset:generate:okp';

    protected function configure(): void
    {
        parent::configure();
        $this->setDescription('Generate a key set with Octet Key Pairs keys (JWKSet format)')
            ->addArgument('quantity', InputArgument::REQUIRED, 'Quantity of keys in the key set.')
            ->addArgument('curve', InputArgument::REQUIRED, 'Curve of the keys.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $quantity = $input->getArgument('quantity');
        if (! is_int($quantity)) {
            $quantity = 1;
        }
        $curve = $input->getArgument('curve');
        if ($quantity < 1) {
            throw new InvalidArgumentException('Invalid quantity');
        }
        if (! is_string($curve)) {
            throw new InvalidArgumentException('Invalid curve');
        }

        $keyset = new JWKSet([]);
        for ($i = 0; $i < $quantity; ++$i) {
            $args = $this->getOptions($input);
            $keyset = $keyset->with(JWKFactory::createOKPKey($curve, $args));
        }
        $this->prepareJsonOutput($input, $output, $keyset);

        return 0;
    }
}
