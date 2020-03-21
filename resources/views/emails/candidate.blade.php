<!doctype html>
<html lang="pl">
<head>
    <base href="/"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>

        a, button {
            cursor: pointer
        }

        * {
            margin: 0;
            font-family: Roboto, sans-serif
        }

        body, html {
            height: 100%;
            background: #da0050;
            font-family: Roboto, sans-serif
        }

        .form-container {
            background: #fff;
            max-width: 740px;
            padding: 40px;
            margin: 0 auto;
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

        em {
            font-style: italic
        }

        code {
            font-family: Monospace, Monospaced
        }

        strong {
            font-weight: 400
        }

        small {
            font-size: .7em
        }

        a, a:visited {
            color: #da0050;
            transition-property: color;
            transition-duration: .1s
        }

        a:hover {
            color: #00bed3
        }

        p, label {
            color: #5d6162;
            font-weight: 300;
            font-size: 1.15em;
            line-height: 1.5em;
            margin-bottom: 1em
        }

        a.button, a.button:visited, button {
            display: inline-block;
            color: #da0050;
            text-transform: uppercase;
            font-size: 1.1em;
            line-height: 1.5em;
            padding: 8px 26px;
            background: 0 0;
            border: 2px solid #da0050;
            transform: skewX(-45deg);
            transition-property: background, color;
            transition-duration: .1s;
            -webkit-font-smoothing: subpixel-antialiased
        }

        a.button-white, a.button-white:visited {
            color: #fff;
            border-color: #fff
        }

        a.button.color-green, a.button.color-green:visited {
            color: #7ec665;
            border-color: #7ec665
        }

        .button span, button span {
            font-size: 19px;
            display: inline-block;
            transform: skewX(45deg)
        }

        a.button:hover, button:hover {
            background: #da0050;
            color: #fff
        }

        .center {
            margin-left: auto;
            margin-right: auto;
            text-align: center
        }

    </style>
</head>
<body>

<div class="form-container">

    <img src="https://jobs.kissdigital.com/kiss/images/kiss.png" alt="KISS digital logo"
         style="display:block;margin:0 auto;margin-bottom:40px;"/>

    {!! $messageToSend->body !!}

    <div class="center" style="padding-top:30px;">
        <br/><br/><br/><br/>
        <small>
            <a href="https://kissdigital.com/jobs">Aktualne oferty pracy</a>
            |
            <a href="mailto:jobs@kissdigital.com">jobs@kissdigital.com</a>
        </small>
    </div>

</div>

</body>
</html>

