Curried Closure
===============

Partial application in PHP:

```php
<?php
  use Nassau\CurriedClosure;

  $closure = new CurriedClosure('explode');
  $imploder = (new CurriedClosure('implode'))->curryLeft("\t→ ");
  $dashed = $closure->curryLeft('-')->compose($imploder);
  $dotted = $closure->curryLeft('.')->compose($imploder);
  $dotted3 = $closure->curryLeft('.')->curryRight(3)->compose($imploder);
  
  $array = ['1.6.9.4', '1.0-dev', '2.x-aplha', '3.5-RC1'];
  print_r([
    'dashed'   => array_map($dashed, $array),
    'dotted'   => array_map($dotted, $array),
    'dotted-3' => array_map($dotted3, $array),
  ]);

```

Outputs:

```
Array
(
    [dashed] => Array
        (
            [0] => 1.6.9.4
            [1] => 1.0	→ dev
            [2] => 2.x	→ aplha
            [3] => 3.5	→ RC1
        )

    [dotted] => Array
        (
            [0] => 1	→ 6	→ 9	→ 4
            [1] => 1	→ 0-dev
            [2] => 2	→ x-aplha
            [3] => 3	→ 5-RC1
        )

    [dotted-3] => Array
        (
            [0] => 1	→ 6	→ 9.4
            [1] => 1	→ 0-dev
            [2] => 2	→ x-aplha
            [3] => 3	→ 5-RC1
        )

)
```
