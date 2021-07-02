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
        </style>
    </head> 
    <body>
        <div style="text-align:center; margin-left: auto; margin-right: auto;">
            <h3>Proyecto PSY</h3>
            <h4>REPORTE DE PACIENTES</h4>

            <!-- Para reportes generales -->
            <!-- <table style="width: 100%;">
                <tr>
                    <th>Sucursal</th>
                </tr>
                <tr>
                    <td>12-12-12</td>
                </tr>
            </table> -->

            <!-- Para de personal por sucursal -->
            <!-- <table style="width: 100%; margin-top:20px;">
                <tr>
                    <th>EMPLEADO</th>
                </tr>
                <tr>
                    <td>José Díaz</td>
                </tr>
            </table> -->

            <table style="width: 100%; margin-top:20px;">
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Sucursal</th>
                </tr>
                @foreach($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->last_name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->status_patient}}</td>
                    <td>{{$user->branchOffice->name}}</td>
                </tr>
                @endforeach
            </table>
            <!-- 
            <table style="width: 100%; margin-top:20px;">
                <tr>
                    <th>TOTAL VENTAS</th>
                    <td>$ 600.00</td>
                    <th>INVERSIÓN</th>
                    <td>$ 500.00</td>
                </tr>
                <tr>
                    <th>GANANCIA</th>
                    <td>$ 200.00</td>
                    <th>DESCUENTOS</th>
                    <td>$ 0.00</td>
                </tr>
                <tr>
                    <th>GANANCIA REAL</th>
                    <td colspan="3">$ 600.00</td>
                </tr>
                <tr></tr>
                <tr>
                    <th>DINERO EFECTIVO</th>
                    <td>$ 200.00</td>
                    <th>DINERO ELECTRÓNICO</th>
                    <td>$ 200.00</td>
                </tr>
            </table> -->

            <h5 style="margin: 5px;">{{$date}}</h5>
            
        </div>
    </body>
</html>