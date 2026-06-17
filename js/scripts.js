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
        addButton.setAttribute('onclick', "handleBasketAdd(this, '/basket/add/".concat(recipeId, "')"));
        addButton.textContent = 'Add To Basket';
        managementGroup.replaceWith(addButton);
    }
}
/**
 * Handles adding items to the basket asynchronously.
 */
function handleBasketAdd(button, url) {
    button.disabled = true;
    button.textContent = 'Adding...';
    fetch(url, {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
    })
        .then(function (response) {
        if (!response.ok)
            throw new Error('Failed to add item to basket');
        // Fixed: Added "_" and "-" characters to align perfectly with index.php routing rules
        var recipeIdMatch = url.match(/\/basket\/add\/([a-zA-Z0-9_-]+)/);
        var recipeId = recipeIdMatch ? recipeIdMatch[1] : '';
        var managementGroup = document.createElement('div');
        managementGroup.className = 'basket-management-group';
        managementGroup.setAttribute('data-recipe-id', recipeId);
        managementGroup.innerHTML = "\n                <a href=\"javascript:void(0)\" onclick=\"handleBasketDecrement('".concat(recipeId, "')\" class=\"decrement-btn\" aria-label=\"Decrease quantity\">-</a>\n                <span class=\"recipe-count-display\">1</span>\n                <a href=\"javascript:void(0)\" onclick=\"handleBasketIncrement('").concat(recipeId, "')\" class=\"increment-btn\" aria-label=\"Increase quantity\">+</a>\n                <a href=\"javascript:void(0)\" onclick=\"handleBasketRemove('").concat(recipeId, "')\" class=\"remove-btn\" aria-label=\"Remove item\">Remove</a>\n            ");
        button.replaceWith(managementGroup);
    })
        .catch(function (error) {
        console.error('Error adding to basket:', error);
        button.textContent = 'Failed';
        button.disabled = false;
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
