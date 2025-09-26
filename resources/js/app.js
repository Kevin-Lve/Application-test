import './bootstrap';
import initScanInput from './modules/scan-input';
import initConsommableAdjust from './modules/consommable-adjust';
import initFormDynamic from './modules/form-dynamic';
import initAssignEquipment from './modules/assign-equipment';
import initSearchAutocomplete from './modules/search-autocomplete';
import initCharts from './modules/charts';

const registry = {
    'scan-input': initScanInput,
    'consommable-adjust': initConsommableAdjust,
    'form-dynamic': initFormDynamic,
    'assign-equipment': initAssignEquipment,
    'search-autocomplete': initSearchAutocomplete,
    'charts': initCharts,
};

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-module]').forEach((element) => {
        const modules = element.dataset.module.split(' ');
        modules.forEach((name) => {
            const initializer = registry[name];
            if (typeof initializer === 'function') {
                // Kevin: initialisation ciblée seulement quand l'élément est présent, pour garder un JS light et maintenable.
                initializer(element);
            }
        });
    });
});
