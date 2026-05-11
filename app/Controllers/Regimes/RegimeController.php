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
        $data['regimes'] = $model->orderBy('id', 'DESC')->findAll();
        
        return view('admin-regime', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'post') {
            $model = new Regime();
            $data = $this->request->getPost();
            
            // Total % validation
            $totalPct = floatval($data['pct_viande']) + floatval($data['pct_poisson']) + floatval($data['pct_volaille']);
            if ($totalPct != 100) {
                return redirect()->back()->with('error', 'Le total des pourcentages (viande, poisson, volaille) doit être égal à 100.')->withInput();
            }

            $data['is_actif'] = isset($data['is_actif']) ? 1 : 0;
            $model->insert($data);
            
            return redirect()->to('/admin/regime')->with('message', 'Régime ajouté avec succès.');
        }

        return view('admin-regime-form');
    }

    public function edit($id)
    {
        $model = new Regime();
        
        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();
            
            // Total % validation
            $totalPct = floatval($data['pct_viande']) + floatval($data['pct_poisson']) + floatval($data['pct_volaille']);
            if ($totalPct != 100) {
                return redirect()->back()->with('error', 'Le total des pourcentages (viande, poisson, volaille) doit être égal à 100.')->withInput();
            }

            $data['is_actif'] = isset($data['is_actif']) ? 1 : 0;
            $model->update($id, $data);
            
            return redirect()->to('/admin/regime')->with('message', 'Régime mis à jour avec succès.');
        }

        $data['regime'] = $model->find($id);
        if (!$data['regime']) {
            return redirect()->to('/admin/regime')->with('error', 'Régime introuvable.');
        }

        return view('admin-regime-form', $data);
    }

    public function destroy($id)
    {
        $model = new Regime();
        // Instead of hard delete, we just deactivate
        $model->update($id, ['is_actif' => 0]);
        
        return redirect()->to('/admin/regime')->with('message', 'Régime désactivé avec succès.');
    }
    
    // filtre et affichage des regimes par objectif (pour le front)
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
