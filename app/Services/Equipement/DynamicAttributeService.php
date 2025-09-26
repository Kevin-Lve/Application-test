<?php

namespace App\Services\Equipement;

use App\Models\Equipement\Equipement;
use App\Models\Equipement\SousCategorieAttribut;

class DynamicAttributeService
{
    public function sync(Equipement $equipement, array $payload): array
    {
        $definitions = SousCategorieAttribut::where('id_sous_categorie', $equipement->id_sous_categorie)
            ->get();

        $changes = [];

        $definitions->each(function (SousCategorieAttribut $definition) use ($equipement, $payload, &$changes) {
            $value = $payload[$definition->id] ?? null;
            $existing = $equipement->attributsValeurs
                ->firstWhere('id_attribut', $definition->id);
            $normalizedValue = $this->normalizeValue($definition, $value);

            if ($existing) {
                if ($normalizedValue === null || $normalizedValue === '') {
                    $changes[$definition->nom_attribut] = [
                        'before' => $existing->valeur,
                        'after' => null,
                    ];
                    $existing->delete();
                } elseif ($existing->valeur !== $normalizedValue) {
                    $changes[$definition->nom_attribut] = [
                        'before' => $existing->valeur,
                        'after' => $normalizedValue,
                    ];
                    $existing->update(['valeur' => $normalizedValue]);
                }
            } elseif ($normalizedValue !== null && $normalizedValue !== '') {
                $changes[$definition->nom_attribut] = [
                    'before' => null,
                    'after' => $normalizedValue,
                ];
                $equipement->attributsValeurs()->create([
                    'id_attribut' => $definition->id,
                    'valeur' => $normalizedValue,
                ]);
            }
        });

        return $changes;
    }

    private function normalizeValue(SousCategorieAttribut $definition, $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_array($value)) {
            return json_encode($value);
        }

        return (string) $value;
    }
}
