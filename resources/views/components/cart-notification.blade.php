<div x-data="cartNotification()" x-init="init()" class="fixed top-4 right-4 z-50">
    <!-- Notification Toast -->
    <div x-show="showNotification" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-x-full scale-95"
         x-transition:enter-end="opacity-100 transform translate-x-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-x-0 scale-100"
         x-transition:leave-end="opacity-0 transform translate-x-full scale-95"
         class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center space-x-3 max-w-sm border border-green-400 opacity-65">
        <!-- Success Icon with Animation -->
        <div class="flex-shrink-0 animate-bounce">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <!-- Message -->
        <div class="flex-1">
            <p class="font-semibold text-lg">Added to Cart!</p>
            <p class="text-sm opacity-90" x-text="notificationMessage"></p>
        </div>
        <!-- Close Button -->
        <button @click="hideNotification()" class="flex-shrink-0 ml-2 hover:bg-white hover:bg-opacity-20 rounded-full p-1 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

<script>
function cartNotification() {
    return {
        showNotification: false,
        notificationMessage: '',
        
        init() {
            // Listen for cart add events
            window.addEventListener('cart-item-added', (event) => {
                this.notificationMessage = event.detail.message || 'Item added to cart!';
                this.showNotification = true;
                
                // Auto hide after 3 seconds
                setTimeout(() => {
                    this.hideNotification();
                }, 3000);
            });
        },
        
        hideNotification() {
            this.showNotification = false;
        }
    }
}
</script>
