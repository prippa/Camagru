<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        * { padding: 0;  margin: 0; }

        .wrapper {
            display: grid;
            grid-template-columns: 70% 30%;
            grid-gap: 1em;
        }

        .wrapper > div {
            padding: 1em;
            background-color: #ff6172;
        }

        .wrapper > div.light {
            padding: 1em;
            background-color: #df8b7f;
        }
    </style>
    <title><?php echo $title; ?></title>
</head>
<body>
    <div class="wrapper">
        <div>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque commodi consequuntur dignissimos doloremque ducimus eius eos, error harum nam nobis nostrum nulla quas, repudiandae saepe tenetur ullam vitae voluptate? Amet aperiam culpa esse excepturi obcaecati perferendis reprehenderit tempora tempore tenetur velit. Accusantium adipisci amet aperiam debitis dolorem eos facere facilis fuga illo iste nesciunt non officia omnis placeat, praesentium quasi quo reiciendis reprehenderit sapiente sunt tenetur vel velit! Aut, facere!
        </div>
        <div class="light">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi asperiores aspernatur commodi cupiditate eum explicabo, illum iste magnam minima nesciunt quisquam reiciendis sed tempore! Error inventore perferendis ullam?
        </div>
        <div>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque commodi consequuntur dignissimos doloremque ducimus eius eos, error harum nam nobis nostrum nulla quas, repudiandae saepe tenetur ullam vitae voluptate? Amet aperiam culpa esse excepturi obcaecati perferendis reprehenderit tempora tempore tenetur velit. Accusantium adipisci amet aperiam debitis dolorem eos facere facilis fuga illo iste nesciunt non officia omnis placeat, praesentium quasi quo reiciendis reprehenderit sapiente sunt tenetur vel velit! Aut, facere!
        </div>
        <div class="light">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi asperiores aspernatur commodi cupiditate eum explicabo, illum iste magnam minima nesciunt quisquam reiciendis sed tempore! Error inventore perferendis ullam?
        </div>
    </div>
</body>
</html>