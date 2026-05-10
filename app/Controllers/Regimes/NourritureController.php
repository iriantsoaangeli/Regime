<?php

namespace App\Controllers\Regimes;

use App\Controllers\BaseController;
use App\Models\Regimes\Nourriture;
use App\Models\Regimes\RegimeNourriture;

class NourritureController extends BaseController
{
    public function index()
    {
        $model = new Nourriture();
        $data['nourritures'] = $model->findAll();
        
        return view('admin-nourritures', $data);
    }

    public function store()
    {
        $model = new Nourriture();
        $data = $this->request->getPost();
        $data['is_actif'] = 1;
        $model->insert($data);
        
        return redirect()->back()->with('message', 'Nourriture créée');
    }

    public function update($id)
    {
        $model = new Nourriture();
        $data = $this->request->getPost();
        $model->update($id, $data);
        
        return redirect()->back()->with('message', 'Nourriture mise à jour');
    }
    // add
    public function attachRegime($nourritureId, $regimeId, $pct)
    {
        $model = new RegimeNourriture();
        $model->insert([
            'regime_id'      => $regimeId,
            'nourriture_id'  => $nourritureId,
            'pct_nourriture' => $pct
        ]);
        
        return redirect()->back()->with('message', 'Nourriture liée au régime avec succès');
    }
    // delete
    public function detachRegime($nourritureId, $regimeId)
    {
        $model = new RegimeNourriture();
        $model->where('regime_id', $regimeId)
              ->where('nourriture_id', $nourritureId)
              ->delete();
              
        return redirect()->back()->with('message', 'Nourriture retirée du régime');
    }
}
