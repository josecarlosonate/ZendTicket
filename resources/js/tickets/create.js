const departmentSelect = document.getElementById('department_id');
const categorySelect = document.getElementById('category_id');
const oldCategoryId = categorySelect.dataset.oldCategory;

async function loadCategories(departmentId, selectedCategoryId = null) {

    try {
        const response = await fetch(`/departments/${departmentId}/categories`);

        if (!response.ok) {
            throw new Error('No se pudieron cargar las categorías.');
        }

        const categories = await response.json();
        categorySelect.innerHTML = '<option value="">Selecciona una categoría</option>';

        if (categories.length === 0) {
            categorySelect.innerHTML =
                '<option value="">No hay categorías disponibles</option>';

            return;
        }

        categories.forEach((category) => {
            const option = document.createElement('option');

            option.value = category.id;
            option.textContent = category.name;

            if (String(category.id) === String(selectedCategoryId)) {
                option.selected = true;
            }

            categorySelect.appendChild(option);
        });

        categorySelect.disabled = false;

    } catch (error) {
        categorySelect.innerHTML = '<option value="">No se pudieron cargar las categorías</option>';

        categorySelect.disabled = true;

        console.error(error);
    }
}

departmentSelect.addEventListener('change', () => {
    categorySelect.disabled = true;
    loadCategories(departmentSelect.value);
});

if (departmentSelect.value) {
    loadCategories(departmentSelect.value, oldCategoryId);
}