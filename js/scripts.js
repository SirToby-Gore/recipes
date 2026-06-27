/**
 * Handles toggling Likes and Favourites asynchronously in the background.
 */
function handleRecipeAction(button, url, actionType) {
    var currentStatus = button.getAttribute('data-status');
    var isLikedOrFavourited = currentStatus === 'liked' || currentStatus === 'favourited';
    // 1. Determine next active/inactive state strings
    var nextStatus = '';
    if (actionType === 'like') {
        nextStatus = isLikedOrFavourited ? 'like' : 'liked';
    }
    else {
        nextStatus = isLikedOrFavourited ? 'favourite' : 'favourited';
    }
    // 2. Locate elements
    var img = button.querySelector('img');
    var countSpan = button.querySelector('.action-count');
    // Save the original text value for error rollback states
    var originalCountText = countSpan ? countSpan.textContent || '0' : '0';
    var currentCount = parseInt(originalCountText, 10);
    if (isNaN(currentCount))
        currentCount = 0;
    // 3. Optimistically calculate the new numerical count
    var newCount = currentCount;
    if (nextStatus === 'liked' || nextStatus === 'favourited') {
        newCount = currentCount + 1;
    }
    else {
        newCount = Math.max(0, currentCount - 1);
    }
    // 4. Instantly apply updates to the DOM for immediate user response
    button.className = "".concat(actionType, "-button ").concat(nextStatus);
    button.setAttribute('data-status', nextStatus);
    if (img) {
        img.alt = nextStatus;
    }
    if (countSpan) {
        countSpan.textContent = newCount.toString();
    }
    // 5. Send background synchronization request to the server
    fetch(url, {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
    })
        .then(function (response) {
        if (!response.ok)
            throw new Error('Server responded with an error status.');
    })
        .catch(function (error) {
        console.error('Error updating status:', error);
        // Failure Fallback: Safely reset the exact original counts and classes
        if (currentStatus) {
            button.className = "".concat(actionType, "-button ").concat(currentStatus);
            button.setAttribute('data-status', currentStatus);
            if (img) {
                img.alt = currentStatus;
            }
            if (countSpan) {
                countSpan.textContent = originalCountText;
            }
        }
    });
}
/**
 * Helper to update the DOM count display or revert to an Add button if empty.
 */
function updateBasketDOM(recipeId, newCount) {
    var managementGroup = document.querySelector(".basket-management-group[data-recipe-id=\"".concat(recipeId, "\"]"));
    if (!managementGroup)
        return;
    if (newCount > 0) {
        var countDisplay = managementGroup.querySelector('.recipe-count-display');
        if (countDisplay) {
            countDisplay.textContent = newCount.toString();
        }
    }
    else {
        var addButton = document.createElement('button');
        addButton.className = 'add-button';
        addButton.setAttribute('aria-label', 'Add to Basket');
        addButton.setAttribute('onclick', "handleBasketAdd('".concat(recipeId, "', this)"));
        addButton.textContent = 'Add To Basket';
        managementGroup.replaceWith(addButton);
    }
}
/**
 * Handles adding items to the basket asynchronously.
 */
function handleBasketAdd(recipeId, button) {
    if (button === void 0) { button = null; }
    if (button) {
        button.disabled = true;
        button.textContent = 'Adding...';
    }
    fetch("/basket/add/".concat(recipeId), {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
    })
        .then(function (response) {
        if (!response.ok)
            throw new Error('Failed to add item to basket');
        var managementGroup = document.createElement('div');
        managementGroup.className = 'basket-management-group';
        managementGroup.setAttribute('data-recipe-id', recipeId);
        managementGroup.innerHTML = "\n                <a href=\"javascript:void(0)\" onclick=\"handleBasketDecrement('".concat(recipeId, "')\" class=\"decrement-btn\" aria-label=\"Decrease quantity\">-</a>\n                <span class=\"recipe-count-display\">1</span>\n                <a href=\"javascript:void(0)\" onclick=\"handleBasketIncrement('").concat(recipeId, "')\" class=\"increment-btn\" aria-label=\"Increase quantity\">+</a>\n                <a href=\"javascript:void(0)\" onclick=\"handleBasketRemove('").concat(recipeId, "')\" class=\"remove-btn\" aria-label=\"Remove item\">Remove</a>\n            ");
        if (button) {
            button.replaceWith(managementGroup);
        }
    })
        .catch(function (error) {
        console.error('Error adding to basket:', error);
        if (button) {
            button.textContent = 'Failed';
            button.disabled = false;
        }
    });
}
/**
 * Increments an item's quantity in the basket.
 */
function handleBasketIncrement(recipeId) {
    var url = "/basket/increment/".concat(recipeId);
    fetch(url, {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
    })
        .then(function (response) {
        if (!response.ok)
            throw new Error('Failed to increment quantity');
        var countDisplay = document.querySelector(".basket-management-group[data-recipe-id=\"".concat(recipeId, "\"] .recipe-count-display"));
        if (countDisplay) {
            var currentCount = parseInt(countDisplay.textContent || '1', 10);
            updateBasketDOM(recipeId, currentCount + 1);
        }
    })
        .catch(function (error) {
        console.error('Error incrementing basket quantity:', error);
    });
}
/**
 * Decrements an item's quantity in the basket.
 */
function handleBasketDecrement(recipeId) {
    var url = "/basket/decrement/".concat(recipeId);
    fetch(url, {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
    })
        .then(function (response) {
        if (!response.ok)
            throw new Error('Failed to decrement quantity');
        var countDisplay = document.querySelector(".basket-management-group[data-recipe-id=\"".concat(recipeId, "\"] .recipe-count-display"));
        if (countDisplay) {
            var currentCount = parseInt(countDisplay.textContent || '1', 10);
            updateBasketDOM(recipeId, currentCount - 1);
        }
    })
        .catch(function (error) {
        console.error('Error decrementing basket quantity:', error);
    });
}
/**
 * Removes an item from the basket entirely.
 */
function handleBasketRemove(recipeId) {
    var url = "/basket/remove/".concat(recipeId);
    if (!confirm('Are you sure you want to remove this item?')) {
        return;
    }
    fetch(url, {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
    })
        .then(function (response) {
        if (!response.ok)
            throw new Error('Failed to remove item');
        updateBasketDOM(recipeId, 0);
    })
        .catch(function (error) {
        console.error('Error removing item from basket:', error);
    });
}
function handleToggleIngredientCheck(checkbox, ingredientId) {
    var listItem = checkbox.closest('.shopping-list-item');
    var originallyChecked = !checkbox.checked;
    var isChecked = checkbox.checked;
    if (listItem) {
        if (isChecked) {
            listItem.classList.add('checked');
        }
        else {
            listItem.classList.remove('checked');
        }
    }
    fetch("/basket/check/".concat(ingredientId), {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
    })
        .then(function (response) {
        if (!response.ok) {
            throw new Error('Failed to update check status');
        }
        return response.json();
    })
        .then(function (data) {
        checkbox.checked = data.is_checked;
        if (listItem) {
            if (data.is_checked) {
                listItem.classList.add('checked');
            }
            else {
                listItem.classList.remove('checked');
            }
        }
    })
        .catch(function (error) {
        console.error('Error toggling checkbox state:', error);
        checkbox.checked = originallyChecked;
        if (listItem) {
            if (originallyChecked) {
                listItem.classList.add('checked');
            }
            else {
                listItem.classList.remove('checked');
            }
        }
    });
}
function handleCommentLike(button, commentId) {
    var currentStatus = button.getAttribute('data-status');
    var isLiked = currentStatus === 'liked';
    var nextStatus = isLiked ? 'like' : 'liked';
    var countSpan = button.querySelector('.like-count');
    var originalCountText = countSpan ? countSpan.textContent || '0' : '0';
    var currentCount = parseInt(originalCountText, 10);
    if (isNaN(currentCount))
        currentCount = 0;
    var newCount = isLiked ? Math.max(0, currentCount - 1) : currentCount + 1;
    button.className = "comment-like-btn ".concat(nextStatus);
    button.setAttribute('data-status', nextStatus);
    if (countSpan) {
        countSpan.textContent = newCount.toString();
    }
    fetch("/comment/like/".concat(commentId), {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
    })
        .then(function (response) {
        if (!response.ok)
            throw new Error('Failed to update comment like status');
    })
        .catch(function (error) {
        console.error('Error liking comment:', error);
        button.className = "comment-like-btn ".concat(currentStatus);
        button.setAttribute('data-status', currentStatus || 'like');
        if (countSpan) {
            countSpan.textContent = originalCountText;
        }
    });
}
var dbIngredients;
var dbUnits;
window.addEventListener('DOMContentLoaded', function () {
    var ingredientsElement = document.getElementById('db-ingredients-data');
    var unitsElement = document.getElementById('db-units-data');
    var existingStepsElement = document.getElementById('existing-steps-data');
    if (ingredientsElement && unitsElement) {
        dbIngredients = JSON.parse(ingredientsElement.textContent || '{}');
        dbUnits = JSON.parse(unitsElement.textContent || '{}');
    }
    var existingSteps = existingStepsElement
        ? JSON.parse(existingStepsElement.textContent || '[]')
        : [];
    if (existingSteps.length > 0) {
        existingSteps.forEach(function (stepData) {
            addNewFormStep(step_data_to_form_obj(stepData));
        });
    }
    else {
        addNewStep();
    }
});
function addNewFormStep(prefillData) {
    var stepsWrapper = document.getElementById('steps-wrapper');
    if (!stepsWrapper)
        return;
    var stepIndex = stepsWrapper.children.length + 1;
    var stepCard = document.createElement('div');
    stepCard.className = 'step-card';
    stepCard.setAttribute('data-step-index', stepIndex.toString());
    stepCard.innerHTML = "\n\t\t<div class=\"step-card-header\">\n\t\t\t<h4>Step <span class=\"step-num-display\">".concat(stepIndex, "</span></h4>\n\t\t\t<button type=\"button\" onclick=\"removeFormStep(this)\" class=\"remove-step-btn\" aria-label=\"Remove step\">\u2715</button>\n\t\t</div>\n\t\t<div class=\"form-group\">\n\t\t\t<textarea class=\"step-description-input\" placeholder=\"Describe the cooking instructions for this step...\" required>").concat(prefillData ? prefillData.step : '', "</textarea>\n\t\t</div>\n\t\t<div class=\"step-ingredients-section\">\n\t\t\t<h5>Ingredients Used in This Step</h5>\n\t\t\t<div class=\"step-ingredients-list-container\"></div>\n\t\t\t<button type=\"button\" onclick=\"addIngredientToStep(this)\" class=\"add-ing-to-step-btn\">+ Add Ingredient</button>\n\t\t</div>\n\t");
    stepsWrapper.appendChild(stepCard);
    if (prefillData && prefillData.ingredients.length > 0) {
        var listContainer_1 = stepCard.querySelector('.step-ingredients-list-container');
        if (listContainer_1) {
            prefillData.ingredients.forEach(function (ing) {
                renderIngredientRow(listContainer_1, ing);
            });
        }
    }
}
function addNewStep() {
    addNewFormStep();
}
function removeFormStep(button) {
    var stepCard = button.closest('.step-card');
    if (!stepCard)
        return;
    var stepsWrapper = document.getElementById('steps-wrapper');
    if (!stepsWrapper)
        return;
    if (stepsWrapper.children.length <= 1) {
        showFormError('A recipe must have at least one step.');
        return;
    }
    stepCard.remove();
    reindexFormSteps();
}
function reindexFormSteps() {
    var stepsWrapper = document.getElementById('steps-wrapper');
    if (!stepsWrapper)
        return;
    var steps = stepsWrapper.querySelectorAll('.step-card');
    steps.forEach(function (step, idx) {
        var stepNum = idx + 1;
        step.setAttribute('data-step-index', stepNum.toString());
        var numDisplay = step.querySelector('.step-num-display');
        if (numDisplay)
            numDisplay.textContent = stepNum.toString();
    });
}
function addIngredientToStep(button) {
    var container = button.previousElementSibling;
    if (container && container.classList.contains('step-ingredients-list-container')) {
        renderIngredientRow(container);
    }
}
function renderIngredientRow(container, prefill) {
    var row = document.createElement('div');
    row.className = 'step-ingredient-row';
    // 1. Convert Object to Array using mapped Object.keys
    var ingredientsArray = Object.keys(dbIngredients).map(function (key) { return dbIngredients[key]; });
    var unitsArray = Object.keys(dbUnits).map(function (key) { return dbUnits[key]; });
    var ingredientOptions = "<option value=\"\" disabled ".concat(!prefill ? 'selected' : '', ">-- Select Ingredient --</option>");
    ingredientsArray.forEach(function (ing) {
        var selected = prefill && prefill.ingredient_id === ing.ingredient_id ? 'selected' : '';
        ingredientOptions += "<option value=\"".concat(ing.ingredient_id, "\" ").concat(selected, ">").concat(ing.name, "</option>");
    });
    var unitOptions = "<option value=\"\" disabled ".concat(!prefill ? 'selected' : '', ">-- Unit --</option>");
    unitsArray.forEach(function (unit) {
        var selected = prefill && prefill.unit_id === unit.unit_id ? 'selected' : '';
        unitOptions += "<option value=\"".concat(unit.unit_id, "\" ").concat(selected, ">").concat(unit.short_hand.length ? unit.short_hand : '(each)', "</option>");
    });
    row.innerHTML = "\n        <select class=\"ing-select\" required>\n            ".concat(ingredientOptions, "\n        </select>\n        <input type=\"number\" step=\"any\" class=\"ing-amount\" placeholder=\"Amount\" value=\"").concat(prefill ? prefill.amount : '', "\" min=\"0.001\" required>\n        <select class=\"unit-select\" required>\n            ").concat(unitOptions, "\n        </select>\n        <button type=\"button\" onclick=\"removeIngredientRow(this)\" class=\"remove-ing-row-btn\" aria-label=\"Remove ingredient\">\u2715</button>\n    ");
    container.appendChild(row);
}
function removeIngredientRow(button) {
    var row = button.closest('.step-ingredient-row');
    if (row)
        row.remove();
}
function submitRecipeForm(event, existingRecipeId) {
    event.preventDefault();
    var banner = document.getElementById('form-error-banner');
    if (banner) {
        banner.style.display = 'none';
        banner.textContent = '';
    }
    var titleInput = document.getElementById('recipe-title');
    var descInput = document.getElementById('recipe-description');
    var timeInput = document.getElementById('recipe-time');
    var servingsInput = document.getElementById('recipe-servings');
    var tagsInput = document.getElementById('recipe-tags');
    if (!titleInput || !descInput || !timeInput || !servingsInput)
        return;
    var title = titleInput.value.trim();
    var description = descInput.value.trim();
    var timeMinutes = parseInt(timeInput.value, 10);
    var servings = parseInt(servingsInput.value, 10);
    var tagsRaw = tagsInput ? tagsInput.value.trim() : '';
    var tags = tagsRaw
        ? tagsRaw
            .split(',')
            .map(function (t) { return t.trim().toLowerCase(); })
            .filter(function (t) { return t !== ''; })
        : [];
    var stepsWrapper = document.getElementById('steps-wrapper');
    if (!stepsWrapper)
        return;
    var stepCards = stepsWrapper.querySelectorAll('.step-card');
    var stepsPayload = [];
    var validationPassed = true;
    stepCards.forEach(function (card) {
        var textarea = card.querySelector('.step-description-input');
        if (!textarea)
            return;
        var stepText = textarea.value.trim();
        if (stepText === '') {
            validationPassed = false;
            return;
        }
        var ingredientRows = card.querySelectorAll('.step-ingredient-row');
        var stepIngredients = [];
        ingredientRows.forEach(function (row) {
            var ingSelect = row.querySelector('.ing-select');
            var amountInput = row.querySelector('.ing-amount');
            var unitSelect = row.querySelector('.unit-select');
            if (ingSelect && amountInput && unitSelect) {
                var ingredientId = ingSelect.value;
                var amount = parseFloat(amountInput.value);
                var unitId = parseInt(unitSelect.value, 10);
                if (!ingredientId || isNaN(amount) || isNaN(unitId)) {
                    validationPassed = false;
                    return;
                }
                stepIngredients.push({
                    ingredient_id: ingredientId,
                    amount: amount,
                    unit_id: unitId,
                });
            }
        });
        stepsPayload.push({
            step: stepText,
            ingredients: stepIngredients,
        });
    });
    if (!validationPassed || stepsPayload.length === 0) {
        showFormError('Please fill out all steps and ensure ingredients have valid amounts and selected units.');
        return;
    }
    var payload = {
        name: title,
        description: description,
        timeMinutes: timeMinutes,
        servings: servings,
        tags: tags,
        steps: stepsPayload,
    };
    var urlSegment = existingRecipeId ? "/recipe/edit/".concat(existingRecipeId) : '/recipe/create';
    var baseSubmitUrl = "".concat(urlSegment, "/").concat(encodeURIComponent(JSON.stringify(payload)));
    window.location.href = baseSubmitUrl;
}
function showFormError(message) {
    var banner = document.getElementById('form-error-banner');
    if (banner) {
        banner.textContent = message;
        banner.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}
function step_data_to_form_obj(raw) {
    return {
        step: raw.step,
        ingredients: raw.ingredients.map(function (ing) { return ({
            ingredient_id: ing.ingredient_id,
            amount: ing.amount,
            unit_id: ing.unit_id,
        }); }),
    };
}
function updateUserRegionPreference(region) {
    fetch("/user/preference/".concat(region), {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        },
    })
        .then(function (response) {
        if (response.ok) {
            // Refresh the current page to display updated conversions instantly
            window.location.reload();
        }
        else {
            console.error('Failed to save measurement region configuration change.');
        }
    })
        .catch(function (error) { return console.error('Error updating region choice preference:', error); });
}
var form = document.getElementById('fork-recipe-form');
if (form) {
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        var parentId = form.getAttribute('data-parent-id') || '';
        var payload = {
            name: document.getElementById('title').value,
            description: document.getElementById('description').value,
            timeMinutes: parseInt(document.getElementById('total_time').value, 10) || 0,
            servings: parseInt(document.getElementById('portions').value, 10) || 1,
            steps: [], // Target and map your DOM step items here
            tags: [], // Target and map your DOM tag items here
        };
        // Convert data object to an URL-safe string path parameter segment
        var serializedPayload = encodeURIComponent(JSON.stringify(payload));
        window.location.href = "/recipe/fork/".concat(parentId, "/").concat(serializedPayload);
    });
}
// -------------------------------------------------------------
// Fuzzy Ingredient Search UI Logic
// -------------------------------------------------------------
window.addEventListener('DOMContentLoaded', function () {
    var fuzzyInput = document.getElementById('ingredient-fuzzy-input');
    var fuzzyDropdown = document.getElementById('fuzzy-dropdown');
    var selectedContainer = document.getElementById('selected-ingredients-container');
    var searchBtn = document.getElementById('search-ingredients-btn');
    var allIngData = document.getElementById('all-ingredients-data');
    var selectedIngData = document.getElementById('selected-ingredients-data');
    if (fuzzyInput && fuzzyDropdown && selectedContainer && searchBtn && allIngData && selectedIngData) {
        var allIngredients_1 = JSON.parse(allIngData.textContent || '[]');
        var selectedIngredients_1 = JSON.parse(selectedIngData.textContent || '[]');
        // Renders the tags inside the container box above the input
        var renderSelected_1 = function () {
            selectedContainer.innerHTML = '';
            selectedIngredients_1.forEach(function (ing) {
                var _a;
                var tag = document.createElement('span');
                tag.style.cssText =
                    'background: #e8f0fe; color: #1b4332; padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem; border: 1px solid #b3d1ff; font-weight: 500;';
                tag.innerHTML = "\n\t\t\t\t\t".concat(ing.name, "\n\t\t\t\t\t<button type=\"button\" aria-label=\"Remove ").concat(ing.name, "\" style=\"background: none; border: none; color: #e63946; cursor: pointer; font-weight: bold; font-size: 1rem; display: flex; align-items: center; justify-content: center;\">&times;</button>\n\t\t\t\t");
                (_a = tag.querySelector('button')) === null || _a === void 0 ? void 0 : _a.addEventListener('click', function () {
                    selectedIngredients_1 = selectedIngredients_1.filter(function (i) { return i.ingredient_id !== ing.ingredient_id; });
                    renderSelected_1();
                });
                selectedContainer.appendChild(tag);
            });
        };
        // Runs the substring fuzzy lookup logic
        var filterDropdown = function () {
            var query = fuzzyInput.value.toLowerCase().trim();
            fuzzyDropdown.innerHTML = '';
            if (query === '') {
                fuzzyDropdown.style.display = 'none';
                return;
            }
            // Exclude anything that is already inside the selected box
            var matches = allIngredients_1.filter(function (ing) {
                return ing.name.toLowerCase().indexOf(query) !== -1 &&
                    !selectedIngredients_1.some(function (s) { return s.ingredient_id === ing.ingredient_id; });
            });
            if (matches.length === 0) {
                fuzzyDropdown.innerHTML =
                    '<div style="padding: 0.75rem; color: #718096; font-size: 0.9rem;">No matches found</div>';
            }
            else {
                matches.forEach(function (match) {
                    var item = document.createElement('div');
                    item.style.cssText =
                        'padding: 0.75rem 1rem; cursor: pointer; border-bottom: 1px solid #f5f4f7; color: #2d3748; transition: background 0.2s;';
                    item.textContent = match.name;
                    item.addEventListener('mouseenter', function () { return (item.style.background = '#f5f4f7'); });
                    item.addEventListener('mouseleave', function () { return (item.style.background = 'transparent'); });
                    item.addEventListener('click', function () {
                        selectedIngredients_1.push(match);
                        renderSelected_1();
                        fuzzyInput.value = '';
                        fuzzyDropdown.style.display = 'none';
                        fuzzyInput.focus();
                    });
                    fuzzyDropdown.appendChild(item);
                });
            }
            fuzzyDropdown.style.display = 'block';
        };
        fuzzyInput.addEventListener('input', filterDropdown);
        // Hide floating drop menu on outer click
        document.addEventListener('click', function (e) {
            if (!fuzzyInput.contains(e.target) && !fuzzyDropdown.contains(e.target)) {
                fuzzyDropdown.style.display = 'none';
            }
        });
        fuzzyInput.addEventListener('focus', filterDropdown);
        // Execute navigation push on click
        searchBtn.addEventListener('click', function () {
            if (selectedIngredients_1.length === 0) {
                window.location.href = '/ingredient';
                return;
            }
            var ids = selectedIngredients_1.map(function (i) { return i.ingredient_id; }).join('/');
            window.location.href = "/ingredient/".concat(ids);
        });
        renderSelected_1();
    }
});
