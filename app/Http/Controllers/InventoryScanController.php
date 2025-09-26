<?php

namespace App\Http\Controllers;

use App\Http\Requests\Equipement\ScanEquipementRequest;
use App\Models\Consommable;
use App\Models\Equipement\Equipement;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InventoryScanController extends Controller
{
    public function show(): View
    {
        return view('it.equipement.scan');
    }

    public function search(ScanEquipementRequest $request): View|RedirectResponse
    {
        $code = $request->code();
        $normalized = $request->normalizedCode();

        $equipements = Equipement::query()
            ->with(['sous_categorie', 'emplacement'])
            ->where(function ($query) use ($code, $normalized) {
                $query->where('hostname', 'like', "%{$code}%")
                    ->orWhere('numero_serie', 'like', "%{$code}%")
                    ->orWhere('immo', 'like', "%{$code}%")
                    ->orWhere('numero_tel', 'like', "%{$code}%")
                    ->orWhere('numero_sku', 'like', "%{$code}%")
                    ->orWhere('adresse_ip', 'like', "%{$code}%")
                    ->orWhere(function ($sub) use ($normalized) {
                        if ($normalized === '') {
                            return;
                        }

                        $sanitizer = static fn (string $column) => "REPLACE(REPLACE(REPLACE(UPPER({$column}), ':', ''), '-', ''), ' ', '')";

                        $sub->orWhereRaw($sanitizer('adresse_mac') . ' = ?', [$normalized])
                            ->orWhereRaw($sanitizer('adresse_mac_bt') . ' = ?', [$normalized])
                            ->orWhereRaw($sanitizer('adresse_mac_2') . ' = ?', [$normalized])
                            ->orWhereRaw($sanitizer('adresse_mac_3') . ' = ?', [$normalized]);
                    });
            })
            ->orderBy('hostname')
            ->limit(20)
            ->get();

        $consommables = Consommable::query()
            ->where(function ($query) use ($code, $normalized) {
                $query->where('nom', 'like', "%{$code}%")
                    ->orWhere('reference', 'like', "%{$code}%")
                    ->orWhere('numero_serie', 'like', "%{$code}%")
                    ->orWhere('immo', 'like', "%{$code}%")
                    ->orWhere('code_barre', 'like', "%{$code}%")
                    ->orWhere(function ($sub) use ($normalized) {
                        if ($normalized === '') {
                            return;
                        }

                        $sanitizer = static fn (string $column) => "REPLACE(REPLACE(REPLACE(UPPER({$column}), ':', ''), '-', ''), ' ', '')";
                        $sub->orWhereRaw($sanitizer('adresse_mac') . ' = ?', [$normalized]);
                    });
            })
            ->orderBy('nom')
            ->limit(20)
            ->get();

        if ($equipements->count() === 0 && $consommables->count() === 0) {
            // Kevin: un retour arrière franc quand on ne trouve rien, histoire de rescanner sans perdre de temps.
            return redirect()
                ->route('equipement.scan')
                ->with('error', "Aucun équipement ou consommable ne correspond au code '{$code}'.");
        }

        if ($equipements->count() === 1 && $consommables->isEmpty()) {
            $equipement = $equipements->first();

            // Kevin: je renvoie directement sur la modification d'équipement pour permettre l'update express.
            return redirect()
                ->route('equipement.edit.show', $equipement->id)
                ->with('success', "Équipement trouvé : {$equipement->hostname}.");
        }

        if ($consommables->count() === 1 && $equipements->isEmpty()) {
            $consommable = $consommables->first();

            return redirect()
                ->route('consommables.edit', $consommable)
                ->with('success', "Consommable trouvé : {$consommable->nom}.");
        }

        return view('it.equipement.scan-result', [
            'code' => $code,
            'equipements' => $equipements,
            'consommables' => $consommables,
        ]);
    }
}
