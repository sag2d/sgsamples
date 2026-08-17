/*
 * Shared admin list actions for index pages.
 * Handles delete confirmation prompts and add-button navigation.
 */

const confirmDelete = (id: string | undefined, deleteUrl: string | undefined): void => {
    const confirmed = window.confirm('Are you sure you wish to permanently delete this record?');

    if (confirmed && deleteUrl && id) {
        window.location.href = `${deleteUrl}${id}`;
    }
};

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.delete').forEach((el) => {
        const link = el as HTMLElement;
        link.addEventListener('click', (event: Event) => {
            event.preventDefault();
            confirmDelete(link.dataset.id, link.dataset.deleteUrl);
        });
    });

    document.querySelectorAll("[name='add']").forEach((el) => {
        const button = el as HTMLElement;
        button.addEventListener('click', () => {
            if (button.dataset.url) {
                window.location.href = button.dataset.url;
            }
        });
    });
});
