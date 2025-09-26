const parseJson = (payload, fallback) => {
    try {
        return payload ? JSON.parse(payload) : fallback;
    } catch (error) {
        console.error('Kevin: impossible de parser le JSON des attributs dynamiques', error);
        return fallback;
    }
};

const buildInput = (definition, value) => {
    const wrapper = document.createElement('div');
    wrapper.className = 'fv-row mb-5';

    const label = document.createElement('label');
    label.className = `${definition.required ? 'required ' : ''}fs-6 fw-semibold mb-2`;
    label.textContent = definition.label;
    wrapper.appendChild(label);

    let field;
    switch (definition.type) {
        case 'number':
            field = document.createElement('input');
            field.type = 'number';
            field.step = 'any';
            break;
        case 'date':
            field = document.createElement('input');
            field.type = 'date';
            break;
        case 'bool':
            field = document.createElement('input');
            field.type = 'checkbox';
            if (value === true || value === '1' || value === 1 || value === 'true') {
                field.checked = true;
            }
            break;
        case 'select':
            field = document.createElement('select');
            const options = Array.isArray(definition.options) ? definition.options : Object.values(definition.options || {});
            const emptyOption = document.createElement('option');
            emptyOption.value = '';
            emptyOption.textContent = 'Sélectionne une option';
            field.appendChild(emptyOption);
            options.forEach((option) => {
                const opt = document.createElement('option');
                if (typeof option === 'object') {
                    opt.value = option.value ?? option.id ?? '';
                    opt.textContent = option.label ?? option.nom ?? option.value ?? '—';
                } else {
                    opt.value = option;
                    opt.textContent = option;
                }
                if (String(value ?? '') === String(opt.value)) {
                    opt.selected = true;
                }
                field.appendChild(opt);
            });
            break;
        default:
            field = document.createElement('input');
            field.type = 'text';
    }

    field.name = `attributs[${definition.id}]`;
    field.classList.add('form-control', 'border', 'border-gray-300');
    if (definition.type !== 'bool') {
        field.value = value ?? '';
    }
    if (definition.required) {
        field.setAttribute('required', 'required');
    }
    wrapper.appendChild(field);

    return { wrapper, field };
};

export default function initFormDynamic(root) {
    const form = root.querySelector('form[data-dynamic-form]');
    if (!form) {
        return;
    }

    const categorySelect = form.querySelector('[data-category-select]');
    const subCategorySelect = form.querySelector('[data-subcategory-select]');
    const attributeContainer = form.querySelector('[data-attribute-container]');
    const networkFields = form.querySelector('[data-network-fields]');
    const networkToggles = form.querySelectorAll('[data-network-toggle]');

    const config = {
        categoryEndpoint: form.dataset.categoryEndpoint,
        attributeEndpoint: form.dataset.attributeEndpoint,
        initialCategory: form.dataset.initialCategory || '',
        initialSubcategory: form.dataset.initialSubcategory || '',
        oldAttributes: parseJson(form.dataset.oldAttributes, {}),
        existingAttributes: parseJson(form.dataset.existingAttributes, {}),
        attributeErrors: parseJson(form.dataset.attributeErrors, {}),
    };

    const fetchJson = async (url) => {
        try {
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
            });
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error('Kevin: impossible de charger les données dynamiques', error);
            return { data: [] };
        }
    };

    const renderPlaceholder = (message) => {
        attributeContainer.innerHTML = '';
        const alert = document.createElement('div');
        alert.className = 'alert alert-secondary mb-0';
        alert.textContent = message;
        attributeContainer.appendChild(alert);
    };

    const renderAttributes = (definitions) => {
        attributeContainer.innerHTML = '';
        if (!definitions.length) {
            renderPlaceholder('Aucun attribut spécifique pour cette sous-catégorie.');
            return;
        }

        const values = { ...config.existingAttributes, ...config.oldAttributes };
        definitions.forEach((definition) => {
            const { wrapper, field } = buildInput(definition, values[definition.id]);
            if (config.attributeErrors[definition.id]) {
                const feedback = document.createElement('div');
                feedback.className = 'text-danger small mt-2';
                feedback.textContent = config.attributeErrors[definition.id][0];
                wrapper.appendChild(feedback);
            }
            attributeContainer.appendChild(wrapper);
            field.dispatchEvent(new Event('change'));
        });
    };

    const loadAttributes = async (subCategoryId) => {
        if (!subCategoryId) {
            renderPlaceholder('Sélectionne une sous-catégorie pour charger les attributs dynamiques.');
            return;
        }
        const url = `${config.attributeEndpoint}/${subCategoryId}/attributs`;
        const { data } = await fetchJson(url);
        renderAttributes(data || []);
    };

    const hydrateSubCategories = async (categoryId, requestedSubCategory) => {
        if (!subCategorySelect) {
            return;
        }
        subCategorySelect.innerHTML = '';
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'Sélectionne une sous-catégorie';
        subCategorySelect.appendChild(defaultOption);

        if (!categoryId) {
            renderPlaceholder('Sélectionne une catégorie pour commencer.');
            return;
        }

        if (requestedSubCategory === null) {
            // Kevin: on nettoie les anciennes valeurs pour éviter de coller des champs d'une autre sous-catégorie.
            config.oldAttributes = {};
            config.existingAttributes = {};
        }

        const url = `${config.categoryEndpoint}/${categoryId}/sous-categories`;
        const { data } = await fetchJson(url);
        let subCategoryToLoad = requestedSubCategory;
        data.forEach((item) => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.label;
            if (String(requestedSubCategory || '') === String(item.id)) {
                option.selected = true;
            }
            subCategorySelect.appendChild(option);
        });

        if (!subCategoryToLoad && data.length > 0) {
            subCategoryToLoad = data[0].id;
            subCategorySelect.value = data[0].id;
        }

        await loadAttributes(subCategoryToLoad);
    };

    const handleNetworkToggle = (value) => {
        if (!networkFields) {
            return;
        }
        if (value === 'oui') {
            networkFields.removeAttribute('hidden');
        } else {
            networkFields.setAttribute('hidden', 'hidden');
        }
    };

    networkToggles.forEach((toggle) => {
        toggle.addEventListener('change', (event) => {
            handleNetworkToggle(event.target.value);
        });
    });

    if (categorySelect) {
        categorySelect.addEventListener('change', (event) => {
            const categoryId = event.target.value;
            hydrateSubCategories(categoryId, null);
        });
    }

    if (subCategorySelect) {
        subCategorySelect.addEventListener('change', (event) => {
            loadAttributes(event.target.value);
        });
    }

    if (config.initialCategory) {
        hydrateSubCategories(config.initialCategory, config.initialSubcategory);
    } else if (categorySelect) {
        hydrateSubCategories(categorySelect.value, subCategorySelect ? subCategorySelect.value : null);
    }

    if (networkToggles.length) {
        const checked = form.querySelector('[data-network-toggle]:checked');
        handleNetworkToggle(checked ? checked.value : 'non');
    }
}
