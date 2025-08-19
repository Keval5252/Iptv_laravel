// Prevent multiple executions of this script
if (window.drawerInitialized) {
    console.log('Drawer already initialized, skipping...');
} else {
    window.drawerInitialized = true;

    document.addEventListener("DOMContentLoaded", () => {
        // Drawer functionality
        const drawerOverlay = document.getElementById("drawer-overlay")
        const drawer = document.getElementById("drawer")
        const drawerOpenBtn = document.querySelector("[data-drawer-open]")
        const drawerCloseBtn = document.querySelector("[data-drawer-close]")

        // Search drawer functionality
        const searchDrawer = document.getElementById("search-drawer")
        const searchOpenBtn = document.querySelector("[data-search-open]")
        const searchCloseBtn = document.querySelector("[data-search-close]")

        // Cart sidebar functionality
        const cartSidebar = document.getElementById("cart-sidebar")
        const cartOpenBtn = document.querySelector("[data-cart-open]")
        const cartCloseBtn = document.querySelector("[data-cart-close]")

        // Remove existing event listeners to prevent duplicates
        const removeExistingListeners = (element, eventType) => {
            if (element && element._drawerListeners && element._drawerListeners[eventType]) {
                element.removeEventListener(eventType, element._drawerListeners[eventType]);
                delete element._drawerListeners[eventType];
            }
        };

        // Add event listener with duplicate prevention
        const addDrawerListener = (element, eventType, handler) => {
            if (!element) return;

            // Remove existing listener if any
            removeExistingListeners(element, eventType);

            // Store reference to handler for potential removal
            if (!element._drawerListeners) element._drawerListeners = {};
            element._drawerListeners[eventType] = handler;

            // Add new listener
            element.addEventListener(eventType, handler);
        };

        // Open drawer
        if (drawerOpenBtn) {
            addDrawerListener(drawerOpenBtn, "click", (e) => {
                e.preventDefault();
                e.stopPropagation();
                if (drawerOverlay) drawerOverlay.classList.remove("hidden");
                if (drawer) drawer.classList.remove("-translate-x-full");
            });
        }

        // Close drawer
        if (drawerCloseBtn) {
            addDrawerListener(drawerCloseBtn, "click", (e) => {
                e.preventDefault();
                e.stopPropagation();
                if (drawerOverlay) drawerOverlay.classList.add("hidden");
                if (drawer) drawer.classList.add("-translate-x-full");
            });
        }

        // Close drawer when clicking overlay
        if (drawerOverlay) {
            addDrawerListener(drawerOverlay, "click", (e) => {
                e.preventDefault();
                e.stopPropagation();
                drawerOverlay.classList.add("hidden");
                if (drawer) drawer.classList.add("-translate-x-full");
            });
        }

        // Open search drawer
        if (searchOpenBtn) {
            addDrawerListener(searchOpenBtn, "click", (e) => {
                e.preventDefault();
                e.stopPropagation();
                if (searchDrawer) searchDrawer.classList.remove("-translate-y-full");
            });
        }

        // Close search drawer
        if (searchCloseBtn) {
            addDrawerListener(searchCloseBtn, "click", (e) => {
                e.preventDefault();
                e.stopPropagation();
                if (searchDrawer) searchDrawer.classList.add("-translate-y-full");
            });
        }

        // Open cart sidebar
        if (cartOpenBtn) {
            addDrawerListener(cartOpenBtn, "click", (e) => {
                e.preventDefault();
                e.stopPropagation();
                if (cartSidebar) cartSidebar.classList.remove("translate-x-full");
            });
        }

        // Close cart sidebar
        if (cartCloseBtn) {
            addDrawerListener(cartCloseBtn, "click", (e) => {
                e.preventDefault();
                e.stopPropagation();
                if (cartSidebar) cartSidebar.classList.add("translate-x-full");
            });
        }

        console.log('Drawer functionality initialized successfully');
    });
}
