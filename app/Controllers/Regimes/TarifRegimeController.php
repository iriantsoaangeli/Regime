<?php

namespace App\Controllers\Regimes;

use App\Controllers\BaseController;
use App\Models\Regimes\TarifRegime;

class TarifRegimeController extends BaseController
{
    public function index($regimeId)
    {
        $model = new TarifRegime();
        $data['tarifs'] = $model->where('regime_id', $regimeId)->findAll();
        
        return view('admin-tarifs-regime', $data);
    }

    public function store($regimeId)
    {
        $model = new TarifRegime();
        $data = $this->request->getPost();
        $data['regime_id'] = $regimeId;
        $data['is_actif'] = 1;
        
        $model->insert($data);
        
        return redirect()->back()->with('message', 'Tarif ajouté avec succès');
    }

    public function update($id)
    {
        $model = new TarifRegime();
        $data = $this->request->getPost();
        $model->update($id, $data);
        
        return redirect()->back()->with('message', 'Tarif mis à jour');
    }

    public function destroy($id)
    {
        $model = new TarifRegime();
        $model->update($id, ['is_actif' => 0]);
        
        return redirect()->back()->with('message', 'Tarif désactivé');
    }
}
