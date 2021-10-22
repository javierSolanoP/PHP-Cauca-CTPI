<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Organigrama</title>

    <style>

        *{
            padding: 0
        }

        h1{
            text-align: center
        }

        table{
            width: 100%;
            border: 1px solid #249ca7
        }

        thead{
            background-color: #11aab8;
            height: 5vh
        }
        
        th{
            font-size: 150%
        }

        td{
            width: 14.30%;
            text-align: center;
            border: 1px solid #249ca7;
            border-top: none;
            border-bottom: none;
            border-left: none;
            font-size: 150%
        }
        
    </style>
</head>
<body>
    <h1>Organigrama mensual</h1>
    <hr>
    @for($i = 0; $i < 4; $i++)
        <br>
        <table>
            <thead>
                <tr>
                    <th>Lunes</th>
                    <th>Martes</th>
                    <th>Miercoles</th>
                    <th>Jueves</th>
                    <th>Viernes</th>
                    <th>Sabado</th>
                    <th>Domingo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach ($week_parse as $day)
                        <td>
                            {{ $day['work'] }} <br>
                            {{ $day['shift'] }} <br>
                            {{ $day['time']['start_time'] }} - {{ $day['time']['finish_time'] }}
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    @endfor
</body>
</html>