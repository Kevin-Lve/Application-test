const getSelectedType = (radios) => {
    const checked = Array.from(radios).find((radio) => radio.checked);
    return checked ? checked.value : null;
};

const toggleSections = (sections, activeType) => {
    Object.entries(sections).forEach(([type, section]) => {
        if (!section) {
            return;
        }
        if (type === activeType) {
            section.removeAttribute('hidden');
        } else {
            section.setAttribute('hidden', 'hidden');
        }
    });
};

const evaluateComment = (form, radios, actionSelect, commentField, hiddenTargets) => {
    if (!commentField) {
        return;
    }

    const requiresComment = form.dataset.requiresComment === 'true';
    if (!requiresComment) {
        commentField.removeAttribute('required');
        return;
    }

    const initialType = form.dataset.initialType || '';
    const initialAction = form.dataset.initialAction || '';
    const initialTarget = form.dataset.initialTarget || '';

    const selectedType = getSelectedType(radios) || '';
    const selectedAction = actionSelect ? actionSelect.value : '';
    const selectedTargetField = hiddenTargets[selectedType];
    const selectedTarget = selectedTargetField ? selectedTargetField.value : '';

    let mustComment = false;
    if (selectedType !== initialType) {
        mustComment = true;
    }
    if (!mustComment && selectedAction && selectedAction !== initialAction) {
        mustComment = true;
    }
    if (!mustComment && selectedType === initialType && selectedTarget && selectedTarget !== initialTarget) {
        mustComment = true;
    }

    if (mustComment) {
        commentField.setAttribute('required', 'required');
        commentField.classList.add('border-warning');
    } else {
        commentField.removeAttribute('required');
        commentField.classList.remove('border-warning');
    }
};

export default function initAssignEquipment(root) {
    const form = root.querySelector('form[data-assign-form]');
    if (!form) {
        return;
    }

    const radios = form.querySelectorAll('input[name="type_attribution"]');
    const actionSelect = form.querySelector('[data-action-select]');
    const commentField = form.querySelector('[data-comment-field]');

    const sections = {
        service: form.querySelector('[data-attribution-section="service"]'),
        utilisateur: form.querySelector('[data-attribution-section="utilisateur"]'),
        emplacement: form.querySelector('[data-attribution-section="emplacement"]'),
        stock: form.querySelector('[data-attribution-section="stock"]'),
    };

    const hiddenTargets = {
        service: form.querySelector('input[data-autocomplete-hidden][name="id_service"]'),
        utilisateur: form.querySelector('input[data-autocomplete-hidden][name="id_utilisateur"]'),
        emplacement: form.querySelector('input[data-autocomplete-hidden][name="id_emplacement"]'),
        stock: null,
    };

    const refresh = () => {
        const type = getSelectedType(radios);
        toggleSections(sections, type);
        evaluateComment(form, radios, actionSelect, commentField, hiddenTargets);
    };

    radios.forEach((radio) => {
        radio.addEventListener('change', () => {
            // Kevin: on garde l'écran ultra fluide, le commentaire ne devient obligatoire que si on change vraiment quelque chose.
            refresh();
        });
    });

    if (actionSelect) {
        actionSelect.addEventListener('change', refresh);
    }

    Object.values(hiddenTargets).forEach((hidden) => {
        if (!hidden) {
            return;
        }
        hidden.addEventListener('autocomplete:selection', refresh);
        hidden.addEventListener('input', refresh);
    });

    refresh();
}
