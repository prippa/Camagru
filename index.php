<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Camagru Project</title>
    <style>

    </style>
</head>
<body>
<div>
    <?php
    class MyClass
    {
        public $var;

        public function __construct($num)
        {
            $this->var = $num;
        }

        public function __destruct()
        {
            echo __CLASS__, ' destruct', PHP_EOL;
        }
    }

    function f($arg1, $arg2, $arg3)
    {
        echo $arg1, PHP_EOL;
        echo $arg2, PHP_EOL;
    }

    $foo = new MyClass(42);
    $a = 'a';
    if ($a || $a)
        echo 123;
    echo $foo->var, PHP_EOL;
    f(1, 'Hello', 3);
    ?>
</div>
</body>
</html>
