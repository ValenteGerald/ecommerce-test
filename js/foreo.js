const productsContainer = document.getElementById("products-container");

async function loadForeoFeed() {
  try {
    const response = await fetch("php/getforeo.php");
    const data = await response.json();

    const products = data?.products || [];

    if (products.length === 0) {
      productsContainer.innerHTML = "<p>No products found.</p>";
      return;
    }

    products.forEach(product => {
      const cardLink = document.createElement("a");
      cardLink.href = product.link || "#";
      cardLink.target = "_blank";
      cardLink.classList.add("product-link");

      const card = document.createElement("div");
      card.classList.add("product-card");

      card.innerHTML = `
        <img src="${product.image_url || 'images/default.jpg'}" alt="${product.description || 'Product image'}">
        <h3>ID: ${product.id}</h3>
        <p><strong>Price:</strong> ${product.price || 'N/A'}</p>
        ${product.sale_price ? `<p><strong>Sale:</strong> ${product.sale_price}</p>` : ""}
        <p>${product.description || 'No description available.'}</p>
        <p><strong>Availability:</strong> ${product.availability || 'Unknown'}</p>
      `;

      cardLink.appendChild(card);
      productsContainer.appendChild(cardLink);
    });
  } catch (error) {
    console.error("Error loading FOREO feed:", error);
    productsContainer.innerHTML = "<p>Error loading products.</p>";
  }
}

loadForeoFeed();
