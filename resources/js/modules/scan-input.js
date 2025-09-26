export default function initScanInput(form) {
    const input = form.querySelector('input[name="code"]');
    if (!input) {
        return;
    }

    // Kevin: je force le focus pour que la douchette USB tape directement dedans sans clic manuel.
    setTimeout(() => input.focus(), 50);

    form.addEventListener('submit', () => {
        input.setAttribute('readonly', 'readonly');
        setTimeout(() => {
            input.removeAttribute('readonly');
            input.value = '';
            input.focus();
        }, 400);
    });
}
