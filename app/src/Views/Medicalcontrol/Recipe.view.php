<html>
    <head>
        <meta charset="UTF-8">
        <title>Receta medica</title>
        <link rel="stylesheet" type="text/css" href="../app/Assets/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="../app/Assets/css/recipe.css">
    </head>
    <body>

        <?php
            if (!empty($data)) {
        ?>
        <div class="row mt-3 mb-3">

            <div class="col-sm-6">
                <div class="row">
                    <div class="col-md-2">
                        <img src="../app/Assets/Images/logo.png" class="ml-lg image-size">
                    </div>
                    <div class="ms-2 col-md-7">
                        <div class="text-center font-time line-m">
                            <p class="blod-font font-s14">Dr. Jhonny Hidalgo Palacios</p>
                            <p class="blod-font font-s12">Pediatra - Neonatólogo</p>
                            <p class="blod-font font-s10">ESPECIALIZADO EN ARGENTINA</p>
                            <p style="font-size: 11.5px;">Atención de Lunes a Viernes de 10h00 - 13h00 y de 16h00 - 18h00</p>
                            <p style="font-size: 11.5px;">Sábado de 10h00 - 12h00 - Celular 0994441106</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <img src="../app/Assets/Images/pedia.png" class="image-size-m">
                    </div>
                </div>
                <hr>
                <div class="ms-5 font-time font-s12 line-s">
                    <div class="row">
                        <div class="col-md-6">
                            <p><span class="blod-font font-s12">Paciente: </span><?=$data['patient']?></p>
                        </div>
                        <div class="col-md-6">
                            <p><span class="blod-font font-s12">Edad: </span><?=$data['age']?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><span class="blod-font font-s12">Fecha: </span><?=$data['date']?></p>
                        </div>
                        <div class="col-md-6">
                            <p>
                                <span class="blod-font font-s12">Peso: </span>
                                <?=$data['weight_kg'].'kg - '.$data['weight_pounds'].'lb'?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><span class="blod-font font-s12">Estatura: </span><?=$data['height_cm'].'cm'?></p>
                        </div>
                        <div class="col-md-6">
                            <p>
                                <span class="blod-font font-s12">IMC: </span>
                                <?=$data['bmi_quant'].' - '.$data['bmi_quali']?>
                            </p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="content">
                    <div class="ms-5">
                        <b class="font-time font-s12">RP:</b>
                        <img src="../app/Assets/Images/watermark.png" class="watermark">
                        <div class="ms-5 font-time font-s12">
                            <?=$data['medication']?>
                        </div>
                    </div>
                </div>
                <hr>
                <footer class="text-center font-time line-s">
                    <p class="font-s9">Consultas: 0999787684 (Movistar)</p>
                    <p class="font-s9">Dirección: Pedro Gual y 18 de Octubre - Portoviejo</p>
                </footer>
            </div>              
            

            <div class="col-sm-6">
                <div class="row">
                    <div class="col-md-2">
                        <img src="../app/Assets/Images/logo.png" class="ml-lg image-size">
                    </div>
                    <div class="ms-2 col-md-7">
                        <div class="text-center font-time line-m">
                            <p class="blod-font font-s14">Dr. Jhonny Hidalgo Palacios</p>
                            <p class="blod-font font-s12">Pediatra - Neonatólogo</p>
                            <p class="blod-font font-s10">ESPECIALIZADO EN ARGENTINA</p>
                            <p style="font-size: 11.5px;">Atención de Lunes a Viernes de 10h00 - 13h00 y de 16h00 - 18h00</p>
                            <p style="font-size: 11.5px;">Sábado de 10h00 - 12h00 - Celular 0994441106</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <img src="../app/Assets/Images/pedia.png" class="image-size-m">
                    </div>
                </div>
                <hr>
                <div class="ms-5 font-time font-s12 line-s">
                    <div class="row">
                        <div class="col-md-6">
                            <p><span class="blod-font font-s12">Paciente: </span><?=$data['patient']?></p>
                        </div>
                        <div class="col-md-6">
                            <p><span class="blod-font font-s12">Edad: </span><?=$data['age']?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><span class="blod-font font-s12">Fecha: </span><?=$data['date']?></p>
                        </div>
                        <div class="col-md-6">
                            <p>
                                <span class="blod-font font-s12">Peso: </span>
                                <?=$data['weight_kg'].'kg - '.$data['weight_pounds'].'lb'?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><span class="blod-font font-s12">Estatura: </span><?=$data['height_cm'].'cm'?></p>
                        </div>
                        <div class="col-md-6">
                            <p>
                                <span class="blod-font font-s12">IMC: </span>
                                <?=$data['bmi_quant'].' - '.$data['bmi_quali']?>
                            </p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="content">
                    <div class="ms-5">
                        <b class="font-time font-s12">Indicaciones:</b>
                        <img src="../app/Assets/Images/watermark.png" class="watermark">
                        <div class="ms-5 font-time font-s12">
                            <?=$data['indication']?>
                        </div>
                    </div>
                </div>
                <hr>
                <footer class="text-center font-time line-s">
                    <p class="font-s9">Consultas: 0999787684 (Movistar)</p>
                    <p class="font-s9">Dirección: Pedro Gual y 18 de Octubre - Portoviejo</p>
                </footer>
            </div>    

        </div>
        <?php
            } else {
        ?>
        <div class="col-md-11 text-center mt-5 ms-5">
            <div class="alert alert-warning align-items-center" role="alert">
                <div>
                    <strong>Atención!</strong> No se encontró ninguna receta para esta cita.
                </div>
            </div>
        </div>
        <?php
            }
        ?>
        
    </body>
</html>