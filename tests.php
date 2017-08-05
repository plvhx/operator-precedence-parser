<?php

@trigger_error("This file is just for dummy testing purpose.", E_USER_DEPRECATED);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

use DependencyInjection\Container;
use ReversePolish\Parser;

$parser = (new Container)->make(Parser::class);
$parser->parse('3 + 4 * 2 / ( 1 - 5 ) ^ 2 ^ 3');

echo "Compiled expression: " . $parser->compile() . PHP_EOL;
echo "Evaluated expression: " . $parser->evaluate() . PHP_EOL;