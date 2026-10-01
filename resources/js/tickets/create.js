const departmentSelect = document.getElementById('department_id');
const categorySelect = document.getElementById('category_id');

departmentSelect.addEventListener('change', async () => {
    categorySelect.disabled = true;
    const departmentId = departmentSelect.value;

    const response = await fetch(`/departments/${departmentId}/categories`);
    const categories = await response.json();

    categorySelect.innerHTML = '<option value="">Selecciona una categoría</option>';
    categories.forEach((category) => {
        const option = document.createElement('option');

        option.value = category.id;
        option.textContent = category.name;

        categorySelect.appendChild(option);
    });

    categorySelect.disabled = false;
});