<?php

namespace App\Exports;

use App\Models\Clientes;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ClientesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('clientes.export',[
            'clientes' => Clientes::all()
        ]);
    }
}
