# Reverse Polish Notation parser in PHP.

Rest of the details about the algorithm: https://en.wikipedia.org/wiki/Reverse_Polish_notation

## Example:

```php
<?php

use DependencyInjection\Container;
use ReversePolish\Parser;

$parser = (new Container)->make(Parser::class);
$parser->parse('3 + 4 * 2 / ( 1 - 5 ) ^ 2 ^ 3');

echo "Compiled expression: " . $parser->compile() . PHP_EOL;
```