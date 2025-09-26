const DEBOUNCE_DELAY = 250;

const parseItems = (payload) => Array.isArray(payload) ? payload : [];

const renderResults = (container, items) => {
    container.innerHTML = '';
    if (!items.length) {
        const empty = document.createElement('div');
        empty.className = 'list-group-item text-muted';
        empty.textContent = 'Aucun résultat';
        container.appendChild(empty);
        container.hidden = false;
        return;
    }

    items.forEach((item, index) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'list-group-item list-group-item-action';
        button.dataset.value = item.id;
        button.dataset.label = item.label;
        button.textContent = item.label;
        if (item.description) {
            const small = document.createElement('div');
            small.className = 'small text-muted';
            small.textContent = item.description;
            button.appendChild(small);
        }
        button.dataset.index = index;
        container.appendChild(button);
    });
    container.hidden = false;
};

const closeResults = (container) => {
    container.hidden = true;
};

export default function initSearchAutocomplete(root) {
    const inputs = root.querySelectorAll('[data-autocomplete-input]');
    if (!inputs.length) {
        return;
    }

    inputs.forEach((input) => {
        const container = input.closest('[data-autocomplete]');
        const hiddenField = container?.querySelector('[data-autocomplete-hidden]');
        const results = container?.querySelector('[data-autocomplete-results]');
        const endpoint = input.dataset.autocompleteEndpoint;

        if (!container || !hiddenField || !results || !endpoint) {
            return;
        }

        let debounceTimer = null;
        let controller = null;
        let activeIndex = -1;

        const fetchResults = async (query) => {
            if (controller) {
                controller.abort();
            }
            controller = new AbortController();
            try {
                const response = await fetch(`${endpoint}?query=${encodeURIComponent(query)}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                    signal: controller.signal,
                });
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }
                const payload = await response.json();
                renderResults(results, parseItems(payload.data));
                activeIndex = -1;
            } catch (error) {
                if (error.name !== 'AbortError') {
                    console.error('Kevin: erreur lors de la récupération autocomplete', error);
                }
            }
        };

        const selectItem = (button) => {
            if (!button) {
                return;
            }
            const value = button.dataset.value || '';
            const label = button.dataset.label || '';
            hiddenField.value = value;
            input.value = label;
            hiddenField.dispatchEvent(new CustomEvent('autocomplete:selection', { bubbles: true }));
            closeResults(results);
        };

        input.addEventListener('input', () => {
            hiddenField.value = '';
            if (debounceTimer) {
                clearTimeout(debounceTimer);
            }
            const query = input.value.trim();
            if (!query) {
                closeResults(results);
                return;
            }
            debounceTimer = setTimeout(() => fetchResults(query), DEBOUNCE_DELAY);
        });

        input.addEventListener('keydown', (event) => {
            const items = results.querySelectorAll('button[data-index]');
            if (!items.length) {
                return;
            }
            if (event.key === 'ArrowDown') {
                event.preventDefault();
                activeIndex = (activeIndex + 1) % items.length;
                items[activeIndex].focus();
            } else if (event.key === 'ArrowUp') {
                event.preventDefault();
                activeIndex = activeIndex <= 0 ? items.length - 1 : activeIndex - 1;
                items[activeIndex].focus();
            } else if (event.key === 'Enter') {
                if (activeIndex >= 0) {
                    event.preventDefault();
                    selectItem(items[activeIndex]);
                }
            } else if (event.key === 'Escape') {
                closeResults(results);
            }
        });

        results.addEventListener('click', (event) => {
            const button = event.target.closest('button[data-index]');
            if (button) {
                selectItem(button);
            }
        });

        document.addEventListener('click', (event) => {
            if (!container.contains(event.target)) {
                closeResults(results);
            }
        });
    });
}
