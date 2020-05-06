<!doctype html>
<html lang="pl">
<head>
    <base href="/"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>

        * {
            margin: 0;
            font-family: Roboto, sans-serif
        }

        body, html {
            height: 100%;
            background: #ffffff;
            line-height: 1.5em;
        }

        .form-container {
            background: #fff;
            max-width: 740px;
            padding: 40px;
            font-family: Roboto, sans-serif;
            color: #5d6162;
            font-size: 14px;
            font-weight: 300;
        }

        h1 {
            color: #da0050;
            font-weight: 300;
            font-size: 2.4em;
            margin-bottom: .6em;
            line-height: normal;
            -webkit-font-smoothing: subpixel-antialiased
        }

        h2 {
            color: #889198;
            font-weight: 300;
            font-size: 1.8em;
            margin-bottom: .2em;
            line-height: normal;
            -webkit-font-smoothing: subpixel-antialiased
        }

        strong {
            font-weight: 400
        }

        small {
            font-size: 11px;
        }

        a:link, a:visited {
            color: #da0050;
            transition-property: color;
            transition-duration: .1s
        }

        a:hover {
            color: #00bed3
        }

    </style>
</head>
<body>

<div class="form-container">

    <img src="https://jobs.kissdigital.com/kiss/images/kiss.png" alt="KISS digital logo"
         style="display:block;margin:0 auto;margin-bottom:60px;max-width: 200px;" />

    {!! $messageToSend->body !!}

    <div style="display:block;margin:0 auto;padding-top:60px;text-align:center;">
        <small>
            <a href="https://kissdigital.com/jobs">Aktualne oferty pracy</a>
            |
            <a href="mailto:jobs@kissdigital.com">jobs@kissdigital.com</a>
        </small>
    </div>

</div>

</body>
</html>

