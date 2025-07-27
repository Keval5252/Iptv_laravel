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

  // Open drawer
  if (drawerOpenBtn) {
    drawerOpenBtn.addEventListener("click", () => {
      drawerOverlay.classList.remove("hidden")
      drawer.classList.remove("-translate-x-full")
    })
  }

  // Close drawer
  if (drawerCloseBtn) {
    drawerCloseBtn.addEventListener("click", () => {
      drawerOverlay.classList.add("hidden")
      drawer.classList.add("-translate-x-full")
    })
  }

  // Close drawer when clicking overlay
  if (drawerOverlay) {
    drawerOverlay.addEventListener("click", () => {
      drawerOverlay.classList.add("hidden")
      drawer.classList.add("-translate-x-full")
    })
  }

  // Open search drawer
  if (searchOpenBtn) {
    searchOpenBtn.addEventListener("click", () => {
      searchDrawer.classList.remove("-translate-y-full")
    })
  }

  // Close search drawer
  if (searchCloseBtn) {
    searchCloseBtn.addEventListener("click", () => {
      searchDrawer.classList.add("-translate-y-full")
    })
  }

  // Open cart sidebar
  if (cartOpenBtn) {
    cartOpenBtn.addEventListener("click", () => {
      cartSidebar.classList.remove("translate-x-full")
    })
  }

  // Close cart sidebar
  if (cartCloseBtn) {
    cartCloseBtn.addEventListener("click", () => {
      cartSidebar.classList.add("translate-x-full")
    })
  }
})
