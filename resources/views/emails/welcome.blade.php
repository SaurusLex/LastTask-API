<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif
        }

    </style>
</head>

<body>
    
    <table align='center' style='text-align:center'>
        <tr>
          <td align='center' style='text-align:center'>
            <img src="{{$message->embed(asset('public/img/logo.png'))}}" height="100" width="100">
            <h1>Enhorabuena {{$data["name"]}},</h1>
            <h4>Tu cuenta con el correo {{$data["email"]}} ha sido creada correctamente.</h4>
          </td>
        </tr>
      </table>


</body>

</html>