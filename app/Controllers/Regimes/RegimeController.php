<?php

namespace App\Controllers\Regimes;

use App\Controllers\BaseController;
use App\Models\Regimes\Regime;
use App\Models\Regimes\ObjectifRegime;

class RegimeController extends BaseController
{
    public function index()
    {
        $model = new Regime();
        $data['regimes'] = $model->findAll();
        
        return view('admin-regimes', $data);
    }

    public function show($id)
    {
        $model = new Regime();
        $data['regime'] = $model->find($id);
        
        return view('regime-detail', $data);
    }

    public function store()
    {
        $model = new Regime();
        $data = $this->request->getPost();
        $data['is_actif'] = 1;
        $model->insert($data);
        
        return redirect()->back()->with('message', 'Régime créé');
    }

    public function update($id)
    {
        $model = new Regime();
        $data = $this->request->getPost();
        $model->update($id, $data);
        
        return redirect()->back()->with('message', 'Régime mis à jour');
    }

    public function destroy($id)
    {
        $model = new Regime();
        $model->update($id, ['is_actif' => 0]);
        
        return redirect()->to('/admin/regimes')->with('message', 'Régime désactivé');
    }
    // filtre et affichage des regimes par objectif
    public function parObjectif($objectifId)
    {
        $objectifRegimeModel = new ObjectifRegime();
        $relations = $objectifRegimeModel->where('objectif_id', $objectifId)->findAll();
        
        $regimesIds = array_column($relations, 'regime_id');
        
        $model = new Regime();
        $data['regimes'] = !empty($regimesIds) ? $model->whereIn('id', $regimesIds)->where('is_actif', 1)->findAll() : [];
        
        return view('regimes-par-objectif', $data);
    }
}
