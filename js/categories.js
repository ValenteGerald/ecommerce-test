const productsContainer = document.getElementById("products-container");

async function loadProducts() {
  try {
    const response = await fetch("api/getcategories.php");
    const data = await response.json();

    // Adjust if Involve Asia API structure changes
    const products = data?.data || [];

    if (products.length === 0) {
      productsContainer.innerHTML = "<p>No products found.</p>";
      return;
    }

    products.forEach(product => {
      const link = document.createElement("a");
      link.href = product.product_url; // affiliate product link
      link.target = "_blank";
      link.classList.add("product-link");

      const card = document.createElement("div");
      card.classList.add("product-card");

      card.innerHTML = `
        <img src="${product.image_url || 'images/default.jpg'}" alt="${product.product_name}">
        <h3>${product.product_name}</h3>
        <p>${product.currency} ${product.price}</p>
        <p>${product.merchant_name}</p>
      `;

      link.appendChild(card);
      productsContainer.appendChild(link);
    });
  } catch (error) {
    console.error("Error loading products:", error);
    productsContainer.innerHTML = "<p>Error loading products.</p>";
  }
}

loadProducts();
