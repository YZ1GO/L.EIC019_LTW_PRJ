document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filter-form');
    const urlParams = new URLSearchParams(window.location.search);
    const selectedCategory = urlParams.get('category');

    function handleCheckboxSelection(selectedCategory) {
        if (selectedCategory === 'all') {
            const checkboxes = filterForm.querySelectorAll('input[name="category[]"]');
            checkboxes.forEach(function(checkbox) {
                const categoryId = parseInt(checkbox.value);
                if (categoryId !== 2 && categoryId !== 3 && categoryId !== 6) {
                    checkbox.checked = true;
                }
            });
        } else {
            const categoryCheckbox = document.querySelector(`input[name="category[]"][value="${selectedCategory}"]`);
            if (categoryCheckbox) {
                categoryCheckbox.checked = true;
            }
        }
    }

    function handleFormChange() {
        const formData = new FormData(filterForm);
    
        const formDataObject = {};
        formData.forEach(function(value, key){
            formDataObject[key] = value;
        });
        
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../pages/filter.php');
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('products').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed. Status:', xhr.status);
            }
        };
        xhr.send(formData);
    }

    let clearCheckboxTimer;
    function clearCheckboxes() {
        clearTimeout(clearCheckboxTimer);
        clearCheckboxTimer = setTimeout(function() {
            const checkboxes = filterForm.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
        }, 750);
    }

    if (selectedCategory) {
        handleCheckboxSelection(selectedCategory);
        handleFormChange();
    }
    
    filterForm.addEventListener('change', handleFormChange);

    const searchInput = document.getElementById('search-query');
    searchInput.addEventListener('input', function() {
        clearCheckboxes();
    });
});
