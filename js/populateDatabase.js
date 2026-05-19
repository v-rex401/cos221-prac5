//Get Data for packages
function getInfoData() {
  const req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState === 4 && req.status) {
      const result = JSON.parse(req.responeText);
      console.log(result);
    }
  };
  req.open(
    "POST",
    "https://complete-travel-search-api.p.rapidapi.com/v1/api/flight-booking-options",
  );
  req.setRequestHeader("Content-Type", "application/json");

  const requestData = JSON.stringify({});
  req.send(requestData);
}
