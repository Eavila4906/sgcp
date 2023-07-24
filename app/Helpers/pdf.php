<?php
    require_once("./app/Libraries/Reports/TcPDF/tcpdf.php");

    class PDF extends TCPDF {
        public function Header() {
            $image_file = './app/Libraries/Reports/TcPDF/examples/images/logo.png';
            $this->Image($image_file, 10, 2, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $this->SetY(10);

            $this->SetFont('times', 'B', 12);
            $this->SetX(40); 
            $this->Cell(0, 10, 'Consultorio "Dr. Jhonny Hidalgo Palacios"', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(5);
            $this->SetFont('times', '', 11);
            $this->SetX(40); 
            $this->Cell(0, 10, 'Centro de pediatría y neonatología', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(5);

            $this->SetFont('times', '', 10);
            $this->SetX(40); 
            $this->Cell(0, 10, 'Fecha: ' . date('Y-m-d H:i:s'), 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(8);

            $this->SetLineWidth(0.3);
            $this->Line(10, $this->getY(), $this->getPageWidth() - 10, $this->getY()); 
            $this->Ln(5);
        }

        public function Footer() {
            $this->SetY(-18); 
            $this->SetLineWidth(0.2); 
            $this->Line(10, $this->getY(), $this->getPageWidth() - 10, $this->getY());
            
            $this->SetY(-18);
            $this->SetFont('times', 'I', 8);
            $this->Cell(0, 10, 'Contactos: 0999787684', 0, false, 'L', 0, '', 0, false, 'T', 'M');
            $this->SetY(-15);
            $this->SetFont('times', 'I', 8);
            $this->Cell(0, 10, 'Dirección: Pedro Gual y 18 de Octubre', 0, false, 'L', 0, '', 0, false, 'T', 'M');
            $this->SetY(-18);
            $this->SetFont('times', 'I', 8);
            $this->Cell(0, 10, "Página " . $this->getAliasNumPage() . "/" . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        }
    }
    
    function rptPatient($data) {
        // create new PDF document
        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetTitle('Reporte de paciente');

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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

    function pr() {
        // create new PDF document
        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->Output('datos_personales.pdf', 'I');
    }
?>