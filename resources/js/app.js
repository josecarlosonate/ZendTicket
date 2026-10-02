document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('layoutUserMenuBtn');
    const dropdown = document.getElementById('layoutUserDropdown');

    if (btn && dropdown) {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (
                !dropdown.classList.contains('hidden') &&
                !dropdown.contains(e.target)
            ) {
                dropdown.classList.add('hidden');
            }
        });
    }
});