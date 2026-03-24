
async function kuch_bhi() {
  try {
    const response = await fetch('backend/index.php');
    const data = await response.json();

    const container = document.getElementById("busCardsContainer");
    container.innerHTML = ""; // optional: clears old cards if function is called again

    data.forEach(({ bus_id, bus_number, route_name, stops }) => {
      const card = document.createElement("div");
      card.className = "bus-card";
      card.innerHTML = `
        <img src="images/buses.png" alt="bus" class="bus-image" />
        <div class="bus-info">
          <div class="bus-number">${bus_number}</div>
          <div class="bus-route">${route_name}</div>
          <div class="bus-stops">${stops}</div>
        </div>
        <div class="button-container">
          <button class="track-button" onclick="bus=${bus_id}; 
  htmx.ajax('GET', 'track.html', { 
    target: '#main-content', 
    swap: 'innerHTML', 
    headers: { 'HX-Push-Url': '/bus/' + ${bus_id} }
  });">
  Track
</button>
        </div>
      `;
      container.appendChild(card);
      htmx.process(card);
    });

    const desponse = await fetch('backend/index1.php');
    const data1 = await desponse.json();

    data1.forEach(({ bus_id, bus_number, route_name, stops }) => {
      const card = document.createElement("div");
      card.className = "bus-card";
      card.innerHTML = `
        <img src="images/buses.png" alt="bus" class="bus-image" style="filter: grayscale(100%);" />
        <div class="bus-info">
          <div class="bus-number">${bus_number}</div>
          <div class="bus-route">${route_name}</div>
          <div class="bus-stops">${stops}</div>
          
        </div>
        <div class="disable">Not running</div>
      `;
      container.appendChild(card);
    });
  } catch (error) {
    console.error("Error fetching data:", error);
  }
}
kuch_bhi();