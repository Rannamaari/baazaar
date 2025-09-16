// Category page filtering and view enhancements
document.addEventListener('DOMContentLoaded', function() {
    // Handle sort dropdown change
    const sortSelect = document.getElementById('sort');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            // The form will auto-submit due to onchange="this.form.submit()"
            // Add loading state
            this.style.opacity = '0.6';
            this.disabled = true;
        });
    }

    // Handle price filter form submission
    const priceForm = document.querySelector('form[action*="category"]');
    if (priceForm) {
        const minPriceInput = priceForm.querySelector('input[name="min_price"]');
        const maxPriceInput = priceForm.querySelector('input[name="max_price"]');
        
        if (minPriceInput && maxPriceInput) {
            // Add validation
            priceForm.addEventListener('submit', function(e) {
                const minPrice = parseFloat(minPriceInput.value);
                const maxPrice = parseFloat(maxPriceInput.value);
                
                if (minPrice && maxPrice && minPrice > maxPrice) {
                    e.preventDefault();
                    alert('Minimum price cannot be greater than maximum price.');
                    return false;
                }
                
                if (minPrice && minPrice < 0) {
                    e.preventDefault();
                    alert('Price cannot be negative.');
                    return false;
                }
                
                if (maxPrice && maxPrice < 0) {
                    e.preventDefault();
                    alert('Price cannot be negative.');
                    return false;
                }
            });
        }
    }

    // Add smooth transitions for view toggle
    const viewToggleLinks = document.querySelectorAll('a[href*="view="]');
    viewToggleLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Add loading state
            const productsContainer = document.querySelector('.grid, .space-y-4');
            if (productsContainer) {
                productsContainer.style.opacity = '0.6';
                productsContainer.style.transition = 'opacity 0.3s ease';
            }
        });
    });

    // Add smooth transitions for subcategory filters
    const subcategoryLinks = document.querySelectorAll('a[href*="subcategory="]');
    subcategoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Add loading state
            const productsContainer = document.querySelector('.grid, .space-y-4');
            if (productsContainer) {
                productsContainer.style.opacity = '0.6';
                productsContainer.style.transition = 'opacity 0.3s ease';
            }
        });
    });

    // Restore opacity after page load
    window.addEventListener('load', function() {
        const productsContainer = document.querySelector('.grid, .space-y-4');
        if (productsContainer) {
            productsContainer.style.opacity = '1';
        }
    });
});

