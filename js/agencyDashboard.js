// All agency dashboard logic will be handled here
//Get components from the php

//* The idea, each package will display in a card and then edit and delete button added to it

window.onload = function () {
  getInfoData();
  const parent = document.getElementById("mainBoard");
  parent.appendChild(createPackageCard());
};

const createPackageButton = document.getElementById("createPackage");
createPackageButton.onclick = function () {
  //Open the create_package.php
};
//Create cards for each package

function createPackageCard() {
  //Create the card div
  const newPackage = document.createElement("div");
  //Add to correct styling
  newPackage.classList.add("dashboardCard");

  const editButton = document.createElement("button");
  const deleteButton = document.createElement("button");

  editButton.id = "editButton";
  deleteButton.id = "deleteButton";

  editButton.textContent = "Edit";
  deleteButton.textContent = "Delete";

  newPackage.appendChild(editButton);
  newPackage.appendChild(deleteButton);

  return newPackage;
}
