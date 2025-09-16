// Cart functionality with notifications
document.addEventListener('DOMContentLoaded', function() {
    // Handle all "Add to Cart" forms
    const addToCartForms = document.querySelectorAll('form[action*="/cart/add/"]');
    
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const productName = form.closest('.product-card')?.querySelector('h3, .product-name')?.textContent || 'Product';
            const quantity = formData.get('qty') || 1;
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (response.ok) {
                    // Trigger cart notification
                    window.dispatchEvent(new CustomEvent('cart-item-added', {
                        detail: {
                            message: `${productName} (x${quantity}) added to cart!`,
                            productName: productName,
                            quantity: quantity
                        }
                    }));
                    
                    // Trigger cart badge update
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                } else {
                    throw new Error('Failed to add to cart');
                }
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
                showErrorMessage('Failed to add item to cart. Please try again.');
            });
        });
    });
    
    // Handle cart update forms
    const updateCartForms = document.querySelectorAll('form[action*="/cart/update/"]');
    
    updateCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (response.ok) {
                    // Trigger cart badge update
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                    
                    // Reload the page to show updated cart
                    window.location.reload();
                } else {
                    throw new Error('Failed to update cart');
                }
            })
            .catch(error => {
                console.error('Error updating cart:', error);
                showErrorMessage('Failed to update cart. Please try again.');
            });
        });
    });
    
    // Handle cart remove forms
    const removeCartForms = document.querySelectorAll('form[action*="/cart/remove/"]');
    
    removeCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (response.ok) {
                    // Trigger cart badge update
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                    
                    // Reload the page to show updated cart
                    window.location.reload();
                } else {
                    throw new Error('Failed to remove from cart');
                }
            })
            .catch(error => {
                console.error('Error removing from cart:', error);
                showErrorMessage('Failed to remove item from cart. Please try again.');
            });
        });
    });
});

// Helper function for error notifications
function showErrorMessage(message) {
    // Create a temporary error message
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
