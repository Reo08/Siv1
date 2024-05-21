<?php

namespace App\Exports;

use App\Models\SalidasPerdidas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PerdidasExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('perdidas.export',[
            'perdidas' => SalidasPerdidas::all()
        ]);
    }
}
