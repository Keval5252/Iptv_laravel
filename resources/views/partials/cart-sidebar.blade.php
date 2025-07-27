<!-- Cart Sidebar -->
<aside id="cart-sidebar" class="fixed top-0 right-0 h-full w-80 max-w-full bg-white shadow-lg z-50 transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col" data-cart-sidebar>
    <div class="flex items-center justify-between px-4 py-4 border-b border-gray-200">
        <span class="text-lg font-medium">Cart</span>
        <button class="text-3xl text-gray-400 hover:text-primary transition-colors" aria-label="Close cart" data-cart-close>&times;</button>
    </div>
    <div class="flex-1 flex flex-col items-center justify-center px-4 py-8">
        <div class="rounded-full bg-gray-100 w-20 h-20 flex items-center justify-center mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
        </div>
        <div class="text-gray-700 mb-6">No products in the cart.</div>
        <button class="border border-gray-700 px-8 py-3 rounded transition hover:bg-gray-100">Continue Shopping</button>
    </div>
</aside>
