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
