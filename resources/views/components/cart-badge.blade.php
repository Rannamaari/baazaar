<div x-data="cartBadge()" x-init="init()">
    <!-- Cart Badge -->
    <div x-show="itemCount > 0" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-50"
        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center shadow-lg border-2 border-white min-w-[20px] z-20"
        :class="{ 'animate-pulse': isAnimating }" x-text="itemCount">
    </div>
</div>

<script>
    function cartBadge() {
        return {
            itemCount: 0,
            isAnimating: false,

            init() {
                // Initialize with actual cart count
                this.updateCartCount();

                // Listen for cart updates
                window.addEventListener('cart-updated', () => {
                    this.updateCartCount();
                    this.triggerAnimation();
                });

                // Listen for cart add events
                window.addEventListener('cart-item-added', () => {
                    this.updateCartCount();
                    this.triggerAnimation();
                });
            },

            updateCartCount() {
                // Get cart count from session or make an AJAX request
                fetch('/cart/count')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        this.itemCount = data.count || 0;
                    })
                    .catch((error) => {
                        console.warn('Failed to fetch cart count:', error);
                        // Fallback: count items in session
                        this.itemCount = this.getSessionCartCount();
                    });
            },

            getSessionCartCount() {
                // This is a fallback method - in a real app you'd get this from the server
                return 0;
            },

            triggerAnimation() {
                this.isAnimating = true;

                // Simple pulse animation for 0.5 seconds
                setTimeout(() => {
                    this.isAnimating = false;
                }, 500);
            }
        }
    }
</script>