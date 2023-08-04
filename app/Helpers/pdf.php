<?php
    require_once("./app/Libraries/Reports/TcPDF/tcpdf.php");

    class PDF extends TCPDF {
        public function Header() {
            $image_file = './app/Libraries/Reports/TcPDF/examples/images/logo.png';
            $this->Image($image_file, 25, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $this->SetY(10);

            $this->SetFont('times', 'B', 12);
            $this->SetX(55); 
            $this->Cell(0, 10, 'Dr. Jhonny Hidalgo Palacios', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(5);
            $this->SetFont('times', '', 11);
            $this->SetX(55); 
            $this->Cell(0, 10, 'Pediatra - Neonatólogo', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(5);
            $this->SetFont('times', '', 11);
            $this->SetX(55); 
            $this->Cell(0, 10, 'E-mail: jhonnyr_dr@hotmail.com', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(5);
            $this->SetFont('times', '', 11);
            $this->SetX(55); 
            $this->Cell(0, 10, 'Contactos: 0994441106 - 0999787684', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(8);

            $this->SetLineWidth(0.3);
            $this->Line(25.4, $this->getY(), $this->getPageWidth() - 25.4, $this->getY()); 
            $this->Ln(5);
        }

        public function Footer() {
            $this->SetY(-18); 
            $this->SetLineWidth(0.2); 
            $this->Line(24.5, $this->getY(), $this->getPageWidth() - 24.5, $this->getY());
            
            $this->SetY(-18);
            $this->SetFont('times', 'I', 8);
            $this->Cell(0, 10, 'Dirección: Pedro Gual y 18 de Octubre', 0, false, 'L', 0, '', 0, false, 'T', 'M');
            $this->SetY(-15);
            $this->SetFont('times', 'I', 8);
            $this->Cell(0, 10, 'Fecha: ' . date('Y-m-d H:i:s'), 0, false, 'L', 0, '', 0, false, 'T', 'M');
            $this->SetY(-18);
            $this->SetFont('times', 'I', 8);
            $this->Cell(0, 10, "Página " . $this->getAliasNumPage() . "/" . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        }
    }

    // Report patients list
    function rptPatientList($data) {
        // Crear instancia de TCPDF
        $pdf = new PDF('P', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Establecer información del documento
        $pdf->SetTitle('Lista de pacientes');
        
        // set margins
        $margin_left = 25.4; 
        $margin_top = 45.4;
        $margin_right = 25.4;
        $margin_bottom = 25.4;
        $pdf->SetMargins($margin_left, $margin_top, $margin_right);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 10);
        
        // Inicializar variable para almacenar el contenido de la tabla
        $table_content = '';
        $max_registers = 20;
        $total_registers = count($data);
        // Datos de ejemplo para los registros
        if ($total_registers == 0) {
            $pdf->AddPage();
            $pdf->writeHTML('<h1>NO HAY REGISTROS</h1>', true, false, true, false, '');
        }
        for ($i=0; $i < count($data); $i++) {
            // Datos de ejemplo para cada registro
            $id = $i+1;
            $dni = $data[$i]['dni'];
            $patient = $data[$i]['patient'];
            $age = $data[$i]['age'];
            $sex = $data[$i]['sex'] == 'M' ? 'Masculino' : 'Femenino';
        
            // Agregar una fila con los datos de cada registro a la variable $contenido_tabla
            $table_content .= '<tr>
                <td class="cell-sm text-center">'.$id.'</td>
                <td class="cell-md text-center">'.$dni.'</td>
                <td class="cell-xl">'.$patient.'</td>
                <td class="cell-md text-center">'.$age.'</td>
                <td class="cell-md text-center">'.$sex.'</td>
            </tr>';
            
            // Si se ha alcanzado el límite de registros por página, generar una nueva página
            if (($i + 1) % $max_registers == 0 || ($i + 1) == $total_registers) {
                // Establecer una nueva página si no es la primera iteración
                if ($table_content != '') {
                    $pdf->AddPage();
                }
        
                // Establecer el contenido de la plantilla en la nueva página
                $template = '
                    <style>
                        .text-center {
                            text-align: center;
                        }
                        .font-s14 {
                            font-size: 14pt;
                        }
                        .font-s12 {
                            font-size: 12pt;
                        }
                        .font-time {
                            font-family: "Times New Roman", Times, serif;
                        }
                        .blod-font {
                            font-weight: bold;
                        }
                        .b-header {
                            background-color: #78a7ff;
                        }
                        .cell-header {
                            height: 30px;
                        }
                        .cell-sm {
                            width: 10%;
                        }
                        .cell-md {
                            width: 20%;
                        }
                        .cell-lg {
                            width: 30%;
                        }
                        .cell-xl {
                            width: 40%;
                        }
                        table {
                            width: 100%;
                            border: 0.5px solid #000;

                            vertical-align: middle;
                            line-height: 25px;
                        }
                        tr th {
                            text-align: center;
                        }
                        th, td {
                            margin-left: 10px;
                            border: 0.2px solid #000;
                        }    
                    </style>

                    <h3 class="font-time">LISTA DE PACIENTE</h3>
                    <table class="font-time">
                        <tr class="font-s14">
                            <th class="b-header cell-header cell-sm blod-font">ID</th>
                            <th class="b-header cell-md blod-font">CEDULA</th>
                            <th class="b-header cell-xl blod-font">PACIENTE</th>
                            <th class="b-header cell-md blod-font">EDAD</th>
                            <th class="b-header cell-md blod-font">SEXO</th>
                        </tr>
                        <tbody class="font-s12">
                            ' . $table_content . '
                        </tbody>
                    </table>
                ';
        
                // Imprimir el contenido en el PDF
                $pdf->writeHTML($template, true, false, true, false, '');
        
                // Reiniciar la variable para la siguiente página
                $table_content = '';
            } 


        }

        
        
        // Generar el PDF
        $pdf->Output('Lista de pacientes.pdf', 'I');
    }

    // Report data personal patient
    function rptPatient($data) {
        // create new PDF document
        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetTitle('Reporte de paciente');

        // set margins
        $margin_left = 25.4; 
        $margin_top = 25.4;
        $margin_right = 25.4;
        $margin_bottom = 25.4;
        $pdf->SetMargins($margin_left, $margin_top, $margin_right);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 10);

        // Agregar una página
        $pdf->AddPage();

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

         // Establecer el contenido de la plantilla
        $template = '
            <style>
                table {
                    margin-top : 0px;
                    font-family: "times", sans-serif;
                }
                .margin {
                    margin-left: 20px;
                }
                .title {
                    font-family: "times", sans-serif;
                    text-align: center;
                    line-height: 0.6;
                }
            </style>

            <div class="title">
                <br><br>
                <h3>REPORTE DE PACIENTE</h3>
                <p>{{patient}}</p>
            </div>

            <table>
               
                <h4>DATOS PERSONALES:</h4>

                <tbody>
                    <tr>
                        <td><b>Nombres</b></td>
                        <td>{{name}}</td>
                    </tr>
                    <tr>
                        <td><b>Apellidos</b></td>
                        <td>{{lastname}}</td>
                    </tr>
                    <tr>
                        <td><b>Fecha de nacimiento</b></td>
                        <td>{{birthdate}}</td>
                    </tr>
                    <tr>
                        <td><b>Edad</b></td>
                        <td>{{age}}</td>
                    </tr>
                    <tr>
                        <td><b>Sexo</b></td>
                        <td>{{sex}}</td>
                    </tr>
                    <tr>
                        <td><b>Peso <small>(kilogramos)</small></b></td>
                        <td>{{weight_kg}} kg</td>
                    </tr>
                    <tr>
                        <td><b>Peso <small>(libras)</small></b></td>
                        <td>{{weight_pounds}} lb</td>
                    </tr>
                    <tr>
                        <td><b>Estatura</b></td>
                        <td>{{height}} cm</td>
                    </tr>
                    <tr>
                        <td><b>Tipo de sangre</b></td>
                        <td>{{blood_type}}</td>
                    </tr>
                </tbody>
            </table>

            <table>

                <h4>OBSERVACIONES:</h4>

                <tbody>
                    <tr>
                        <td><b>Familiares</b></td>
                        <td>{{family_obs}}</td>
                    </tr>
                    <tr>
                        <td><b>Personales</b></td>
                        <td>{{personal_obs}}</td>
                    </tr>
                    <tr>
                        <td><b>Generales</b></td>
                        <td>{{general_obs}}</td>
                    </tr>
                </tbody>
            </table>
                
            <table>

                <h4>FAMILIARES - REPRESENTANTE:</h4>

                <tbody>
                    <tr>
                        <td><b>Padre</b></td>
                        <td>{{father}}</td>
                    </tr>
                    <tr>
                        <td><b>Madre</b></td>
                        <td>{{mother}}</td>
                    </tr>
                    <tr>
                        <td><b>Representante</b></td>
                        <td>{{representative}}</td>
                    </tr>
                </tbody>
            </table>

            <table>

                <h4>Disponibilidad - Registro:</h4>

                <tbody>
                    <tr>
                        <td><b>Estado</b></td>
                        <td>{{status}}</td>
                    </tr>
                    <tr>
                        <td><b>Fecha de registro</b></td>
                        <td>{{reg_date}}</td>
                    </tr>
                </tbody>
            </table>
        ';

        $html = str_replace(
            array(
                '{{patient}}',
                '{{name}}',
                '{{lastname}}', 
                '{{birthdate}}', 
                '{{age}}',
                '{{sex}}',
                '{{weight_kg}}',
                '{{weight_pounds}}',
                '{{height}}',
                '{{blood_type}}',
                '{{family_obs}}',
                '{{personal_obs}}',
                '{{general_obs}}',
                '{{father}}',
                '{{mother}}',
                '{{representative}}',
                '{{status}}',
                '{{reg_date}}'
            ),
            array(
                $data['patient'], 
                $data['name'], 
                $data['lastname'], 
                $data['birthdate'], 
                $data['age'],
                $data['sex'],
                $data['weight_kg'],
                $data['weight_pounds'],
                $data['height'],
                $data['blood_type'],
                $data['family_obs'],
                $data['personal_obs'],
                $data['general_obs'],
                $data['father'],
                $data['mother'],
                $data['representative'],
                $data['status'],
                $data['reg_date']
            ),
            $template
        );

        // Generar el contenido en el PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('datos_personales.pdf', 'I');
    }

    // Report medical certificate
    function rptCertificate($data) {
        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'Letter', true, 'UTF-8', false);
        $pdf->SetTitle('Certificado medico');

        // set margins
        $margin_left = 25.4; 
        $margin_top = 25.4;
        $margin_right = 25.4;
        $margin_bottom = 25.4;
        $pdf->SetMargins($margin_left, $margin_top, $margin_right);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 10);

        // add page
        $pdf->AddPage();

        $template = '
            <style>
                p {
                    font-family: "times", sans-serif;
                    text-align: justify;
                    font-size: 12pt;
                }
                .line {
                    line-height: 2.0;
                }
            </style>
            <br><br>
            <p class="line">Portoviejo, {{current_date}}</p>
            <br>
            <p class="line">Informo que {{pronoun}} paciente <b>{{patient}}</b>, con cédula 
                de ciudadanía C.I. <b>{{dni}}</b>, es atendido en mi consultorio particular ubicado 
                en la calle Pedro Gual y 18 de octubre. Se brindó la atención médica por 
                <b>{{reason}}</b>, teniendo como diagnóstico <b>{{diagnosis}}</b>, 
                enfermedad con código <b>{{disease_code}}</b>. Se envía el respectivo tratamiento y 
                reposo obligatorio por {{rest_time}}, desde el {{from_date}} hasta el {{till_date}}, 
                para observar su evolución.
                <br>
            </p>
            <p>El interesado puede hacer uso del presente certificado como crea conveniente.<br><br></p>
            <p>Atentamente.<br><br><br><br><br></p>
            <p>Dr. Jhonny Rodrigo Hidalgo Palacios<br>C.I. # 1305239293<br>PEDIATRA – NEONATÓLOGO<br>E-mail: jhonnyr_dr@hotmail.com<br>Contactos: 0994441106 - 0999787684<br></p>
        ';

        $html = str_replace(
            array(
                '{{current_date}}',
                '{{pronoun}}',
                '{{patient}}',
                '{{dni}}',
                '{{reason}}', 
                '{{diagnosis}}', 
                '{{disease_code}}',
                '{{rest_time}}',
                '{{from_date}}',
                '{{till_date}}'
            ),
            array(
                $data['current_date'],
                $data['pronoun'],
                $data['patient'], 
                $data['dni'], 
                $data['reason'], 
                $data['diagnosis'], 
                $data['disease_code'],
                $data['rest_time'],
                $data['from_date'],
                $data['till_date']
            ),
            $template
        );



        // generate content html pdf
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('Cetificado_medico.pdf', 'I');
    }
?>