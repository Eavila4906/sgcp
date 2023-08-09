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

    // Report notifications list
    function rptNotificationsList($data) {
        $pdf = new PDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetTitle('Lista de notificaciones');
        
        $margin_left = 25.4; 
        $margin_top = 45.4;
        $margin_right = 25.4;
        $margin_bottom = 25.4;
        $pdf->SetMargins($margin_left, $margin_top, $margin_right);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 10);

        if (empty($data)) {
            $pdf->AddPage();
            $pdf->writeHTML('<h1>NO HAY REGISTROS</h1>', true, false, true, false, '');
        }

        $table_content = '';
        $max_registers = 10;
        $total_registers = count($data);

        for ($i=0; $i < count($data); $i++) {
            $id = $i+1;
            $sending_user = $data[$i]['sending_user'];
            $type = $data[$i]['type'];
            $description = $data[$i]['description'];
            $date = explode(' ', $data[$i]['date']);
            $status = $data[$i]['status'];
        
            $table_content .= '<tr>
                <td class="cell-sm text-center">'.$id.'</td>
                <td class="cell-lg">'.$sending_user.'</td>
                <td class="cell-sm text-center">'.$type.'</td>
                <td class="cell-lg">'.$description.'</td>
                <td class="cell-sm text-center">'.$date[0].'</td>
                <td class="cell-sm text-center">'.$status.'</td>
            </tr>';
            
            if (($i + 1) % $max_registers == 0 || ($i + 1) == $total_registers) {
                if ($table_content != '') {
                    $pdf->AddPage();
                }
        
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
                        .cell-gd {
                            width: 25%;
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

                    <h3 class="font-time">LISTA DE NOTIFICACIONES</h3>
                    <table class="font-time">
                        <tr class="font-s14">
                            <th class="b-header cell-header cell-sm blod-font">N°</th>
                            <th class="b-header cell-lg blod-font">SOLICITANTE</th>
                            <th class="b-header cell-sm blod-font">TIPO</th>
                            <th class="b-header cell-lg blod-font">DESCRIPCION</th>
                            <th class="b-header cell-sm blod-font">FECHA</th>
                            <th class="b-header cell-sm blod-font">ESTADO</th>
                        </tr>
                        <tbody class="font-s12">
                            ' . $table_content . '
                        </tbody>
                    </table>
                ';
        
                $pdf->writeHTML($template, true, false, true, false, '');
        
                $table_content = '';
            } 

        }
        
        $pdf->Output('Lista de notificaciones.pdf', 'I');
    }

    // Report data notification
    function rptNotification($data) {
        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetTitle('Solicitud de cita');

        $margin_left = 25.4; 
        $margin_top = 45.4;
        $margin_right = 25.4;
        $margin_bottom = 25.4;
        $pdf->SetMargins($margin_left, $margin_top, $margin_right);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 10);

        $pdf->AddPage();

        if (empty($data)) {
            $pdf->writeHTML('<h1>NO HAY REGISTRO</h1>', true, false, true, false, '');
        } else {
            $template = '
                <style>
                    div {
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
                
                <h3 class="title">SOLICITUD DE CITA</h3>

                <div> 
                    <p><b>Solicitud: </b> {{sending_user}} ha solicitado una cita con el Dr. {{doctor}}</p>
                    <p><b>Paciente: </b> {{patient}}</p>
                    <p><b>Fecha de la cita: </b> {{date_appointment}}, <b>hora: </b> {{hour_appointment}}</p> 
                    <p><b>Motivo / descripción: </b> {{description}}</p>
                    <p><b>Contactos del solicitante: </p>
                    <ul>
                        <li>Telefono: {{home_phone}}</li> 
                        <li>Celular: {{cell_phone}}</li> 
                        <li>Correo electronico: {{email}}</li> 
                    </ul>
                </div>
            ';

            $html = str_replace(
                array(
                    '{{sending_user}}',
                    '{{doctor}}',
                    '{{patient}}', 
                    '{{date_appointment}}',
                    '{{hour_appointment}}', 
                    '{{description}}',
                    '{{home_phone}}',
                    '{{cell_phone}}',
                    '{{email}}'
                ),
                array(
                    $data['sending_user'], 
                    $data['doctor'], 
                    $data['patient'], 
                    $data['date_appointment'], 
                    $data['hour_appointment'], 
                    $data['description'],
                    $data['home_phone'],
                    $data['cell_phone'],
                    $data['email']
                ),
                $template
            );

            // Generar el contenido en el PDF
            $pdf->writeHTML($html, true, false, true, false, '');
        }

        $pdf->Output('Solicitud de cita.pdf', 'I');
    }

    // Report doctors list
    function rptDoctorsList($data) {
        $pdf = new PDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetTitle('Lista de doctores');
        
        $margin_left = 25.4; 
        $margin_top = 45.4;
        $margin_right = 25.4;
        $margin_bottom = 25.4;
        $pdf->SetMargins($margin_left, $margin_top, $margin_right);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 10);

        if (empty($data)) {
            $pdf->AddPage();
            $pdf->writeHTML('<h1>NO HAY REGISTROS</h1>', true, false, true, false, '');
        }

        $table_content = '';
        $max_registers = 10;
        $total_registers = count($data);

        for ($i=0; $i < count($data); $i++) {
            $id = $i+1;
            $doctor = $data[$i]['name'].' '.$data[$i]['lastname'];
            $specialty = $data[$i]['specialty'];
            $email = $data[$i]['email'];
            $home_address = $data[$i]['home_address'];
            $status = $data[$i]['status'] == 1 ? 'Activo' : 'Inactivo';
        
            $table_content .= '<tr>
                <td class="cell-sm text-center">'.$id.'</td>
                <td class="cell-lg">'.$doctor.'</td>
                <td class="cell-md text-center">'.$specialty.'</td>
                <td class="cell-md">'.$email.'</td>
                <td class="cell-md text-center">'.$home_address.'</td>
                <td class="cell-sm text-center">'.$status.'</td>
            </tr>';
            
            if (($i + 1) % $max_registers == 0 || ($i + 1) == $total_registers) {
                if ($table_content != '') {
                    $pdf->AddPage();
                }
        
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
                        .cell-gd {
                            width: 25%;
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

                    <h3 class="font-time">LISTA DE DOCTORES</h3>
                    <table class="font-time">
                        <tr class="font-s14">
                            <th class="b-header cell-header cell-sm blod-font">N°</th>
                            <th class="b-header cell-lg blod-font">DOCTOR</th>
                            <th class="b-header cell-md blod-font">ESPECIALIDAD</th>
                            <th class="b-header cell-md blod-font">E-MAIL</th>
                            <th class="b-header cell-md blod-font">DIRECCION</th>
                            <th class="b-header cell-sm blod-font">ESTADO</th>
                        </tr>
                        <tbody class="font-s12">
                            ' . $table_content . '
                        </tbody>
                    </table>
                ';
        
                $pdf->writeHTML($template, true, false, true, false, '');
        
                $table_content = '';
            } 

        }
        
        $pdf->Output('Lista de doctores.pdf', 'I');
    }

    // Report doctors list
    function rptDoctorCalendar($data) {
        $pdf = new PDF('P', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetTitle('Horario');
        
        $margin_left = 25.4; 
        $margin_top = 45.4;
        $margin_right = 25.4;
        $margin_bottom = 25.4;
        $pdf->SetMargins($margin_left, $margin_top, $margin_right);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 10);

        if (empty($data)) {
            $pdf->AddPage();
            $pdf->writeHTML('<h1>NO HAY REGISTROS</h1>', true, false, true, false, '');
        }

        $table_content = '';
        $max_registers = 10;
        $total_registers = count($data);

        for ($i=0; $i < count($data); $i++) {
            $id = $i+1;
            $date = $data[$i]['date'];
            $hours = $data[$i]['hours'];
        
            $table_content .= '<tr>
                <td class="cell-sm text-center">'.$id.'</td>
                <td class="cell-xl">'.$date.'</td>
                <td class="cell-lg text-center">'.$hours.'</td>
            </tr>';
            
            if (($i + 1) % $max_registers == 0 || ($i + 1) == $total_registers) {
                if ($table_content != '') {
                    $pdf->AddPage();
                }
        
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
                        .cell-gd {
                            width: 25%;
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

                    <h3 class="font-time">HORARIO DE LA SEMANA:</h3>
                    <p class="font-s12 font-time">'.$data[$i]['week_range'].'</p class="font-s12 font-time">
                    <table class="font-time">
                        <tr class="font-s14">
                            <th class="b-header cell-header cell-sm blod-font">N°</th>
                            <th class="b-header cell-xl blod-font">FECHA</th>
                            <th class="b-header cell-lg blod-font">HORA/S</th>
                        </tr>
                        <tbody class="font-s12">
                            ' . $table_content . '
                        </tbody>
                    </table>
                ';
        
                $pdf->writeHTML($template, true, false, true, false, '');
        
                $table_content = '';
            } 

        }
        
        $pdf->Output('Horario.pdf', 'I');
    }

    // Report appointments list
    function rptAppointmentsList($data) {
        $pdf = new PDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetTitle('Lista de citas');
        
        $margin_left = 25.4; 
        $margin_top = 45.4;
        $margin_right = 25.4;
        $margin_bottom = 25.4;
        $pdf->SetMargins($margin_left, $margin_top, $margin_right);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 10);

        if (empty($data)) {
            $pdf->AddPage();
            $pdf->writeHTML('<h1>NO HAY REGISTROS</h1>', true, false, true, false, '');
        }

        $table_content = '';
        $max_registers = 10;
        $total_registers = count($data);

        for ($i=0; $i < count($data); $i++) {
            $id = $i+1;
            $doctor = $data[$i]['doctor_c'];
            $patient = $data[$i]['patient_c'];
            $date = $data[$i]['date'];
            $hour = $data[$i]['hour'];
            $status = $data[$i]['status'];
        
            $table_content .= '<tr>
                <td class="cell-sm text-center">'.$id.'</td>
                <td class="cell-gd">'.$doctor.'</td>
                <td class="cell-gd">'.$patient.'</td>
                <td class="cell-sm text-center">'.$date.'</td>
                <td class="cell-sm text-center">'.$hour.'</td>
                <td class="cell-sm text-center">'.$status.'</td>
            </tr>';
            
            if (($i + 1) % $max_registers == 0 || ($i + 1) == $total_registers) {
                if ($table_content != '') {
                    $pdf->AddPage();
                }
        
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
                        .cell-gd {
                            width: 25%;
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

                    <h3 class="font-time">LISTA DE CITAS</h3>
                    <table class="font-time">
                        <tr class="font-s14">
                            <th class="b-header cell-header cell-sm blod-font">N°</th>
                            <th class="b-header cell-gd blod-font">DOCTOR</th>
                            <th class="b-header cell-gd blod-font">PACIENTE</th>
                            <th class="b-header cell-sm blod-font">FECHA</th>
                            <th class="b-header cell-sm blod-font">HORA</th>
                            <th class="b-header cell-sm blod-font">ESTADO</th>
                        </tr>
                        <tbody class="font-s12">
                            ' . $table_content . '
                        </tbody>
                    </table>
                ';
        
                $pdf->writeHTML($template, true, false, true, false, '');
        
                $table_content = '';
            } 

        }
        
        $pdf->Output('Lista de citas.pdf', 'I');
    }

    // Report parents list
    function rptParentsList($data) {
        $pdf = new PDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetTitle('Lista de familiares de pacientes');
        
        $margin_left = 25.4; 
        $margin_top = 45.4;
        $margin_right = 25.4;
        $margin_bottom = 25.4;
        $pdf->SetMargins($margin_left, $margin_top, $margin_right);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 10);
        
        if (empty($data)) {
            $pdf->AddPage();
            $pdf->writeHTML('<h1>NO HAY REGISTROS</h1>', true, false, true, false, '');
        }

        $table_content = '';
        $max_registers = 10;
        $total_registers = count($data);

        for ($i=0; $i < count($data); $i++) {
            $id = $i+1;
            $father = $data[$i]['father_name'].' '.$data[$i]['father_lastname'];
            $mother = $data[$i]['mother_name'].' '.$data[$i]['mother_lastname'];
            $representative = $data[$i]['representative'];
            $num_children = $data[$i]['num_children'];
        
            $table_content .= '<tr>
                <td class="cell-sm text-center">'.$id.'</td>
                <td class="cell-gd">'.$father.'</td>
                <td class="cell-gd">'.$mother.'</td>
                <td class="cell-sm text-center">'.$num_children.'</td>
                <td class="cell-gd">'.$representative.'</td>
            </tr>';
            
            if (($i + 1) % $max_registers == 0 || ($i + 1) == $total_registers) {
                if ($table_content != '') {
                    $pdf->AddPage();
                }
        
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
                        .cell-gd {
                            width: 25%;
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

                    <h3 class="font-time">LISTA DE FAMILIARES DE PACIENTES</h3>
                    <table class="font-time">
                        <tr class="font-s14">
                            <th class="b-header cell-header cell-sm blod-font">N°</th>
                            <th class="b-header cell-gd blod-font">PADRE</th>
                            <th class="b-header cell-gd blod-font">MADRE</th>
                            <th class="b-header cell-sm blod-font">N° HIJOS</th>
                            <th class="b-header cell-gd blod-font">REPRESENTANTE</th>
                        </tr>
                        <tbody class="font-s12">
                            ' . $table_content . '
                        </tbody>
                    </table>
                ';
        
                $pdf->writeHTML($template, true, false, true, false, '');
        
                $table_content = '';
            } 

        }
        
        $pdf->Output('Lista de familiares de pacientes.pdf', 'I');
    }

    // Report data parents
    function rptParents($data) {
        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetTitle('Reporte familiar');

        $margin_left = 25.4; 
        $margin_top = 45.4;
        $margin_right = 25.4;
        $margin_bottom = 25.4;
        $pdf->SetMargins($margin_left, $margin_top, $margin_right);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 10);

        $pdf->AddPage();

        if (empty($data)) {
            $pdf->writeHTML('<h1>NO HAY REGISTRO</h1>', true, false, true, false, '');
        } else {
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
                
                <h3 class="title">REPORTE FAMILIAR</h3>

                <table>
                
                    <h4>INFORMACION DE FAMILIARES:</h4>

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
                            <td><b>N° Hijos</b></td>
                            <td>{{num_children}}</td>
                        </tr>
                        <tr>
                            <td><b>Hijos / as</b></td>
                            <td>[ {{childrens}} ]</td>
                        </tr>
                        <tr>
                            <td><b>Representante</b></td>
                            <td>{{representative}}</td>
                        </tr>
                    </tbody>
                </table>

                <table>

                    <h4>CONTACTOS:</h4>

                    <tbody>
                        <tr>
                            <td><b>Correo electrónico</b></td>
                            <td>{{email}}</td>
                        </tr>
                        <tr>
                            <td><b>Telefono <small>convencional</small></b></td>
                            <td>{{home_phone}}</td>
                        </tr>
                        <tr>
                            <td><b>Celular <small>principal</small></b></td>
                            <td>{{cell_phone}}</td>
                        </tr>
                        <tr>
                            <td><b>Celular <small>secundario</small></b></td>
                            <td>{{cell_phone2}}</td>
                        </tr>
                    </tbody>
                </table>

                <table>

                    <h4>Disponibilidad - Residencia:</h4>

                    <tbody>
                        <tr>
                            <td><b>Estado</b></td>
                            <td>{{status}}</td>
                        </tr>
                        <tr>
                            <td><b>Dirección</b></td>
                            <td>{{home_address}}</td>
                        </tr>
                    </tbody>
                </table>
            ';

            $html = str_replace(
                array(
                    '{{father}}',
                    '{{mother}}',
                    '{{num_children}}', 
                    '{{childrens}}',
                    '{{representative}}', 
                    '{{email}}',
                    '{{home_phone}}',
                    '{{cell_phone}}',
                    '{{cell_phone2}}',
                    '{{status}}',
                    '{{home_address}}'
                ),
                array(
                    $data['father'], 
                    $data['mother'], 
                    $data['num_children'], 
                    $data['childrens'], 
                    $data['representative'], 
                    $data['email'],
                    $data['home_phone'],
                    $data['cell_phone'],
                    $data['cell_phone2'],
                    $data['status'],
                    $data['home_address']
                ),
                $template
            );

            // Generar el contenido en el PDF
            $pdf->writeHTML($html, true, false, true, false, '');
        }

        $pdf->Output('Reporte familiar.pdf', 'I');
    }

    // Report patients list
    function rptPatientList($data) {
        $pdf = new PDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetTitle('Lista de pacientes');
        
        $margin_left = 25.4; 
        $margin_top = 45.4;
        $margin_right = 25.4;
        $margin_bottom = 25.4;
        $pdf->SetMargins($margin_left, $margin_top, $margin_right);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 10);
        
        if (empty($data)) {
            $pdf->AddPage();
            $pdf->writeHTML('<h1>NO HAY REGISTROS</h1>', true, false, true, false, '');
        }

        $table_content = '';
        $max_registers = 10;
        $total_registers = count($data);

        for ($i=0; $i < count($data); $i++) {
            $id = $i+1;
            $dni = $data[$i]['dni'];
            $patient = $data[$i]['patient'];
            $age = $data[$i]['age'];
            $sex = $data[$i]['sex'] == 'M' ? 'Masculino' : 'Femenino';
        
            $table_content .= '<tr>
                <td class="cell-sm text-center">'.$id.'</td>
                <td class="cell-md text-center">'.$dni.'</td>
                <td class="cell-xl">'.$patient.'</td>
                <td class="cell-md">'.$age.'</td>
                <td class="cell-sm text-center">'.$sex.'</td>
            </tr>';
            
            if (($i + 1) % $max_registers == 0 || ($i + 1) == $total_registers) {
                if ($table_content != '') {
                    $pdf->AddPage();
                }
        
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
                            <th class="b-header cell-header cell-sm blod-font">N°</th>
                            <th class="b-header cell-md blod-font">CEDULA</th>
                            <th class="b-header cell-xl blod-font">PACIENTE</th>
                            <th class="b-header cell-md blod-font">EDAD</th>
                            <th class="b-header cell-sm blod-font">SEXO</th>
                        </tr>
                        <tbody class="font-s12">
                            ' . $table_content . '
                        </tbody>
                    </table>
                ';
        
                $pdf->writeHTML($template, true, false, true, false, '');
        
                $table_content = '';
            } 

        }
        
        $pdf->Output('Lista de pacientes.pdf', 'I');
    }

    // Report data personal patient
    function rptPatient($data) {
        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetTitle('Reporte de paciente');

        $margin_left = 25.4; 
        $margin_top = 45.4;
        $margin_right = 25.4;
        $margin_bottom = 25.4;
        $pdf->SetMargins($margin_left, $margin_top, $margin_right);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 10);

        $pdf->AddPage();

        if (empty($data)) {
            $pdf->writeHTML('<h1>NO HAY REGISTRO</h1>', true, false, true, false, '');
        } else {
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

                <h3 class="title">REPORTE DE PACIENTE</h3>
                <p class="title">{{patient}}</p>

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

            $pdf->writeHTML($html, true, false, true, false, '');
        }
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

    // Report modules list
    function rptModulesList($data) {
        $pdf = new PDF('P', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetTitle('Lista de modulos del sistema');
        
        $margin_left = 25.4; 
        $margin_top = 45.4;
        $margin_right = 25.4;
        $margin_bottom = 25.4;
        $pdf->SetMargins($margin_left, $margin_top, $margin_right);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 10);
        
        if (empty($data)) {
            $pdf->AddPage();
            $pdf->writeHTML('<h1>NO HAY REGISTROS</h1>', true, false, true, false, '');
        }

        $table_content = '';
        $max_registers = 20;
        $total_registers = count($data);

        for ($i=0; $i < count($data); $i++) {
            $id = $i+1;
            $module = $data[$i]['module'];
            $description = $data[$i]['description'];
            $status = $data[$i]['status'] == 1 ? 'Activo' : 'Inactivo';
        
            $table_content .= '<tr>
                <td class="cell-sm text-center">'.$id.'</td>
                <td class="cell-lg">'.$module.'</td>
                <td class="cell-xl">'.$description.'</td>
                <td class="cell-md text-center">'.$status.'</td>
            </tr>';
            
            if (($i + 1) % $max_registers == 0 || ($i + 1) == $total_registers) {
                if ($table_content != '') {
                    $pdf->AddPage();
                }
        
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

                    <h3 class="font-time">LISTA DE MODULOS DEL SISTEMA</h3>
                    <table class="font-time">
                        <tr class="font-s14">
                            <th class="b-header cell-header cell-sm blod-font">N°</th>
                            <th class="b-header cell-lg blod-font">MODULO</th>
                            <th class="b-header cell-xl blod-font">DESCRIPCION</th>
                            <th class="b-header cell-md blod-font">ESTADO</th>
                        </tr>
                        <tbody class="font-s12">
                            ' . $table_content . '
                        </tbody>
                    </table>
                ';
        
                $pdf->writeHTML($template, true, false, true, false, '');
        
                $table_content = '';
            } 

        }
        
        $pdf->Output('Lista de modulos del sistema.pdf', 'I');
    }

    // Report roles list
    function rptRolesList($data) {
        $pdf = new PDF('P', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetTitle('Lista de roles');
        
        $margin_left = 25.4; 
        $margin_top = 45.4;
        $margin_right = 25.4;
        $margin_bottom = 25.4;
        $pdf->SetMargins($margin_left, $margin_top, $margin_right);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 10);
        
        if (empty($data)) {
            $pdf->AddPage();
            $pdf->writeHTML('<h1>NO HAY REGISTROS</h1>', true, false, true, false, '');
        }

        $table_content = '';
        $max_registers = 20;
        $total_registers = count($data);

        for ($i=0; $i < count($data); $i++) {
            $id = $i+1;
            $rol = $data[$i]['rol'];
            $description = $data[$i]['description'];
            $status = $data[$i]['status'] == 1 ? 'Activo' : 'Inactivo';
        
            $table_content .= '<tr>
                <td class="cell-sm text-center">'.$id.'</td>
                <td class="cell-lg">'.$rol.'</td>
                <td class="cell-xl">'.$description.'</td>
                <td class="cell-md text-center">'.$status.'</td>
            </tr>';
            
            if (($i + 1) % $max_registers == 0 || ($i + 1) == $total_registers) {
                if ($table_content != '') {
                    $pdf->AddPage();
                }
        
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

                    <h3 class="font-time">LISTA DE ROLES</h3>
                    <table class="font-time">
                        <tr class="font-s14">
                            <th class="b-header cell-header cell-sm blod-font">N°</th>
                            <th class="b-header cell-lg blod-font">ROL</th>
                            <th class="b-header cell-xl blod-font">DESCRIPCION</th>
                            <th class="b-header cell-md blod-font">ESTADO</th>
                        </tr>
                        <tbody class="font-s12">
                            ' . $table_content . '
                        </tbody>
                    </table>
                ';
        
                $pdf->writeHTML($template, true, false, true, false, '');
        
                $table_content = '';
            } 

        }
        
        $pdf->Output('Lista de roles.pdf', 'I');
    }

    // Report users list
    function rptUsersList($data) {
        $pdf = new PDF('L', 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetTitle('Lista de usuarios');
        
        $margin_left = 25.4; 
        $margin_top = 45.4;
        $margin_right = 25.4;
        $margin_bottom = 25.4;
        $pdf->SetMargins($margin_left, $margin_top, $margin_right);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 10);
        
        if (empty($data)) {
            $pdf->AddPage();
            $pdf->writeHTML('<h1>NO HAY REGISTROS</h1>', true, false, true, false, '');
        }

        $table_content = '';
        $max_registers = 10;
        $total_registers = count($data);

        for ($i=0; $i < count($data); $i++) {
            $id = $i+1;
            $user = $data[$i]['username'];
            $rol = $data[$i]['rol'];
            $email = $data[$i]['email'];
            $status = $data[$i]['status'] == 1 ? 'Activo' : 'Inactivo';
        
            $table_content .= '<tr>
                <td class="cell-sm text-center">'.$id.'</td>
                <td class="cell-md">'.$user.'</td>
                <td class="cell-lg">'.$rol.'</td>
                <td class="cell-lg">'.$email.'</td>
                <td class="cell-sm text-center">'.$status.'</td>
            </tr>';
            
            if (($i + 1) % $max_registers == 0 || ($i + 1) == $total_registers) {
                if ($table_content != '') {
                    $pdf->AddPage();
                }
        
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

                    <h3 class="font-time">LISTA DE USUARIOS</h3>
                    <table class="font-time">
                        <tr class="font-s14">
                            <th class="b-header cell-header cell-sm blod-font">N°</th>
                            <th class="b-header cell-md blod-font">USUARIO</th>
                            <th class="b-header cell-lg blod-font">ROL</th>
                            <th class="b-header cell-lg blod-font">CORREO</th>
                            <th class="b-header cell-sm blod-font">ESTADO</th>
                        </tr>
                        <tbody class="font-s12">
                            ' . $table_content . '
                        </tbody>
                    </table>
                ';
        
                $pdf->writeHTML($template, true, false, true, false, '');
        
                $table_content = '';
            } 

        }
        
        $pdf->Output('Lista de usuarios.pdf', 'I');
    }
?>