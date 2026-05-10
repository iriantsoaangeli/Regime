<?php

namespace App\Controllers\Portefeuilles;

use App\Controllers\BaseController;
use App\Models\Portefeuilles\CodePortefeuille;
use App\Models\Portefeuilles\Portefeuille;
use App\Models\Portefeuilles\MouvementPortefeuille;

class CodePortefeuilleController extends BaseController
{
    public function index()
    {
        // Liste codes (back office)
        $model = new CodePortefeuille();
        $data['codes'] = $model->findAll();
        
        return view('admin-codes-portefeuille', $data);
    }

    public function store()
    {
        // Générer nouveau code (admin)
        $model = new CodePortefeuille();
        $data = $this->request->getPost();
        
        if (empty($data['code'])) {
            $data['code'] = strtoupper(bin2hex(random_bytes(8))); // Code à 16 caractères auto-généré
        }
        
        $model->insert($data);
        
        return redirect()->back()->with('message', 'Code généré avec succès');
    }

    public function utiliser()
    {
        // Valider + recharger portefeuille
        $codeSaisi = $this->request->getPost('code');
        $userId = session()->get('user_id'); // Remplacer par l'ID réel en session
        
        $modelCode = new CodePortefeuille();
        $codeData = $modelCode->where('code', $codeSaisi)->first();
        
        if ($codeData && $modelCode->estValide($codeSaisi)) {
            // Update du portefeuille
            $portefeuilleModel = new Portefeuille();
            
            // Get solde avant
            $portefeuille = $portefeuilleModel->where('utilisateur_id', $userId)->first();
            $soldeAvant = $portefeuille ? $portefeuille['solde'] : 0.00;
            
            // Créditer
            $portefeuilleModel->crediter($userId, $codeData['montant']);
            $soldeApres = $soldeAvant + $codeData['montant'];
            
            // Update du code
            $modelCode->update($codeData['id'], [
                'is_utilise' => 1,
                'utilise_par_id' => $userId,
                'utilise_le' => date('Y-m-d H:i:s')
            ]);
            
            // Enregistrer mouvement
            $mvtModel = new MouvementPortefeuille();
            $mvtModel->insert([
                'utilisateur_id' => $userId,
                'type_transaction_id' => 1, 
                'code_id' => $codeData['id'],
                'montant' => $codeData['montant'],
                'solde_avant' => $soldeAvant,
                'solde_apres' => $soldeApres,
                'libelle' => 'Recharge via code: ' . $codeSaisi
            ]);
            
            return redirect()->back()->with('message', 'Portefeuille rechargé avec succès');
        }
        
        return redirect()->back()->with('error', 'Code invalide ou expiré');
    }

    public function destroy($id)
    {
        // Invalider code (admin)
        $model = new CodePortefeuille();
        $model->update($id, ['is_utilise' => 1]); // on le marque comme utilisé pour l'invalider
        
        return redirect()->back()->with('message', 'Code invalidé');
    }
}
