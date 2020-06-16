<!doctype html>
<html lang="pl">
<head>
    <base href="/" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>


    </style>
</head>
<body style="background:#dfdfdf;padding:40px;">

<div style="background:white;font-family: Arial, Helvetica, sans-serif;font-size:15px;max-width: 600px;margin:0 auto">
    <div
        style="padding:5px;font-size:16px;background:linear-gradient(124deg, rgba(194,0,251,1) 0%, rgba(255,210,63,1) 90%);color:white"></div>

    <div style="padding:40px 30px 60px 30px;color:rgba(0, 0, 0, 0.87);line-height: 1.35em;">
        Zostałeś zaproszony do zespołu korzystające z systemu <a
            href="https://applicake.to">Applicake.to</a><br /><br />

        Aby przyjąć zaproszenie kliknij poniższy przycisk albo przejdź na stronę
        https://b.applicake.to/invitation/{{ $invitation->subdomain }}/{{ $invitation->token }}.<br /><br />

        <a style="background:#2ec4b6;color:white;padding:6px 16px;text-decoration:none;border-radius:4px;"
           href="https://b.applicake.to/invitation/{{ $invitation->subdomain }}/{{ $invitation->token }}">Przyjmij
            zaproszenie</a>
    </div>

</div>
<div style="padding-top:30px;max-width: 600px;margin:0 auto;text-align: center;">
    <a href="https://b.applicake.to/">b.applicake.to</a>
</div>
</div>
</body>
</html>
