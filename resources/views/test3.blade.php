<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Simple CMS" />
    <meta name="author" content="Sheikh Heera" />
    <style>
        main {
            flex: 1 0 auto;
            }
    </style>
</head>

<body style="background-color: #35C3D6;">
    <div class="section"></div>
    <main>
        <center>
            <img class="responsive-img" style="width: 150px;" src="{{asset('imagotipo-white.png')}}" />
            <div class="section"></div>
            <div class="container">
                <div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">
                        <div class='row'>
                            <div class='col s12'>
                            <h5 class=" indigo-text" style="color:black"><strong>Resumen de compra</strong></h5>
                            <h6  style="color:black"><strong>Pagar con: Tarjeta</strong></h6>
                </div>
            </div>
            <div class='row'>
            <div class="pb-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">
          <!-- Shopping cart table -->
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col" class="border-0 bg-light"style="text-align: center;>
                    <div class="p-2 px-3 text-uppercase" style="color:#2979FF">  Producto  </div>
                  </th>
                  <th scope="col" class="border-0 bg-light"style="text-align: center;>
                    <div class="py-2 text-uppercase" style="color:#2979FF">  Cantidad  </div>
                  </th>
                  <th scope="col" class="border-0 bg-light"style="text-align: center;>
                    <div class="py-2 text-uppercase" style="color:#2979FF">  Subtotal  </div>
                  </th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
          </div>
          <!-- End -->
        </div>
            </div>
            
          
            <center>
                <div class='row'>
                  <form action="/pago" method="POST">
                    {{ csrf_field() }}
                    <input type="text" name="amount" value="10000">
                    <script
                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="pk_test_51IsJSVLAflcUgIRb3hA4UKdFk911Bmyh8CbTmCULFTExF6XH5AX6YkY3bJ7XeS65XvoUdQuzlhc4olorkoYupPSa00pMQKEJfy"
                        data-amount="10000"
                        data-name="Gracias por tu compra"
                        data-description="Llena el formulario de pago"
                        data-currency="mxn"
                        data-locale="auto">
                    </script>
                  </form>
                </div>
            </center>
            </div>
            </div>
            </div>
        </center>
        <div class="section"></div>
        <div class="section"></div>
    </main>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
</body>

</html>
