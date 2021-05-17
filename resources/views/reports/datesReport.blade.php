<html>
    <head>
        <style type="text/css">
            table {
                border-collapse: collapse;
            }

            table, th, td {
                border: 1px solid black;
                text-align: center;
                border-color: #424242;
            }
            .backgroundColor{
                background: #14458D;
            }
        </style>
    </head> 
    <body>
        <div style="text-align:center; margin-left: auto; margin-right: auto;">
        
            <h4 >REPORTE DE USUARIOS</h4>
            <h5 >REPORTE GENERADO EL {{$now}} </h5>
            <table style="width: 100%; margin-top:20px;">
                <tr>
                    <th class="backgroundColor">DOCTOR</th>
                    <th class="backgroundColor">PACIENTE</th>
                    <th class="backgroundColor">INICIO</th>
                    <th class="backgroundColor">FIN</th>
                    <th class="backgroundColor">FECHA</th>
                </tr>
                @foreach ($dates as $item)
                <tr>
                    <td> {{$item["doctor"]["name"]}} </td>
                    <td> {{$item["patient"]["name"]}} </td>
                    <td> {{$item["shiftInit"]["time"] }} </td>
                    <td> {{$item["shiftEnd"]["time"]}} </td>
                    <td> {{$item["date"]}} </td>
                </tr>
                @endforeach
            </table>



            {{-- <h5 style="margin: 20px;">REPORTE GENERADO POR {{strtoupper($user->name)}}</h5> --}}
            
        </div>
    </body>
</html>