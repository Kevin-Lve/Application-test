<?php

namespace App\Http\Controllers;

use App\Http\Requests\Consommable\AdjustConsommableQuantityRequest;
use App\Http\Requests\Consommable\StoreConsommableRequest;
use App\Http\Requests\Consommable\UpdateConsommableRequest;
use App\Models\Consommable;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ConsommableController extends Controller
{
    public function index(): View
    {
        $consommables = Consommable::query()
            ->orderBy('nom')
            ->paginate(20)
            ->withQueryString();

        return view('it.consommable.index', [
            'consommables' => $consommables,
        ]);
    }

    public function create(): View
    {
        return view('it.consommable.create');
    }

    public function store(StoreConsommableRequest $request): RedirectResponse
    {
        $consommable = Consommable::create($request->validated());

        // Kevin: je renvoie direct sur la page d'édition pour continuer à enrichir la fiche dans la foulée.
        return redirect()
            ->route('consommables.edit', $consommable)
            ->with('success', 'Consommable ajouté avec succès.');
    }

    public function edit(Consommable $consommable): View
    {
        return view('it.consommable.edit', [
            'consommable' => $consommable,
        ]);
    }

    public function update(UpdateConsommableRequest $request, Consommable $consommable): RedirectResponse
    {
        $consommable->update($request->validated());

        // Kevin: je garde la boucle courte pour que l'opérateur puisse enchaîner plusieurs ajustements sans perdre le contexte.
        return redirect()
            ->route('consommables.edit', $consommable)
            ->with('success', 'Consommable mis à jour.');
    }

    public function adjust(AdjustConsommableQuantityRequest $request, Consommable $consommable): RedirectResponse
    {
        $delta = $request->delta();

        $nouveauStock = max(0, $consommable->quantite_stock + $delta);
        $consommable->update(['quantite_stock' => $nouveauStock]);

        $message = $delta >= 0
            ? 'Quantité augmentée de ' . $delta . '.'
            : 'Quantité diminuée de ' . abs($delta) . '.';

        // Kevin: je repasse par l'écran d'ajustement pour visualiser immédiatement le stock à jour.
        return redirect()
            ->route('consommables.edit', $consommable)
            ->with('success', $message);
    }
}
