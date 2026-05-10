<?php

namespace App\Controllers\Activites;

use App\Controllers\BaseController;
use App\Models\Activites\Activite;
use App\Models\Activites\ObjectifActivite;

class ActiviteController extends BaseController
{
    public function index()
    {
        $model = new Activite();
        $data['activites'] = $model->findAll();
        
        return view('admin-activites', $data);
    }

    public function show($id)
    {
        $model = new Activite();
        $data['activite'] = $model->find($id);
        
        return view('activite-detail', $data);
    }

    public function store()
    {
        $model = new Activite();
        $data = $this->request->getPost();
        $data['is_actif'] = 1;
        $model->insert($data);
        
        return redirect()->back()->with('message', 'Activité sportive créée');
    }

    public function update($id)
    {
        $model = new Activite();
        $data = $this->request->getPost();
        $model->update($id, $data);
        
        return redirect()->back()->with('message', 'Activité sportive mise à jour');
    }

    public function destroy($id)
    {
        $model = new Activite();
        $model->update($id, ['is_actif' => 0]);
        
        return redirect()->back()->with('message', 'Activité sportive désactivée');
    }
    // filtre et affichage des activites par objectif
    public function parObjectif($objectifId)
    {
        $objectifActiviteModel = new ObjectifActivite();
        $relations = $objectifActiviteModel->where('objectif_id', $objectifId)->findAll();
        
        $activitesIds = array_column($relations, 'activite_id');
        
        $model = new Activite();
        $data['activites'] = !empty($activitesIds) ? $model->whereIn('id', $activitesIds)->where('is_actif', 1)->findAll() : [];
        
        return view('activites-par-objectif', $data);
    }
}
