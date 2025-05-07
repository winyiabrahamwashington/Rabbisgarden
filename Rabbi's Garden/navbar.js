// navbar.js
function loadNavbar() {
  const navHTML = `
    <nav>
      <div class="container">
        <div class="logo">
          <img src="https://via.placeholder.com/50x50.png?text=Logo" alt="Rabbi's Garden Logo">
          <span>Rabbi's Garden</span>
        </div>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="donations.html">Donations</a></li>
          <li><a href="sermons.html">Sermons</a></li>
          <li><a href="bible-shop.html">Bible Shop</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </div>
    </nav>
  `;
  document.body.insertAdjacentHTML('afterbegin', navHTML);
}

// Call the function to load the navbar
loadNavbar();