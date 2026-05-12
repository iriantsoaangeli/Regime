<?php

namespace App\Controllers\Regimes;

use App\Controllers\BaseController;
use App\Models\Regimes\Regime;
use App\Models\Regimes\ObjectifRegime;
use App\Models\Regimes\TarifRegime;
use App\Models\Regimes\RegimeNourriture;
use App\Models\Regimes\Nourriture;
use App\Models\Utilisateurs\ProfilSante;
use App\Models\References\Objectif;

class RegimeController extends BaseController
{
    public function index()
    {
        $model = new Regime();
        $data['regimes'] = $model->orderBy('id', 'DESC')->findAll();

        return view('admin-regime', $data);
    }

    public function regime(): string
    {
        $regimeModel = new Regime();
        $profilModel = new ProfilSante();
        $objectifModel = new Objectif();
        $objectifRegimeModel = new ObjectifRegime();
        $tarifModel = new TarifRegime();
        $regimeNourritureModel = new RegimeNourriture();
        $nourritureModel = new Nourriture();

        $userId = session()->get('user_id');
        $profil = $userId ? $profilModel->where('utilisateur_id', $userId)->first() : null;
        $imc = $profil['imc'] ?? null;

        $objectifId = $profil['objectif_id'] ?? null;
        if (!$objectifId && $imc !== null) {
            $objectifId = ($imc >= 25) ? 1 : 2;
        }

        $objectif = $objectifId ? $objectifModel->find($objectifId) : null;
        $objectifType = null;
        if ($objectif) {
            $label = strtolower($objectif['libelle'] ?? '');
            if (str_contains($label, 'duire')) {
                $objectifType = 'perte';
            } elseif (str_contains($label, 'ugmenter')) {
                $objectifType = 'gain';
            }
        }

        if (!$objectifType && $imc !== null) {
            $objectifType = ($imc >= 25) ? 'perte' : 'gain';
        }

        $calorieTarget = $objectifType === 'gain' ? 3000 : 1600;

        if ($objectifId) {
            $relations = $objectifRegimeModel->where('objectif_id', $objectifId)->findAll();
            $regimesIds = array_column($relations, 'regime_id');
            $regimes = !empty($regimesIds)
                ? $regimeModel->whereIn('id', $regimesIds)->where('is_actif', 1)->orderBy('id', 'DESC')->findAll()
                : [];
        } else {
            $regimes = $regimeModel->where('is_actif', 1)->orderBy('id', 'DESC')->findAll();
        }

        $regimesData = [];
        foreach ($regimes as $regime) {
            $tarifs = $tarifModel->where('regime_id', $regime['id'])
                                 ->where('is_actif', 1)
                                 ->orderBy('duree_jours', 'ASC')
                                 ->findAll();

            $aliments = $regimeNourritureModel
                ->select('regime_nourritures.pct_nourriture, nourritures.nom, nourritures.description')
                ->join($nourritureModel->getTable(), 'nourritures.id = regime_nourritures.nourriture_id', 'inner')
                ->where('regime_nourritures.regime_id', $regime['id'])
                ->findAll();

            $regimesData[] = [
                'regime' => $regime,
                'tarifs' => $tarifs,
                'aliments' => $aliments
            ];
        }

        return view('regime', [
            'regimesData' => $regimesData,
            'objectif' => $objectif,
            'imc' => $imc,
            'calorieTarget' => $calorieTarget,
            'objectifType' => $objectifType
        ]);
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
