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
  fetch("agency_dashboard_queries.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      type: "setPackage",
      data: data,
    }),
  });
};
