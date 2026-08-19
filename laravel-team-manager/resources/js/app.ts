async function copyText(value: string): Promise<boolean> {
    try {
        await navigator.clipboard.writeText(value);

        return true;
    } catch {
        // fallback for older browsers
        const textArea = document.createElement('textarea');

        textArea.value = value;
        textArea.style.position = 'fixed';
        textArea.style.opacity = '0';

        document.body.append(textArea);
        textArea.select();

        const copied = document.execCommand('copy');

        textArea.remove();

        return copied;
    }
}

document.querySelectorAll<HTMLButtonElement>('[data-copy-value]').forEach((button) => {
    button.addEventListener('click', async () => {
        const copied = await copyText(button.dataset.copyValue ?? '');

        button.textContent = copied ? 'Copied!' : 'Unable to copy';

        window.setTimeout(() => {
            button.textContent = 'Copy';
        }, 2000);
    });
});
