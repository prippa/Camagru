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
        <p>Hi $login!</p>
        <p>Please <a target='_blank' href='$link'>Click this link</a> to confirm your new email address.</p>
        <p>
            If you can't click the link from your email program,
            please copy this URL and paste it into your web browser:
        </p>
        <a target='_blank' href='$link'>$link</a>
        <p>
            If you don’t use this link within 3 hours, it will expire.
        </p>
    </body>
</html>
";
