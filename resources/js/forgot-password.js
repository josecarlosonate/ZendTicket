const form = document.getElementById('forgot-password-form');
const button = document.getElementById('submit-button');

form?.addEventListener('submit', () => {
    button.disabled = true;
    button.textContent = 'Enviando...';
    button.classList.remove(
        'bg-[#22c55e]',
        'hover:bg-[#16a34a]'
    );

    button.classList.add(
        'bg-gray-400',
        'cursor-not-allowed'
    );
});