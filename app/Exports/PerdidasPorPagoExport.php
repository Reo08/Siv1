<?php

namespace App\Exports;

use App\Models\SalidasPerdidasCredito;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PerdidasPorPagoExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $perdidasFacturas = SalidasPerdidasCredito::leftjoin('clientes','salidas_perdidas_credito.nit_cedula','=','clientes.nit_cedula')->get();

        return view('perdidas.exportPorPago',[
            "perdidasFacturas" => $perdidasFacturas
        ]);
    }
}
