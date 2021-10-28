<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@PHP80Migration:risky' => true,
    ])
    ->setLineEnding("\n")
    ->setFinder($finder)
    ;
