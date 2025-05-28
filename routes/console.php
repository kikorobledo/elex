<?php

use App\Models\Seccion;
use App\Models\Referido;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('cargar_referidos', function (){

    $fileStream = fopen(storage_path('app/public/referidos.csv'), 'r');

    $csvContents = [];

    while (($line = fgetcsv($fileStream)) !== false) {

        $csvContents[] = $line;

    }

    fclose($fileStream);

    $skipHeader = true;

    try {

        foreach($csvContents as $content){

            if ($skipHeader) {

                $skipHeader = false;

                continue;

            }

            $seccion = Seccion::where('seccion', (int)$content[7])->first();

            Referido::create([
                'nombre' => $content[1],
                'telefono' => $content[2],
                'domicilio' => $content[3],
                'colonia' => $content[4],
                'cp' => (int)$content[5],
                'municipio' => $content[6],
                'clave_electoral' => $content[8],
                'referente_id' => $content[0],
                'candidato_id' => 3,
                'seccion_id' => $seccion?->id
            ]);

        }

    } catch (\Throwable $th) {

        return "Error: " . $th->getMessage();

        Log::error('Error al importar referidos. ' . $th);

    }

    return "Imported!";

});