const searchInput = document.getElementById("search-input");
const autocompleteItems = document.getElementById("autocomplete-items");

// Event listener for input changes
searchInput.addEventListener("input", function() {
  const inputValue = this.value.toLowerCase();
  autocompleteItems.innerHTML = "";

  if (!inputValue) {
    autocompleteItems.style.display = "none";
    return;
  }

  const apiUrl = `https://api.geoapify.com/v1/geocode/autocomplete?text=${inputValue}&apiKey=6280fa3f1f5e4b7ca8931c01979b1e88`;

  fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
      if (data.features && data.features.length > 0) {
        data.features.forEach(feature => {
          const county = feature.properties.county;
          const city = feature.properties.city;
          const postcode = feature.properties.postcode;
          const state = feature.properties.state;
          // Check if these properties are defined before including them
          if (county !== undefined || city !== undefined || postcode !== undefined||state !== undefined) {
            const itemElement = document.createElement("div");
            itemElement.classList.add("autocomplete-item");
            let suggestion = "";

            // if (county) {
            //   suggestion += `County: ${county}`;
            // }
            if (city) {
              if (suggestion) {
                suggestion += `, `;
              }
              suggestion += ` ${city}`;
            }
            
            if (state) {
              if (suggestion) {
                suggestion += `, `;
              }
              suggestion += ` ${state}`;
            }

            itemElement.textContent = suggestion;
            itemElement.addEventListener("click", function() {
              searchInput.value = suggestion;
              autocompleteItems.style.display = "none";
            });
            autocompleteItems.appendChild(itemElement);
          }
        });
        autocompleteItems.style.display = "block";
      } else {
        autocompleteItems.style.display = "none";
      }
    })
    .catch(error => {
      console.error("Error fetching data from the API: " + error);
    });
});

// Close the autocomplete dropdown when clicking outside of the search box
document.addEventListener("click", function(e) {
  if (e.target !== searchInput) {
    autocompleteItems.style.display = "none";
  }
});