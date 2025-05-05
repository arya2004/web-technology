async function updateCartCount() {
    try {
      const { data } = await axios.get("/cart");
      document.getElementById("cartCount").textContent = data.items.length;
    } catch { /* ignore */ }
  }
  document.addEventListener("DOMContentLoaded", () => {
    updateCartCount();
  
    const logout = document.getElementById("logoutBtn");
    if (logout) logout.onclick = async () => {
      await axios.post("/auth/logout"); location = "/";
    };
  
    const loginForm = document.getElementById("loginForm");
    if (loginForm) loginForm.onsubmit = async (e) => {
      e.preventDefault();
      await axios.post("/auth/login", Object.fromEntries(new FormData(loginForm)));
      location = "/";
    };
  
    const regForm = document.getElementById("registerForm");
    if (regForm) regForm.onsubmit = async (e) => {
      e.preventDefault();
      await axios.post("/auth/register", Object.fromEntries(new FormData(regForm)));
      location = "/";
    };
  });
  