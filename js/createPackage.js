populateDropdown("getDestinations", "destination", "Destination_ID", "Name");
populateDropdown(
  "getAccommodations",
  "accommodation",
  "Accommodation_ID",
  "Name",
);
populateFlights("getFlights", "flights", "Flight_ID", "Airline");
document.getElementById("packageName").addEventListener("input", updatePreview);
document.getElementById("price").addEventListener("input", updatePreview);
document.getElementById("days").addEventListener("input", updatePreview);
document.getElementById("description").addEventListener("input", updatePreview);
document.getElementById("destination").addEventListener("change", updateDestination);
document.getElementById("accommodation").addEventListener("change", updateAccommodation);

const createButton = document.getElementById("createButton");
createButton.onclick = function () {
  //Store the stuff from the form
  const packageName = document.getElementById("packageName").value;
  const destination = document.getElementById("destination").value;
  const maxGuests = document.getElementById("maxGuests").value;
  const departureDate = document.getElementById("depDate").value;
  const arrivalDate = document.getElementById("arrDate").value;
  const price = document.getElementById("price").value;
  const description = document.getElementById("description").value;
  const duration = document.getElementById("days").value;
  const agencyId = document.getElementById("agencyId").value;

  const data = {
    packageName: packageName,
    destination: destination,
    maxGuests: maxGuests,
    departureDate: departureDate,
    arrivalDate: arrivalDate,
    price: price,
    description: description,
    duration: duration,
    agency_id: agencyId,
  };
  fetch("../../includes/agency_dashboard_queries.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      type: "setPackage",
      data: data,
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
    })
    .catch((err) => console.error("Error:", err));
};

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
        opt.textContent = `${flight.Airline} | ${flight.Departure_Loc} → ${flight.Arrival_Loc}`;
        select.appendChild(opt);
      });
    });
}



function updatePreview() {
  document.getElementById("prev-name").textContent =
    document.getElementById("packageName").value || "Package Name";

  document.getElementById("prev-price").textContent =
    "R" + (document.getElementById("price").value || "0");

  document.getElementById("prev-duration").textContent =
    (document.getElementById("days").value || "0") + " days";

  document.getElementById("prev-description").textContent =
    document.getElementById("description").value || "No description yet.";

  // Clear the list first


}


function updateDestination() {
  const destList = document.getElementById("prev-destinations");

  // Loop through selected options and add each one
  const destSelect = document.getElementById("destination");
  for (const option of destSelect.selectedOptions) {
    const li = document.createElement("li");
    li.textContent = option.textContent;
    destList.appendChild(li);
  }
}

function updateAccommodation() {
  const accommodationList = document.getElementById("prev-accommodations");

  const accommodationSelect = document.getElementById("accommodation");
  for (const option of accommodationSelect.selectedOptions) {
    const li = document.createElement("li");
    li.textContent = option.textContent;
    accommodationList.appendChild(li);
  }
}