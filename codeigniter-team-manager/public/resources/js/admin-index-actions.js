/*
 * Shared admin list actions for index pages.
 * Handles delete confirmation prompts and add-button navigation.
 */

const confirmDelete = (id, deleteUrl) => {
    const confirmed = window.confirm('Are you sure you wish to permanently delete this record?');

    if (confirmed) {
        window.location.href = `${deleteUrl}${id}`;
    }
};

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.delete').forEach((link) => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            confirmDelete(link.dataset.id, link.dataset.deleteUrl);
        });
    });

    document.querySelectorAll("[name='add']").forEach((button) => {
        button.addEventListener('click', () => {
            window.location.href = button.dataset.url;
        });
    });
});
