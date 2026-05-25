
populateDropdown("getDestinations", "destination", "Destination_ID", "Name");
populateAccommodations();
populateFlights("getFlights", "flights", "Flight_ID", "Airline");
populateDropdown("getRestaurants", "restaurants", "Restaurant_ID", "Name");
populateDropdown("getAttractions", "attractions", "Attraction_ID", "Name");

document.getElementById("packageName").addEventListener("input", updatePreview);
document.getElementById("price").addEventListener("input", updatePreview);
document.getElementById("days").addEventListener("input", updateDates);
document.getElementById("description").addEventListener("input", updatePreview);
document.getElementById("destination").addEventListener("change", updateDestination);
document.getElementById("accommodation").addEventListener("change", updateAccommodation);
document.getElementById("flights").addEventListener("change", updateFlights);
document.getElementById("restaurants").addEventListener("change", updateRestaurants);
document.getElementById("attractions").addEventListener("change", updateAttractions);


const packageData = {
  name: "",
  price: 0,
  duration: 0,
  description: "",
  maxGuests: 0,
  destinations: [],
  accommodations: [],
  flights: [],
  restaurants: [],
  attractions: [],
  agency_id: AGENCY_ID,
  departureDate: "",
  arrivalDate: "",
  image: ""
};


const createButton = document.getElementById("createButton");
createButton.onclick = function () {
  //Store the stuff from the form
  packageData.departureDate = document.getElementById("depDate").value;
  packageData.arrivalDate = document.getElementById("arrDate").value;

  //TODO: Validation Checks
  fetch("../../includes/agency_dashboard_queries.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      type: "setPackage",
      data: packageData,
    }),
  })
    //Display message to user

    //get message back from PHP then display alert
    .then((res) => res.json())
    .then((response) => {
      if (response.success) {
        alert("Package created successfully!");
        window.location.href = "agency_dashboard.php"; // redirect back
      } else {
        alert("Error: " + response.message);
      }
    });

};

// =================================== POPULATION OF DROPDOWNS ===================================================
function populateDropdown(type, elementId, valueKey, labelKey) {
  fetch("../../includes/agency_dashboard_queries.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ type: type }),
  })
    .then((res) => res.json())
    .then((items) => {
      const select = document.getElementById(elementId);
      select.innerHTML = "";
      items.forEach((item) => {
        const opt = document.createElement("option");
        opt.value = item[valueKey];
        opt.textContent = item[labelKey];
        select.appendChild(opt);
      });
    });
}

function populateAccommodations() {
  fetch("../../includes/agency_dashboard_queries.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ type: "getAccommodations" }),
  })
    .then((res) => res.json())
    .then((accommodations) => {
      const select = document.getElementById("accommodation");
      accommodations.forEach((accommodation) => {
        const opt = document.createElement("option");
        opt.value = accommodation.Accommodation_ID;
        opt.dataset.price = accommodation.Price_PN;
        opt.textContent = accommodation.Name;
        select.appendChild(opt);
      });
    });
}
function populateFlights(type, elementId, valueKey, labelKey) {
  // Instead of populateDropdown for flights, do this:
  fetch("../../includes/agency_dashboard_queries.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ type: "getFlights" }),
  })
    .then((res) => res.json())
    .then((flights) => {
      const select = document.getElementById("flights");
      flights.forEach((flight) => {
        const opt = document.createElement("option");
        opt.value = flight.Flight_ID;
        opt.dataset.price = flight.Price;
        opt.textContent = `${flight.Airline} | ${flight.Departure_Loc} → ${flight.Arrival_Loc}`;
        select.appendChild(opt);
      });
    });
}


// ====================================== UPDATE THE PREVIEW SIDE OF SCREEN ========================================================
function updatePreview() {
  document.getElementById("prev-name").textContent =
    document.getElementById("packageName").value || "Package Name";

  document.getElementById("prev-price").textContent =
    "R" + (document.getElementById("price").value || "0");

  /* document.getElementById("prev-duration").textContent =
    (document.getElementById("days").value || "0") + " days"; */

  document.getElementById("prev-description").textContent =
    document.getElementById("description").value || "No description yet.";



  // const days = parseInt(document.getElementById("days").value) || 1;
  const basePrice = parseFloat(document.getElementById("price").value) || 0;

  let flightCost = 0;
  document.querySelectorAll("#prev-flights li").forEach((li) => {
    flightCost += parseFloat(li.dataset.price) || 0;
  });

  let accommodationCost = 0;
  document.querySelectorAll("#prev-accommodations li").forEach((li) => {
    accommodationCost += parseFloat(li.dataset.price) || 0;
  });

  const total = basePrice + flightCost + accommodationCost;

  document.getElementById("prev-price").textContent = "Base Price: R" + basePrice.toFixed(2);
  document.getElementById("prev-flight-cost").textContent = "R" + flightCost.toFixed(2);
  document.getElementById("prev-accommodation-cost").textContent = "R" + accommodationCost.toFixed(2);
  document.getElementById("prev-total").textContent = "R" + total.toFixed(2);

  packageData.name = document.getElementById("packageName").value;
  packageData.price = parseFloat(document.getElementById("price").value) || 0;
  // packageData.duration = parseFloat(document.getElementById("days").value) || 0;
  packageData.description = document.getElementById("description").value;
  packageData.maxGuests = parseInt(document.getElementById("maxGuests").value) || 0;
}


function updateDestination() {
  const destList = document.getElementById("prev-destinations");

  // Loop through selected options and add each one
  const destSelect = document.getElementById("destination");
  for (const option of destSelect.selectedOptions) {
    packageData.destinations.push(option.value);
    const li = document.createElement("li");
    li.textContent = option.textContent;
    destList.appendChild(li);
  }
}
function updateDates() {
  document.getElementById("prev-duration").textContent =
    (document.getElementById("days").value || "0") + " days";
  const days = parseInt(document.getElementById("days").value) || 1;
  packageData.duration = parseFloat(document.getElementById("days").value) || 0;

  if (packageData.accommodations.length !== 0) {
    const accommodationSelect = document.getElementById("accommodation");
    const option = accommodationSelect.selectedOptions[0];
    const li = document.getElementById("prev-accommodations").querySelector("li");
    const pricePerNight = parseFloat(option.dataset.price);
    li.textContent =
      `${option.textContent} — R${(pricePerNight * days).toFixed(2)} (R${pricePerNight.toFixed(2)}/night × ${days} days)`;
  }
  //get the accomodation and update those dates 
}
function updateAccommodation() {
  packageData.accommodations = [];
  const aList = document.getElementById("prev-accommodations");
  aList.innerHTML = "";
  const days = parseInt(document.getElementById("days").value) || 1;
  const accommodationSelect = document.getElementById("accommodation");
  for (const option of accommodationSelect.selectedOptions) {
    packageData.accommodations.push(option.value);
    const li = document.createElement("li");
    const cost = (parseFloat(option.dataset.price) || 0) * days;
    li.dataset.price = cost.toFixed(2);
    li.textContent = `${option.textContent} — R${li.dataset.price} (R${parseFloat(option.dataset.price).toFixed(2)}/night × ${days} days)`;
    aList.appendChild(li);
  }
  updatePreview();
}

function updateFlights() {
  const flightList = document.getElementById("prev-flights");
  const flightSelect = document.getElementById("flights");
  for (const option of flightSelect.selectedOptions) {
    packageData.flights.push(option.value);
    const li = document.createElement("li");
    li.dataset.price = parseFloat(option.dataset.price).toFixed(2);
    li.textContent = `${option.textContent} — R${li.dataset.price}`;
    flightList.appendChild(li);
  }
  updatePreview();
}

function updateRestaurants() {
  const restaurantList = document.getElementById("prev-restaurants");
  const restaurantSelect = document.getElementById("restaurants");
  for (const option of restaurantSelect.selectedOptions) {
    packageData.restaurants.push(option.value);
    const li = document.createElement("li");
    li.textContent = option.textContent;
    restaurantList.appendChild(li);
  }
  updatePreview();
}

function updateAttractions() {
  const attractionList = document.getElementById("prev-attractions");
  const attractionSelect = document.getElementById("attractions");
  for (const option of attractionSelect.selectedOptions) {
    packageData.attractions.push(option.value);
    const li = document.createElement("li");
    li.textContent = option.textContent;
    attractionList.appendChild(li);
  }
  updatePreview();
}
var imageSearchTimer = null;
async function fetchImageOptions(query) {
  clearTimeout(imageSearchTimer);
  imageSearchTimer = setTimeout(async () => {
    const response = await fetch(`../../api/get_images.php?query=${encodeURIComponent(query)}`);
    const images = await response.json();

    const grid = document.getElementById('image-grid');
    grid.innerHTML = '';

    images.forEach(url => {
      const img = document.createElement('img');
      img.src = url;
      img.style.cssText = 'width:100%; height:80px; object-fit:cover; cursor:pointer; border:3px solid transparent; border-radius:4px;';
      img.onclick = () => selectImage(url, img);
      grid.appendChild(img);
    });
  }, 500);

}

function selectImage(url, imgElement) {
  document.querySelectorAll('#image-grid img').forEach(img => img.style.borderColor = 'transparent');
  imgElement.style.borderColor = '#00aaff'; // highlight selected
  document.getElementById('selected_image').value = url;
  packageData.image = url; // store in packageData too

  //update the preview side 
  document.getElementById('packageImage').setAttribute('src', url);
}