// All agency dashboard logic will be handled here
//Get components from the php
const parent = document.getElementById("mainBoard");
//* The idea, each package will display in a card and then edit and delete button added to it

window.onload = function () {
  loadPackages();
};
function loadPackages() {
  fetch("../../includes/agency_dashboard_queries.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      type: "getAgencyPackages",
      agency_id: AGENCY_ID,
    }),
  })
    .then((res) => res.json())
    .then((packages) => {
      parent.innerHTML =
        "<button onclick=\"window.location.href='create_package.php'\">Create Package</button>";

      if (packages.length === 0) {
        parent.innerHTML += "<p>No packages yet. Create one!<p>";
      } else {
        packages.forEach((pkg) => {
          parent.appendChild(createPackageCard(pkg));
        });
      }
    });
}
//Create cards for each package

function createPackageCard(pkg) {
  //Create the card div
  const newPackage = document.createElement("div");
  //Add to correct styling
  newPackage.classList.add("dashboardCard");
  newPackage.innerHTML = `
  <h3>${pkg.Name}</h3>
  <p><strong>Price:</strong> R${pkg.Price}</p>
  <p><strong>Duration:</strong> ${pkg.Duration} days
  <p> <strong>Description:</strong> ${pkg.Description}</p>`;
  const editButton = document.createElement("button");
  const deleteButton = document.createElement("button");

  editButton.id = "editButton";
  deleteButton.id = "deleteButton";

  editButton.textContent = "Edit";
  deleteButton.textContent = "Delete";
  editButton.onclick = () =>
    (window.location.href = `create_package.php?package_id=${pkg.Package_ID}`);
  //Add delete button functionality
  //Add the info to the packages
  newPackage.appendChild(editButton);
  newPackage.appendChild(deleteButton);

  return newPackage;
}
