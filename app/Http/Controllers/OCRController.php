<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Exception;

class OCRController extends Controller
{
    public function form()
    {
        return view('ocr.form');
    }

    public function extractFromForm(Request $request)
    {
        $request->validate([
            'comprobante' => 'required|image|mimes:jpg,jpeg,png'
        ]);

        $image = $request->file('comprobante');
        $path = $image->storeAs('ocr', uniqid() . '.' . $image->getClientOriginalExtension(), 'local');
        $fullPath = storage_path("app/private/{$path}");

        $output = shell_exec("/usr/local/bin/tesseract \"$fullPath\" stdout -l spa 2>&1");
        $lines = array_map('trim', preg_split("/\r\n|\n|\r/", $output));
        $lines = array_filter($lines); // Quitamos líneas vacías
        $lines = array_values($lines); // Reindexamos

        // Inicializamos datos vacíos
        $fecha = '';
        $clave_rastreo = '';
        $cuenta = '';
        $cuenta_destino = '';
        $monto = 0;
        $receptor = '';
        $emisor = '';
        $nombre_ordenante = '';
        $nombre_beneficiario = '';
        for ($i = 0; $i < count($lines); $i++) {
            $line = $lines[$i];

            // Fecha de operación
            if (stripos($line, 'Fecha de operación') !== false) {
                $rawFecha = $lines[$i + 1] ?? '';
                $fecha = \Carbon\Carbon::createFromFormat('d F Y, H:i:s \h', strtr($rawFecha, [
                    'enero' => 'January',
                    'febrero' => 'February',
                    'marzo' => 'March',
                    'abril' => 'April',
                    'mayo' => 'May',
                    'junio' => 'June',
                    'julio' => 'July',
                    'agosto' => 'August',
                    'septiembre' => 'September',
                    'octubre' => 'October',
                    'noviembre' => 'November',
                    'diciembre' => 'December',
                ]))->toDateString();
            }

            // Clave de rastreo
            if (stripos($line, 'Clave de rastreo') !== false && isset($lines[$i + 1])) {
                $clave_rastreo = $lines[$i + 1];
            }

            // Cuenta origen
            if (stripos($line, 'Cuenta de retiro') !== false && isset($lines[$i + 1])) {
                $cuenta = $lines[$i + 1];
            }

            // Cuenta destino
            if (stripos($line, 'Cuenta (CLABE') !== false && isset($lines[$i + 1])) {
                $cuenta_destino = $lines[$i + 1];
            }

            // Monto / Importe
            if (stripos($line, 'Importe') !== false && isset($lines[$i + 1])) {
                $importeLinea = $lines[$i + 1];
                if (preg_match('/(\$-?)([\d.,]+)/', $importeLinea, $match)) {
                    $valor = floatval(str_replace(',', '', $match[2]));
                    $monto = (int) round($valor * 100); // ← solo si necesitas centavos
                }
            }

            // Banco destino
            if (stripos($line, 'Banco destino') !== false && isset($lines[$i + 1])) {
                $receptor = strtoupper($lines[$i + 1]);
            }

            if (stripos($line, 'Nombre del ordenante') !== false && isset($lines[$i + 1])) {
                $nombre_ordenante = $lines[$i + 1];
            }

            if (stripos($line, 'Nombre del beneficiario') !== false && isset($lines[$i + 1])) {
                $nombre_beneficiario = $lines[$i + 1];
            }
        }

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
        $data = [
            'fecha' => $fecha,
            'clave_rastreo' => 'MBAN01002504100065360870',
            'emisor' => '40012', // <- BBVA correcto
            'receptor' => '40014', // <- STP (si aplica)
            'cuenta' => $cuenta_destino,
            'cuenta_destino' => $cuenta_destino,
            'monto' => $monto,
            'nombre_ordenante' => $nombre_ordenante,
            'nombre_beneficiario' => $nombre_beneficiario,
        ];

        [$anio, $mes, $dia] = array_map('intval', explode('-', $data['fecha']));

        $clave = addslashes($data['clave_rastreo']);
        $emisor = addslashes($data['emisor']);

        $receptor = addslashes($data['receptor']);
        $cuenta = addslashes($data['cuenta']);
        $monto = intval($data['monto']);
        $pythonScript = <<<PYTHON
        from datetime import date
        from cep import Transferencia
        from cep.exc import TransferNotFoundError

        try:
            tr = Transferencia.validar(
                fecha=date($anio, $mes, $dia),
                clave_rastreo='$clave',
                emisor='$emisor',
                receptor='$receptor',
                cuenta='$cuenta',
                monto=$monto,
            )
            pdf = tr.descargar()
            with open('CUENCA_$clave.pdf', 'wb') as f:
                f.write(pdf)
        except TransferNotFoundError as e:
            print('No se encontro la transferencia')
        PYTHON;

        file_put_contents('cuenta.py', $pythonScript);

        // Ejecutar el script
        $output = shell_exec('python3 cuenta.py 2>&1');
        echo "<pre>$output</pre>";
        return view('ocr.form', [
            'data' => [
                'fecha' => $fecha,
                'clave_rastreo' => $clave_rastreo,
                'emisor' => $emisor, // Código numérico de BBVA
                'receptor' => $receptor,
                'cuenta' => $cuenta,
                'cuenta_destino' => $cuenta_destino,
                'monto' => $monto,
                'nombre_ordenante' => $nombre_ordenante,
                'nombre_beneficiario' => $nombre_beneficiario,
            ]
        ]);
    }
    public function obtenerBancoDesdeClabe(string $clabe): string
    {
        // Asegura que la CLABE tenga al menos los 3 primeros dígitos
        if (strlen($clabe) < 3) {
            throw new Exception("CLABE demasiado corta.");
        }

        // Extrae los primeros 3 dígitos que representan el banco
        return substr($clabe, 0, 3);
    }

    public function obtenerNombreBanco(string $codigo): string
    {
        $codigosBancos = [
            '002' => 'BANAMEX',
            '006' => 'BANCOMEXT',
            '009' => 'BANOBRAS',
            '012' => 'BBVA BANCOMER',
            '014' => 'SANTANDER',
            '019' => 'BANJÉRCITO',
            '021' => 'HSBC',
            '030' => 'BAJÍO',
            '032' => 'IXE',
            '036' => 'INBURSA',
            '037' => 'INTERACCIONES',
            '042' => 'MIFEL',
            '044' => 'SCOTIABANK',
            '058' => 'BANREGIO',
            '059' => 'INVEX',
            '060' => 'BANSI',
            '062' => 'AFIRME',
            '072' => 'BANORTE',
            '102' => 'ACCENDO BANCO',
            '103' => 'AMERICAN EXPRESS',
            '106' => 'BANK OF AMERICA',
            '108' => 'MUFG',
            '110' => 'JP MORGAN',
            '112' => 'BMONEX',
            '113' => 'VE POR MÁS',
            '116' => 'INTERCAM BANCO',
            '124' => 'DEUTSCHE',
            '126' => 'CREDIT SUISSE',
            '127' => 'BANCO AZTECA',
            '128' => 'AUTOFIN',
            '129' => 'BARCLAYS',
            '130' => 'COMPARTAMOS',
            '131' => 'BANCO FAMSA',
            '132' => 'BMULTIVA',
            '133' => 'ACTINVER',
            '134' => 'WAL-MART',
            '135' => 'NAFIN',
            '136' => 'INTERCAM CASA DE BOLSA',
            '137' => 'BANCOPPEL',
            '138' => 'ABC CAPITAL',
            '139' => 'UBS BANK',
            '140' => 'CONSUBANCO',
            '143' => 'VOLKSWAGEN BANK',
            '145' => 'CIBANCO',
            '147' => 'BANKAOOL',
            '148' => 'BBASE',
            '150' => 'DONDE',
            '152' => 'BANCREA',
            '154' => 'BANCO SABADELL',
            '155' => 'SHINHAN BANK',
            '156' => 'BANCO FINTERRA',
            '157' => 'ICBC',
            '158' => 'SABADELL CAPITAL',
            '160' => 'BANK OF CHINA',
            '166' => 'BANSEFI / BIENESTAR',
            '168' => 'JP SOFI MX',
            '600' => 'MONEDERO ELECTRÓNICO',
            '601' => 'CUENTA DE NÓMINA',
        ];
        if (!isset($codigosBancos[$codigo])) {
            dd(vars: $codigo);

            throw new Exception("Código de banco inválido: {$codigo}");
        }

        return $codigosBancos[$codigo];
    }
    public function obtenerNombreBancos(string $codigo): string
    {
        $codigosBancos = [
            '002' => 'BANAMEX',
            '006' => 'BANCOMEXT',
            '009' => 'BANOBRAS',
            '012' => 'BBVA',
            '014' => 'SANTANDER',
            '019' => 'BANJÉRCITO',
            '021' => 'HSBC',
            '030' => 'BAJÍO',
            '032' => 'IXE',
            '036' => 'INBURSA',
            '037' => 'INTERACCIONES',
            '042' => 'MIFEL',
            '044' => 'SCOTIABANK',
            '058' => 'BANREGIO',
            '059' => 'INVEX',
            '060' => 'BANSI',
            '062' => 'AFIRME',
            '072' => 'BANORTE',
            '102' => 'ACCENDO BANCO',
            '103' => 'AMERICAN EXPRESS',
            '106' => 'BANK OF AMERICA',
            '108' => 'MUFG',
            '110' => 'JP MORGAN',
            '112' => 'BMONEX',
            '113' => 'VE POR MÁS',
            '116' => 'INTERCAM BANCO',
            '124' => 'DEUTSCHE',
            '126' => 'CREDIT SUISSE',
            '127' => 'BANCO AZTECA',
            '128' => 'AUTOFIN',
            '129' => 'BARCLAYS',
            '130' => 'COMPARTAMOS',
            '131' => 'BANCO FAMSA',
            '132' => 'BMULTIVA',
            '133' => 'ACTINVER',
            '134' => 'WAL-MART',
            '135' => 'NAFIN',
            '136' => 'INTERCAM CASA DE BOLSA',
            '137' => 'BANCOPPEL',
            '138' => 'ABC CAPITAL',
            '139' => 'UBS BANK',
            '140' => 'CONSUBANCO',
            '143' => 'VOLKSWAGEN BANK',
            '145' => 'CIBANCO',
            '147' => 'BANKAOOL',
            '148' => 'BBASE',
            '150' => 'DONDE',
            '152' => 'BANCREA',
            '154' => 'BANCO SABADELL',
            '155' => 'SHINHAN BANK',
            '156' => 'BANCO FINTERRA',
            '157' => 'ICBC',
            '158' => 'SABADELL CAPITAL',
            '160' => 'BANK OF CHINA',
            '166' => 'BANSEFI / BIENESTAR',
            '168' => 'JP SOFI MX',
            '600' => 'MONEDERO ELECTRÓNICO',
            '601' => 'CUENTA DE NÓMINA',
        ];

        if (array_key_exists($codigo, $codigosBancos)) {
            return $codigosBancos[$codigo];
        }



        return $codigosBancos[$codigo];
    }
}
