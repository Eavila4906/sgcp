<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Reset password</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Main CSS-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>

    <style>
        html,
        body,
        .intro {
        height: 100%;
        }

        @media (min-width: 550px) and (max-width: 750px) {
        html,
        body,
        .intro {
            height: 550px;
        }
        }

        @media (min-width: 800px) and (max-width: 850px) {
        html,
        body,
        .intro {
            height: 550px;
        }
        }

        a.link {
        font-size: .875rem;
        color: #6582B0;
        }
        a.link:hover, 
        a.link:active {
        color: #426193;
        }
    </style>
    
    <body>
        <section class="intro">
            <div class="bg-image h-100">
                <div class="mask d-flex align-items-center h-100" style="background-color: #f3f2f2;">
                <div class="container">
                    <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-12 col-lg-9 col-xl-8">
                        <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-4 d-none d-md-block">
                            <img
                                src="https://mdbootstrap.com/img/Photos/Others/sidenav2.jpg"
                                alt="login form"
                                class="img-fluid" style="border-top-left-radius: 1rem; border-bottom-left-radius: 1rem;"
                            />
                            </div>
                            <div class="col-md-8 d-flex align-items-center">
                            <div class="card-body py-5 px-4 p-md-5">

                                <form action="">
                                    <h4 class="fw-bold mb-4" style="color: #92aad0;">Restablecer contraseña</h4>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example2">Nueva contraseña</label>
                                        <input type="password" id="form2Example2" class="form-control" />
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example2">Confirmar contraseña</label>
                                        <input type="password" id="form2Example2" class="form-control" />
                                    </div>

                                    <div class="d-flex justify-content-end pt-1 mb-4">
                                        <button class="btn btn-primary btn-rounded" type="button" style="background-color: #92aad0;">Listo</button>
                                    </div>
                                </form>

                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </section>
    </body>
</html>