export default function initConsommableAdjust(root) {
    const forms = root.querySelectorAll('form[action*="consommables"]');
    if (!forms.length) {
        return;
    }

    forms.forEach((form) => {
        form.addEventListener('submit', () => {
            const submit = form.querySelector('button[type="submit"]');
            if (submit) {
                submit.disabled = true;
                submit.classList.add('disabled');
            }
        });
    });
}
