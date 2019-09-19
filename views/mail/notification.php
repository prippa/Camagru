<?php

return "
<html>
    <head>
        <title>Verify your new email</title>
        <style>
            a {
                color: #008cfb;
                text-decoration: underline;
            }
            
            a:hover {
                color: #005ca9;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <p><b>$login</b> has commented your photo</p>
        <p>Here is link to it: <a target='_blank' href='$link'>Click</a></p>
        <p>
            If you can't click the link from your email program,
            please copy this URL and paste it into your web browser:
        </p>
        <a target='_blank' href='$link'>$link</a>
    </body>
</html>
";
