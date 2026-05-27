Promise.all([
    populateDropdown("getDestinations", "destination", "Destination_ID", "Name"),
    populateAccommodations(),
    populateFlights(),
    populateDropdown("getRestaurants", "restaurants", "Restaurant_ID", "Name"),
    populateDropdown("getAttractions", "attractions", "Attraction_ID", "Name"),
]).then(() => {
    if (PACKAGE_ID) loadPackageForEdit(PACKAGE_ID);
});

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
    name: "", price: 0, duration: 0, description: "", maxGuests: 0,
    destinations: [], accommodations: [], flights: [], restaurants: [],
    attractions: [], agency_id: AGENCY_ID, departureDate: "", arrivalDate: "", image: ""
};

document.getElementById("clear").onclick = function () {
    ['flights', 'attractions', 'restaurants'].forEach(id => {
        const select = document.getElementById(id);
        Array.from(select.options).forEach(opt => opt.selected = false);
    });

    // Clear the corresponding preview lists
    document.getElementById('prev-flights').innerHTML = '';
    document.getElementById('prev-attractions').innerHTML = '';
    document.getElementById('prev-restaurants').innerHTML = '';

    // Reset the cost/total previews that depend on flights
    document.getElementById('prev-flight-cost').textContent = 'R0';
    document.getElementById('prev-accommodation-cost').textContent = 'R0';
    document.getElementById('prev-total').textContent = 'R0';
};

document.getElementById("createButton").onclick = function () {
    packageData.departureDate = document.getElementById("depDate").value;
    packageData.arrivalDate = document.getElementById("arrDate").value;

    fetch("../../includes/agency_dashboard_queries.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            type: "updatePackage",       // always update, never create
            package_id: PACKAGE_ID,
            agency_id: AGENCY_ID,
            data: packageData,
        }),
    })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                alert("Package updated!");
                window.location.href = "agency_dashboard.php";
            } else {
                alert("Error: " + response.message);
            }
        });
};

// =================================== DROPDOWNS ===================================================
function populateDropdown(type, elementId, valueKey, labelKey) {
    return fetch("../../includes/agency_dashboard_queries.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ type }),
    })
        .then(res => res.json())
        .then(items => {
            const select = document.getElementById(elementId);
            select.innerHTML = "";
            items.forEach(item => {
                const opt = document.createElement("option");
                opt.value = item[valueKey];
                opt.textContent = item[labelKey];
                select.appendChild(opt);
            });
        });
}

function populateAccommodations() {
    return fetch("../../includes/agency_dashboard_queries.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ type: "getAccommodations" }),
    })
        .then(res => res.json())
        .then(accommodations => {
            const select = document.getElementById("accommodation");
            select.innerHTML = "";
            accommodations.forEach(a => {
                const opt = document.createElement("option");
                opt.value = a.Accommodation_ID;
                opt.dataset.price = a.Price_PN;
                opt.textContent = a.Name;
                select.appendChild(opt);
            });
        });
}

function populateFlights() {
    return fetch("../../includes/agency_dashboard_queries.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ type: "getFlights" }),
    })
        .then(res => res.json())
        .then(flights => {
            const select = document.getElementById("flights");
            select.innerHTML = "";
            flights.forEach(f => {
                const opt = document.createElement("option");
                opt.value = f.Flight_ID;
                opt.dataset.price = f.Price;
                opt.textContent = `${f.Airline} | ${f.Departure_Loc} → ${f.Arrival_Loc}`;
                select.appendChild(opt);
            });
        });
}

// =================================== PREVIEW ===================================================
function updatePreview() {
    document.getElementById("prev-name").textContent =
        document.getElementById("packageName").value || "Package Name";
    document.getElementById("prev-description").textContent =
        document.getElementById("description").value || "No description yet.";

    const basePrice = parseFloat(document.getElementById("price").value) || 0;
    let flightCost = 0, accommodationCost = 0;
    document.querySelectorAll("#prev-flights li").forEach(li => flightCost += parseFloat(li.dataset.price) || 0);
    document.querySelectorAll("#prev-accommodations li").forEach(li => accommodationCost += parseFloat(li.dataset.price) || 0);

    document.getElementById("prev-price").textContent = "Base Price: R" + basePrice.toFixed(2);
    document.getElementById("prev-flight-cost").textContent = "R" + flightCost.toFixed(2);
    document.getElementById("prev-accommodation-cost").textContent = "R" + accommodationCost.toFixed(2);
    document.getElementById("prev-total").textContent = "R" + (basePrice + flightCost + accommodationCost).toFixed(2);

    packageData.name = document.getElementById("packageName").value;
    packageData.price = parseFloat(document.getElementById("price").value) || 0;
    packageData.description = document.getElementById("description").value;
    packageData.maxGuests = parseInt(document.getElementById("maxGuests").value) || 0;
}

function updateDestination() {
    packageData.destinations = [];
    const destList = document.getElementById("prev-destinations");
    destList.innerHTML = "";
    for (const opt of document.getElementById("destination").selectedOptions) {
        packageData.destinations.push(opt.value);
        const li = document.createElement("li");
        li.textContent = opt.textContent;
        destList.appendChild(li);
    }
}

function updateDates() {
    const days = parseInt(document.getElementById("days").value) || 1;
    packageData.duration = days;
    document.getElementById("prev-duration").textContent = days + " days";

    // Recalculate accommodation cost with new days
    packageData.accommodations = [];
    const aList = document.getElementById("prev-accommodations");
    aList.innerHTML = "";
    for (const opt of document.getElementById("accommodation").selectedOptions) {
        packageData.accommodations.push(opt.value);
        const li = document.createElement("li");
        const cost = (parseFloat(opt.dataset.price) || 0) * days;
        li.dataset.price = cost.toFixed(2);
        li.textContent = `${opt.textContent} — R${cost.toFixed(2)} (R${parseFloat(opt.dataset.price).toFixed(2)}/night × ${days} days)`;
        aList.appendChild(li);
    }
    updatePreview();
}

function updateAccommodation() {
    packageData.accommodations = [];
    const aList = document.getElementById("prev-accommodations");
    aList.innerHTML = "";
    const days = parseInt(document.getElementById("days").value) || 1;
    for (const opt of document.getElementById("accommodation").selectedOptions) {
        packageData.accommodations.push(opt.value);
        const li = document.createElement("li");
        const cost = (parseFloat(opt.dataset.price) || 0) * days;
        li.dataset.price = cost.toFixed(2);
        li.textContent = `${opt.textContent} — R${cost.toFixed(2)} (R${parseFloat(opt.dataset.price).toFixed(2)}/night × ${days} days)`;
        aList.appendChild(li);
    }
    updatePreview();
}

function updateFlights() {
    packageData.flights = [];
    const flightList = document.getElementById("prev-flights");
    flightList.innerHTML = "";
    for (const opt of document.getElementById("flights").selectedOptions) {
        packageData.flights.push(opt.value);
        const li = document.createElement("li");
        li.dataset.price = parseFloat(opt.dataset.price).toFixed(2);
        li.textContent = `${opt.textContent} — R${li.dataset.price}`;
        flightList.appendChild(li);
    }
    updatePreview();
}

function updateRestaurants() {
    packageData.restaurants = [];
    const list = document.getElementById("prev-restaurants");
    list.innerHTML = "";
    for (const opt of document.getElementById("restaurants").selectedOptions) {
        packageData.restaurants.push(opt.value);
        const li = document.createElement("li");
        li.textContent = opt.textContent;
        list.appendChild(li);
    }
}

function updateAttractions() {
    packageData.attractions = [];
    const list = document.getElementById("prev-attractions");
    list.innerHTML = "";
    for (const opt of document.getElementById("attractions").selectedOptions) {
        packageData.attractions.push(opt.value);
        const li = document.createElement("li");
        li.textContent = opt.textContent;
        list.appendChild(li);
    }
}

// =================================== IMAGE PICKER ===================================================
var imageSearchTimer = null;
function fetchImageOptions(query) {
    clearTimeout(imageSearchTimer);
    if (!query) return;
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
    imgElement.style.borderColor = '#00aaff';
    document.getElementById('selected_image').value = url;
    packageData.image = url;
    document.getElementById('packageImage').setAttribute('src', url);
}

// =================================== LOAD EXISTING PACKAGE ===================================================
function loadPackageForEdit(id) {
    fetch("../../includes/agency_dashboard_queries.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ type: "getPackage", package_id: id }),
    })
        .then(r => r.json())
        .then(pkg => {
            if (pkg.error) return;

            document.getElementById("packageName").value = pkg.Name || "";
            document.getElementById("description").value = pkg.Description || "";
            document.getElementById("days").value = pkg.Duration || "";
            document.getElementById("maxGuests").value = pkg.Capacity || "";
            document.getElementById("depDate").value = pkg.Departure_Date || "";
            document.getElementById("price").value = pkg.Price || "";

            if (pkg.image) {
                document.getElementById("packageImage").src = pkg.image;
                packageData.image = pkg.image;
            }

            packageData.name = pkg.Name;
            packageData.price = parseFloat(pkg.Price) || 0;
            packageData.duration = parseInt(pkg.Duration) || 0;
            packageData.description = pkg.Description || "";
            packageData.maxGuests = parseInt(pkg.Capacity) || 0;
            packageData.destinations = (pkg.destinations || []).map(Number);
            packageData.accommodations = (pkg.accommodations || []).map(Number);
            packageData.flights = (pkg.flights || []).map(Number);
            packageData.restaurants = (pkg.restaurants || []).map(Number);
            packageData.attractions = (pkg.attractions || []).map(Number);

            // Pre-select dropdowns
            ["destination", "accommodation", "flights", "restaurants", "attractions"].forEach(elemId => {
                const key = elemId === "destination" ? "destinations"
                    : elemId === "accommodation" ? "accommodations"
                        : elemId;
                const ids = packageData[key].map(String);
                for (const opt of document.getElementById(elemId).options)
                    opt.selected = ids.includes(opt.value);
            });

            // Rebuild preview lists
            const days = packageData.duration || 1;

            const destList = document.getElementById("prev-destinations");
            destList.innerHTML = "";
            for (const opt of document.getElementById("destination").options) {
                if (!opt.selected) continue;
                const li = document.createElement("li");
                li.textContent = opt.textContent;
                destList.appendChild(li);
            }

            const aList = document.getElementById("prev-accommodations");
            aList.innerHTML = "";
            for (const opt of document.getElementById("accommodation").options) {
                if (!opt.selected) continue;
                const li = document.createElement("li");
                const cost = (parseFloat(opt.dataset.price) || 0) * days;
                li.dataset.price = cost.toFixed(2);
                li.textContent = `${opt.textContent} — R${cost.toFixed(2)} (R${parseFloat(opt.dataset.price).toFixed(2)}/night × ${days} days)`;
                aList.appendChild(li);
            }

            const flightList = document.getElementById("prev-flights");
            flightList.innerHTML = "";
            for (const opt of document.getElementById("flights").options) {
                if (!opt.selected) continue;
                const li = document.createElement("li");
                li.dataset.price = parseFloat(opt.dataset.price).toFixed(2);
                li.textContent = `${opt.textContent} — R${li.dataset.price}`;
                flightList.appendChild(li);
            }

            const restList = document.getElementById("prev-restaurants");
            restList.innerHTML = "";
            for (const opt of document.getElementById("restaurants").options) {
                if (!opt.selected) continue;
                const li = document.createElement("li");
                li.textContent = opt.textContent;
                restList.appendChild(li);
            }

            const attrList = document.getElementById("prev-attractions");
            attrList.innerHTML = "";
            for (const opt of document.getElementById("attractions").options) {
                if (!opt.selected) continue;
                const li = document.createElement("li");
                li.textContent = opt.textContent;
                attrList.appendChild(li);
            }

            document.getElementById("prev-name").textContent = pkg.Name || "";
            document.getElementById("prev-description").textContent = pkg.Description || "";
            document.getElementById("prev-duration").textContent = (pkg.Duration || 0) + " days";
            updatePreview();
        });
}