<?php

namespace App\Http\Requests\Equipement;

use App\Models\Equipement\Equipement;
use App\Models\Equipement\SousCategorieAttribut;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEquipementRequest extends FormRequest
{
    private ?Equipement $equipement = null;

    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'id_categorie' => ['nullable', 'exists:categorie,id'],
            'id_sous_categorie' => ['required', 'exists:sous_categorie,id'],
            'id_emplacement' => ['nullable', 'exists:emplacement,id'],
            'id_vlan' => ['nullable', 'exists:vlan,id'],
            'id_action' => ['required', 'exists:action_materiel,id'],
            'id_service' => ['nullable', 'exists:service,id'],
            'id_utilisateur' => ['nullable', 'exists:users,id'],
            'id_equipement_parent' => ['nullable', 'exists:equipement,id'],
            'type_attribution' => ['required', Rule::in(['service', 'utilisateur', 'emplacement', 'stock'])],
            'hostname' => ['nullable', 'string', 'max:255'],
            'sn' => ['required', 'string', 'max:255'],
            'prix' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'date_achat' => ['nullable', 'date'],
            'date_obsolescence' => ['nullable', 'date', 'after_or_equal:date_achat'],
            'date_livraison' => ['nullable', 'date'],
            'equipement_reseau' => ['nullable', Rule::in(['oui', 'non'])],
            'adresse_ip' => ['nullable', 'string', 'max:255'],
            'adresse_mac' => ['nullable', 'string', 'max:255'],
            'numero_sku' => ['nullable', 'string', 'max:255'],
            'numero_tel' => ['nullable', 'string', 'max:255'],
            'immo' => ['nullable', 'string', 'max:255'],
            'imei' => ['nullable', 'string', 'max:255'],
            'numero_ligne' => ['nullable', 'string', 'max:255'],
            'code_pin' => ['nullable', 'string', 'max:255'],
            'code_puk' => ['nullable', 'string', 'max:255'],
            'forfait' => ['nullable', 'string', 'max:255'],
            'type_sim' => ['nullable', 'string', 'max:255'],
            'esim' => ['nullable', 'boolean'],
            'commentaire' => ['nullable', 'string'],
            'attributs' => ['nullable', 'array'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->equipement = Equipement::find($this->route('id'));
            if (!$this->equipement) {
                $validator->errors()->add('equipement', 'Equipement introuvable.');
                return;
            }

            $idAttribution = $this->resolveAttributionId();
            if (in_array($this->input('type_attribution'), ['service', 'utilisateur'], true) && !$idAttribution) {
                $validator->errors()->add('type_attribution', 'Merci de choisir une cible pour l\'attribution.');
            }

            if ($this->shouldRequireCommentaire($idAttribution)) {
                if (!$this->filled('commentaire')) {
                    $validator->errors()->add('commentaire', 'Merci d\'ajouter un commentaire pour tracer ce changement.');
                }
            }

            $this->validateDynamicAttributes($validator);
        });
    }

    public function resolveAttributionId(): ?int
    {
        return match ($this->input('type_attribution')) {
            'service' => $this->intOrNull('id_service'),
            'utilisateur' => $this->intOrNull('id_utilisateur'),
            default => null,
        };
    }

    public function toEquipmentData(): array
    {
        $isNetwork = $this->input('equipement_reseau') === 'oui';
        $idAttribution = $this->resolveAttributionId();

        return [
            'id_sous_categorie' => (int) $this->input('id_sous_categorie'),
            'id_emplacement' => $this->intOrNull('id_emplacement'),
            'id_vlan' => $isNetwork ? $this->intOrNull('id_vlan') : null,
            'id_action' => (int) $this->input('id_action'),
            'id_attribution' => $idAttribution,
            'id_equipement_parent' => $this->intOrNull('id_equipement_parent'),
            'type_attribution' => $this->input('type_attribution'),
            'hostname' => $this->input('hostname'),
            'numero_serie' => $this->input('sn'),
            'adresse_ip' => $isNetwork ? $this->input('adresse_ip') : null,
            'adresse_mac' => $isNetwork ? $this->input('adresse_mac') : null,
            'prix' => $this->input('prix'),
            'date_achat' => $this->input('date_achat'),
            'date_obsolescence' => $this->input('date_obsolescence'),
            'date_livraison' => $this->input('date_livraison'),
            'description' => $this->input('description'),
            'numero_sku' => $this->input('numero_sku'),
            'numero_tel' => $this->input('numero_tel'),
            'immo' => $this->input('immo'),
            'imei' => $this->input('imei'),
            'numero_ligne' => $this->input('numero_ligne'),
            'code_pin' => $this->input('code_pin'),
            'code_puk' => $this->input('code_puk'),
            'forfait' => $this->input('forfait'),
            'type_sim' => $this->input('type_sim'),
            'esim' => $this->boolean('esim'),
        ];
    }

    public function dynamicAttributes(): array
    {
        return $this->input('attributs', []);
    }

    public function commentaire(): ?string
    {
        return $this->input('commentaire');
    }

    private function shouldRequireCommentaire(?int $idAttribution): bool
    {
        if (!$this->equipement) {
            return false;
        }

        if ($this->equipement->id_action !== (int) $this->input('id_action')) {
            return true;
        }

        if ($this->equipement->type_attribution !== $this->input('type_attribution')) {
            return true;
        }

        if ($this->equipement->id_attribution != $idAttribution) {
            return true;
        }

        return false;
    }

    private function validateDynamicAttributes($validator): void
    {
        $sousCategorieId = $this->integer('id_sous_categorie');
        if (!$sousCategorieId) {
            return;
        }

        $definitions = SousCategorieAttribut::where('id_sous_categorie', $sousCategorieId)->get();
        $payload = $this->input('attributs', []);

        foreach ($definitions as $definition) {
            $value = $payload[$definition->id] ?? null;
            if ($definition->obligatoire && ($value === null || $value === '')) {
                $validator->errors()->add("attributs.{$definition->id}", "L'attribut {$definition->nom_attribut} est obligatoire.");
            }
        }
    }

    private function intOrNull(string $key): ?int
    {
        $value = $this->input($key);
        if ($value === null || $value === '' || $value === 'NULL') {
            return null;
        }

        return (int) $value;
    }
}
