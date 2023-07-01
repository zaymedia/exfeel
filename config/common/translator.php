<?php

declare(strict_types=1);

use Middlewares\ContentLanguage;
use Psr\Container\ContainerInterface;
use Symfony\Component\Translation\Loader\PhpFileLoader;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Contracts\Translation\TranslatorInterface;

return [
    TranslatorInterface::class => DI\get(Translator::class),

    Translator::class => static function (ContainerInterface $container): Translator {
        /**
         * @psalm-suppress MixedArrayAccess
         * @var array{lang:string,resources:array<string[]>} $config
         */
        $config = $container->get('config')['translator'];

        $translator = new Translator($config['lang']);
        $translator->addLoader('php', new PhpFileLoader());
        $translator->addLoader('xlf', new XliffFileLoader());

        /**
         * @psalm-suppress MixedArrayAccess
         * @var array<string> $locales
         */
        $locales = $container->get('config')['locales']['allowed'];

        foreach ($locales as $locale) {
            $filename =  __DIR__ . '/../../src/Translations/Bot/' . $locale . '.php';

            if (!file_exists($filename)) {
                continue;
            }

            $config['resources'][] = [
                'php',
                $filename,
                $locale,
                'bot',
            ];
        }

        foreach ($config['resources'] as $resource) {
            $translator->addResource(...$resource);
        }

        return $translator;
    },

    ContentLanguage::class => static function (ContainerInterface $container): ContentLanguage {
        /**
         * @psalm-suppress MixedArrayAccess
         * @var array{allowed:string[]} $config
         */
        $config = $container->get('config')['locales'];

        return new ContentLanguage($config['allowed']);
    },

    'config' => [
        'translator' => [
            'lang' => 'en',
            'resources' => [
                [
                    'xlf',
                    __DIR__ . '/../../vendor/symfony/validator/Resources/translations/validators.ru.xlf',
                    'en',
                    'validators',
                ],
                [
                    'xlf',
                    __DIR__ . '/../../vendor/symfony/validator/Resources/translations/validators.ru.xlf',
                    'ru',
                    'validators',
                ],
            ],
        ],
        'locales' => [
            'allowed' => ['ru', 'en'],
        ],
    ],
];
