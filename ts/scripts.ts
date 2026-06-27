/**
 * Handles toggling Likes and Favourites asynchronously in the background.
 */
function handleRecipeAction(button: HTMLButtonElement, url: string, actionType: 'like' | 'favourite'): void {
	const currentStatus: string | null = button.getAttribute('data-status');
	const isLikedOrFavourited: boolean = currentStatus === 'liked' || currentStatus === 'favourited';

	// 1. Determine next active/inactive state strings
	let nextStatus: string = '';
	if (actionType === 'like') {
		nextStatus = isLikedOrFavourited ? 'like' : 'liked';
	} else {
		nextStatus = isLikedOrFavourited ? 'favourite' : 'favourited';
	}

	// 2. Locate elements
	const img: HTMLImageElement | null = button.querySelector('img');
	const countSpan: HTMLSpanElement | null = button.querySelector('.action-count');

	// Save the original text value for error rollback states
	const originalCountText = countSpan ? countSpan.textContent || '0' : '0';
	let currentCount = parseInt(originalCountText, 10);
	if (isNaN(currentCount)) currentCount = 0;

	// 3. Optimistically calculate the new numerical count
	let newCount = currentCount;
	if (nextStatus === 'liked' || nextStatus === 'favourited') {
		newCount = currentCount + 1;
	} else {
		newCount = Math.max(0, currentCount - 1);
	}

	// 4. Instantly apply updates to the DOM for immediate user response
	button.className = `${actionType}-button ${nextStatus}`;
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
		.then((response) => {
			if (!response.ok) throw new Error('Server responded with an error status.');
		})
		.catch((error: Error) => {
			console.error('Error updating status:', error);

			// Failure Fallback: Safely reset the exact original counts and classes
			if (currentStatus) {
				button.className = `${actionType}-button ${currentStatus}`;
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
function updateBasketDOM(recipeId: string, newCount: number): void {
	const managementGroup = document.querySelector(
		`.basket-management-group[data-recipe-id="${recipeId}"]`,
	) as HTMLDivElement | null;

	if (!managementGroup) return;

	if (newCount > 0) {
		const countDisplay = managementGroup.querySelector('.recipe-count-display');
		if (countDisplay) {
			countDisplay.textContent = newCount.toString();
		}
	} else {
		const addButton = document.createElement('button');
		addButton.className = 'add-button';
		addButton.setAttribute('aria-label', 'Add to Basket');
		addButton.setAttribute('onclick', `handleBasketAdd('${recipeId}', this)`);
		addButton.textContent = 'Add To Basket';

		managementGroup.replaceWith(addButton);
	}
}

/**
 * Handles adding items to the basket asynchronously.
 */
function handleBasketAdd(recipeId: string, button: HTMLButtonElement | null = null): void {
	if (button) {
		button.disabled = true;
		button.textContent = 'Adding...';
	}

	fetch(`/basket/add/${recipeId}`, {
		method: 'GET',
		headers: { 'X-Requested-With': 'XMLHttpRequest' },
	})
		.then((response) => {
			if (!response.ok) throw new Error('Failed to add item to basket');

			const managementGroup = document.createElement('div');
			managementGroup.className = 'basket-management-group';
			managementGroup.setAttribute('data-recipe-id', recipeId);

			managementGroup.innerHTML = `
                <a href="javascript:void(0)" onclick="handleBasketDecrement('${recipeId}')" class="decrement-btn" aria-label="Decrease quantity">-</a>
                <span class="recipe-count-display">1</span>
                <a href="javascript:void(0)" onclick="handleBasketIncrement('${recipeId}')" class="increment-btn" aria-label="Increase quantity">+</a>
                <a href="javascript:void(0)" onclick="handleBasketRemove('${recipeId}')" class="remove-btn" aria-label="Remove item">Remove</a>
            `;

			if (button) {
				button.replaceWith(managementGroup);
			}
		})
		.catch((error: Error) => {
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
function handleBasketIncrement(recipeId: string): void {
	const url = `/basket/increment/${recipeId}`;

	fetch(url, {
		method: 'GET',
		headers: { 'X-Requested-With': 'XMLHttpRequest' },
	})
		.then((response) => {
			if (!response.ok) throw new Error('Failed to increment quantity');

			const countDisplay = document.querySelector(
				`.basket-management-group[data-recipe-id="${recipeId}"] .recipe-count-display`,
			);
			if (countDisplay) {
				const currentCount = parseInt(countDisplay.textContent || '1', 10);
				updateBasketDOM(recipeId, currentCount + 1);
			}
		})
		.catch((error: Error) => {
			console.error('Error incrementing basket quantity:', error);
		});
}

/**
 * Decrements an item's quantity in the basket.
 */
function handleBasketDecrement(recipeId: string): void {
	const url = `/basket/decrement/${recipeId}`;

	fetch(url, {
		method: 'GET',
		headers: { 'X-Requested-With': 'XMLHttpRequest' },
	})
		.then((response) => {
			if (!response.ok) throw new Error('Failed to decrement quantity');

			const countDisplay = document.querySelector(
				`.basket-management-group[data-recipe-id="${recipeId}"] .recipe-count-display`,
			);
			if (countDisplay) {
				const currentCount = parseInt(countDisplay.textContent || '1', 10);
				updateBasketDOM(recipeId, currentCount - 1);
			}
		})
		.catch((error: Error) => {
			console.error('Error decrementing basket quantity:', error);
		});
}

/**
 * Removes an item from the basket entirely.
 */
function handleBasketRemove(recipeId: string): void {
	const url = `/basket/remove/${recipeId}`;

	if (!confirm('Are you sure you want to remove this item?')) {
		return;
	}

	fetch(url, {
		method: 'GET',
		headers: { 'X-Requested-With': 'XMLHttpRequest' },
	})
		.then((response) => {
			if (!response.ok) throw new Error('Failed to remove item');
			updateBasketDOM(recipeId, 0);
		})
		.catch((error: Error) => {
			console.error('Error removing item from basket:', error);
		});
}

function handleToggleIngredientCheck(checkbox: HTMLInputElement, ingredientId: string): void {
	const listItem = checkbox.closest('.shopping-list-item') as HTMLLIElement | null;
	const originallyChecked = !checkbox.checked;
	const isChecked = checkbox.checked;

	if (listItem) {
		if (isChecked) {
			listItem.classList.add('checked');
		} else {
			listItem.classList.remove('checked');
		}
	}

	fetch(`/basket/check/${ingredientId}`, {
		method: 'GET',
		headers: { 'X-Requested-With': 'XMLHttpRequest' },
	})
		.then((response) => {
			if (!response.ok) {
				throw new Error('Failed to update check status');
			}
			return response.json();
		})
		.then((data) => {
			checkbox.checked = data.is_checked;
			if (listItem) {
				if (data.is_checked) {
					listItem.classList.add('checked');
				} else {
					listItem.classList.remove('checked');
				}
			}
		})
		.catch((error: Error) => {
			console.error('Error toggling checkbox state:', error);
			checkbox.checked = originallyChecked;
			if (listItem) {
				if (originallyChecked) {
					listItem.classList.add('checked');
				} else {
					listItem.classList.remove('checked');
				}
			}
		});
}

function handleCommentLike(button: HTMLButtonElement, commentId: string): void {
	const currentStatus = button.getAttribute('data-status');
	const isLiked = currentStatus === 'liked';
	const nextStatus = isLiked ? 'like' : 'liked';

	const countSpan = button.querySelector('.like-count') as HTMLSpanElement | null;
	const originalCountText = countSpan ? countSpan.textContent || '0' : '0';
	let currentCount = parseInt(originalCountText, 10);
	if (isNaN(currentCount)) currentCount = 0;

	const newCount = isLiked ? Math.max(0, currentCount - 1) : currentCount + 1;

	button.className = `comment-like-btn ${nextStatus}`;
	button.setAttribute('data-status', nextStatus);
	if (countSpan) {
		countSpan.textContent = newCount.toString();
	}

	fetch(`/comment/like/${commentId}`, {
		method: 'GET',
		headers: { 'X-Requested-With': 'XMLHttpRequest' },
	})
		.then((response) => {
			if (!response.ok) throw new Error('Failed to update comment like status');
		})
		.catch((error: Error) => {
			console.error('Error liking comment:', error);
			button.className = `comment-like-btn ${currentStatus}`;
			button.setAttribute('data-status', currentStatus || 'like');
			if (countSpan) {
				countSpan.textContent = originalCountText;
			}
		});
}

interface DBIngredient {
	ingredient_id: string;
	name: string;
	description: string;
	category: string;
}

interface DBUnit {
	unit_id: number;
	short_hand: string;
}

interface StepIngredientPayload {
	ingredient_id: string;
	amount: number;
	unit_id: number;
}

interface StepPayload {
	step: string;
	ingredients: StepIngredientPayload[];
}

interface RecipePayload {
	name: string;
	description: string;
	timeMinutes: number;
	servings: number;
	tags: string[];
	steps: StepPayload[];
}

let dbIngredients: Record<string, DBIngredient>;
let dbUnits: Record<string, DBUnit>;

window.addEventListener('DOMContentLoaded', () => {
	const ingredientsElement = document.getElementById('db-ingredients-data');
	const unitsElement = document.getElementById('db-units-data');
	const existingStepsElement = document.getElementById('existing-steps-data');

	if (ingredientsElement && unitsElement) {
		dbIngredients = JSON.parse(ingredientsElement.textContent || '{}');
		dbUnits = JSON.parse(unitsElement.textContent || '{}');
	}

	const existingSteps: StepPayload[] = existingStepsElement
		? JSON.parse(existingStepsElement.textContent || '[]')
		: [];

	if (existingSteps.length > 0) {
		existingSteps.forEach((stepData) => {
			addNewFormStep(step_data_to_form_obj(stepData));
		});
	} else {
		addNewStep();
	}
});

function addNewFormStep(prefillData?: {
	step: string;
	ingredients: { ingredient_id: string; amount: number; unit_id: number }[];
}): void {
	const stepsWrapper = document.getElementById('steps-wrapper');
	if (!stepsWrapper) return;

	const stepIndex = stepsWrapper.children.length + 1;
	const stepCard = document.createElement('div');
	stepCard.className = 'step-card';
	stepCard.setAttribute('data-step-index', stepIndex.toString());

	stepCard.innerHTML = `
		<div class="step-card-header">
			<h4>Step <span class="step-num-display">${stepIndex}</span></h4>
			<button type="button" onclick="removeFormStep(this)" class="remove-step-btn" aria-label="Remove step">✕</button>
		</div>
		<div class="form-group">
			<textarea class="step-description-input" placeholder="Describe the cooking instructions for this step..." required>${prefillData ? prefillData.step : ''}</textarea>
		</div>
		<div class="step-ingredients-section">
			<h5>Ingredients Used in This Step</h5>
			<div class="step-ingredients-list-container"></div>
			<button type="button" onclick="addIngredientToStep(this)" class="add-ing-to-step-btn">+ Add Ingredient</button>
		</div>
	`;

	stepsWrapper.appendChild(stepCard);

	if (prefillData && prefillData.ingredients.length > 0) {
		const listContainer = stepCard.querySelector('.step-ingredients-list-container');
		if (listContainer) {
			prefillData.ingredients.forEach((ing) => {
				renderIngredientRow(listContainer, ing);
			});
		}
	}
}

function addNewStep(): void {
	addNewFormStep();
}

function removeFormStep(button: HTMLButtonElement): void {
	const stepCard = button.closest('.step-card');
	if (!stepCard) return;

	const stepsWrapper = document.getElementById('steps-wrapper');
	if (!stepsWrapper) return;

	if (stepsWrapper.children.length <= 1) {
		showFormError('A recipe must have at least one step.');
		return;
	}

	stepCard.remove();
	reindexFormSteps();
}

function reindexFormSteps(): void {
	const stepsWrapper = document.getElementById('steps-wrapper');
	if (!stepsWrapper) return;

	const steps = stepsWrapper.querySelectorAll('.step-card');
	steps.forEach((step, idx) => {
		const stepNum = idx + 1;
		step.setAttribute('data-step-index', stepNum.toString());
		const numDisplay = step.querySelector('.step-num-display');
		if (numDisplay) numDisplay.textContent = stepNum.toString();
	});
}

function addIngredientToStep(button: HTMLButtonElement): void {
	const container = button.previousElementSibling;
	if (container && container.classList.contains('step-ingredients-list-container')) {
		renderIngredientRow(container);
	}
}

function renderIngredientRow(
	container: Element,
	prefill?: { ingredient_id: string; amount: number; unit_id: number },
): void {
	const row = document.createElement('div');
	row.className = 'step-ingredient-row';

	// 1. Convert Object to Array using mapped Object.keys
	const ingredientsArray = Object.keys(dbIngredients).map((key) => dbIngredients[key]);
	const unitsArray = Object.keys(dbUnits).map((key) => dbUnits[key]);

	let ingredientOptions = `<option value="" disabled ${!prefill ? 'selected' : ''}>-- Select Ingredient --</option>`;

	ingredientsArray.forEach((ing: any) => {
		const selected = prefill && prefill.ingredient_id === ing.ingredient_id ? 'selected' : '';
		ingredientOptions += `<option value="${ing.ingredient_id}" ${selected}>${ing.name}</option>`;
	});

	let unitOptions = `<option value="" disabled ${!prefill ? 'selected' : ''}>-- Unit --</option>`;

	unitsArray.forEach((unit: any) => {
		const selected = prefill && prefill.unit_id === unit.unit_id ? 'selected' : '';
		unitOptions += `<option value="${unit.unit_id}" ${selected}>${unit.short_hand.length ? unit.short_hand : '(each)'}</option>`;
	});

	row.innerHTML = `
        <select class="ing-select" required>
            ${ingredientOptions}
        </select>
        <input type="number" step="any" class="ing-amount" placeholder="Amount" value="${prefill ? prefill.amount : ''}" min="0.001" required>
        <select class="unit-select" required>
            ${unitOptions}
        </select>
        <button type="button" onclick="removeIngredientRow(this)" class="remove-ing-row-btn" aria-label="Remove ingredient">✕</button>
    `;

	container.appendChild(row);
}

function removeIngredientRow(button: HTMLButtonElement): void {
	const row = button.closest('.step-ingredient-row');
	if (row) row.remove();
}

function submitRecipeForm(event: Event, existingRecipeId: string): void {
	event.preventDefault();

	const banner = document.getElementById('form-error-banner');
	if (banner) {
		banner.style.display = 'none';
		banner.textContent = '';
	}

	const titleInput = document.getElementById('recipe-title') as HTMLInputElement | null;
	const descInput = document.getElementById('recipe-description') as HTMLTextAreaElement | null;
	const timeInput = document.getElementById('recipe-time') as HTMLInputElement | null;
	const servingsInput = document.getElementById('recipe-servings') as HTMLInputElement | null;
	const tagsInput = document.getElementById('recipe-tags') as HTMLInputElement | null;

	if (!titleInput || !descInput || !timeInput || !servingsInput) return;

	const title = titleInput.value.trim();
	const description = descInput.value.trim();
	const timeMinutes = parseInt(timeInput.value, 10);
	const servings = parseInt(servingsInput.value, 10);

	const tagsRaw = tagsInput ? tagsInput.value.trim() : '';
	const tags = tagsRaw
		? tagsRaw
				.split(',')
				.map((t) => t.trim().toLowerCase())
				.filter((t) => t !== '')
		: [];

	const stepsWrapper = document.getElementById('steps-wrapper');
	if (!stepsWrapper) return;

	const stepCards = stepsWrapper.querySelectorAll('.step-card');
	const stepsPayload: StepPayload[] = [];

	let validationPassed = true;

	stepCards.forEach((card) => {
		const textarea = card.querySelector('.step-description-input') as HTMLTextAreaElement | null;
		if (!textarea) return;

		const stepText = textarea.value.trim();
		if (stepText === '') {
			validationPassed = false;
			return;
		}

		const ingredientRows = card.querySelectorAll('.step-ingredient-row');
		const stepIngredients: StepIngredientPayload[] = [];

		ingredientRows.forEach((row) => {
			const ingSelect = row.querySelector('.ing-select') as HTMLSelectElement | null;
			const amountInput = row.querySelector('.ing-amount') as HTMLInputElement | null;
			const unitSelect = row.querySelector('.unit-select') as HTMLSelectElement | null;

			if (ingSelect && amountInput && unitSelect) {
				const ingredientId = ingSelect.value;
				const amount = parseFloat(amountInput.value);
				const unitId = parseInt(unitSelect.value, 10);

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

	const payload: RecipePayload = {
		name: title,
		description: description,
		timeMinutes: timeMinutes,
		servings: servings,
		tags: tags,
		steps: stepsPayload,
	};

	const urlSegment = existingRecipeId ? `/recipe/edit/${existingRecipeId}` : '/recipe/create';
	const baseSubmitUrl = `${urlSegment}/${encodeURIComponent(JSON.stringify(payload))}`;

	window.location.href = baseSubmitUrl;
}

function showFormError(message: string): void {
	const banner = document.getElementById('form-error-banner');
	if (banner) {
		banner.textContent = message;
		banner.style.display = 'block';
		window.scrollTo({ top: 0, behavior: 'smooth' });
	}
}

function step_data_to_form_obj(raw: any): {
	step: string;
	ingredients: { ingredient_id: string; amount: number; unit_id: number }[];
} {
	return {
		step: raw.step,
		ingredients: raw.ingredients.map((ing: any) => ({
			ingredient_id: ing.ingredient_id,
			amount: ing.amount,
			unit_id: ing.unit_id,
		})),
	};
}

function updateUserRegionPreference(region: string) {
	fetch(`/user/preference/${region}`, {
		method: 'POST',
		headers: {
			'X-Requested-With': 'XMLHttpRequest',
		},
	})
		.then((response) => {
			if (response.ok) {
				// Refresh the current page to display updated conversions instantly
				window.location.reload();
			} else {
				console.error('Failed to save measurement region configuration change.');
			}
		})
		.catch((error) => console.error('Error updating region choice preference:', error));
}

interface RecipeForkPayload {
	name: string;
	description: string;
	timeMinutes: number;
	servings: number;
	steps: StepPayload[];
	tags: string[];
}

const form = document.getElementById('fork-recipe-form') as HTMLFormElement | null;

if (form) {
	form.addEventListener('submit', (event: Event) => {
		event.preventDefault();

		const parentId = form.getAttribute('data-parent-id') || '';

		const payload: RecipeForkPayload = {
			name: (document.getElementById('title') as HTMLInputElement).value,
			description: (document.getElementById('description') as HTMLTextAreaElement).value,
			timeMinutes: parseInt((document.getElementById('total_time') as HTMLInputElement).value, 10) || 0,
			servings: parseInt((document.getElementById('portions') as HTMLInputElement).value, 10) || 1,
			steps: [], // Target and map your DOM step items here
			tags: [], // Target and map your DOM tag items here
		};

		// Convert data object to an URL-safe string path parameter segment
		const serializedPayload = encodeURIComponent(JSON.stringify(payload));

		window.location.href = `/recipe/fork/${parentId}/${serializedPayload}`;
	});
}

// -------------------------------------------------------------
// Fuzzy Ingredient Search UI Logic
// -------------------------------------------------------------
window.addEventListener('DOMContentLoaded', () => {
	const fuzzyInput = document.getElementById('ingredient-fuzzy-input') as HTMLInputElement | null;
	const fuzzyDropdown = document.getElementById('fuzzy-dropdown') as HTMLDivElement | null;
	const selectedContainer = document.getElementById('selected-ingredients-container') as HTMLDivElement | null;
	const searchBtn = document.getElementById('search-ingredients-btn') as HTMLButtonElement | null;

	const allIngData = document.getElementById('all-ingredients-data');
	const selectedIngData = document.getElementById('selected-ingredients-data');

	if (fuzzyInput && fuzzyDropdown && selectedContainer && searchBtn && allIngData && selectedIngData) {
		const allIngredients: { ingredient_id: string; name: string }[] = JSON.parse(allIngData.textContent || '[]');
		let selectedIngredients: { ingredient_id: string; name: string }[] = JSON.parse(
			selectedIngData.textContent || '[]',
		);

		// Renders the tags inside the container box above the input
		const renderSelected = () => {
			selectedContainer.innerHTML = '';
			selectedIngredients.forEach((ing) => {
				const tag = document.createElement('span');
				tag.style.cssText =
					'background: #e8f0fe; color: #1b4332; padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem; border: 1px solid #b3d1ff; font-weight: 500;';

				tag.innerHTML = `
					${ing.name}
					<button type="button" aria-label="Remove ${ing.name}" style="background: none; border: none; color: #e63946; cursor: pointer; font-weight: bold; font-size: 1rem; display: flex; align-items: center; justify-content: center;">&times;</button>
				`;

				tag.querySelector('button')?.addEventListener('click', () => {
					selectedIngredients = selectedIngredients.filter((i) => i.ingredient_id !== ing.ingredient_id);
					renderSelected();
				});

				selectedContainer.appendChild(tag);
			});
		};

		// Runs the substring fuzzy lookup logic
		const filterDropdown = () => {
			const query = fuzzyInput.value.toLowerCase().trim();
			fuzzyDropdown.innerHTML = '';

			if (query === '') {
				fuzzyDropdown.style.display = 'none';
				return;
			}

			// Exclude anything that is already inside the selected box
			const matches = allIngredients.filter(
				(ing) =>
					ing.name.toLowerCase().indexOf(query) !== -1 &&
					!selectedIngredients.some((s) => s.ingredient_id === ing.ingredient_id),
			);

			if (matches.length === 0) {
				fuzzyDropdown.innerHTML =
					'<div style="padding: 0.75rem; color: #718096; font-size: 0.9rem;">No matches found</div>';
			} else {
				matches.forEach((match) => {
					const item = document.createElement('div');
					item.style.cssText =
						'padding: 0.75rem 1rem; cursor: pointer; border-bottom: 1px solid #f5f4f7; color: #2d3748; transition: background 0.2s;';
					item.textContent = match.name;

					item.addEventListener('mouseenter', () => (item.style.background = '#f5f4f7'));
					item.addEventListener('mouseleave', () => (item.style.background = 'transparent'));

					item.addEventListener('click', () => {
						selectedIngredients.push(match);
						renderSelected();
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
		document.addEventListener('click', (e) => {
			if (!fuzzyInput.contains(e.target as Node) && !fuzzyDropdown.contains(e.target as Node)) {
				fuzzyDropdown.style.display = 'none';
			}
		});

		fuzzyInput.addEventListener('focus', filterDropdown);

		// Execute navigation push on click
		searchBtn.addEventListener('click', () => {
			if (selectedIngredients.length === 0) {
				window.location.href = '/ingredient';
				return;
			}
			const ids = selectedIngredients.map((i) => i.ingredient_id).join('/');
			window.location.href = `/ingredient/${ids}`;
		});

		renderSelected();
	}
});
