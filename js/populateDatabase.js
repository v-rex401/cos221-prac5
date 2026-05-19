//* Populate Destinations
function getCountries() {
  const req = new XMLHttpRequest();
  req.open(
    "GET",
    "https://restcountries.com/v3.1/all?fields=name,capital,region",
  );

  req.onreadystatechange = function () {
    if (req.readyState === 4 && req.status == 200) {
      const result = JSON.parse(req.responseText);
      const countries = [];
      for (var i = 0; i < result.length; i++) {
        countries.push({
          name: result[i].capital[0],
          country: result[i].name.common,
        });
      }
      //Send to PHP
      sendToPhp("populateDatabase.php", {
        type: "destinations",
        data: countries,
      });
    }
  };
  req.send();
}

function getFlights() {
  const req = new XMLHttpRequest();
  req.open(
    "POST",
    "https://api.aviationstack.com/v1/flights?access_key=37eef15d86e0a204669b06f6c69f769f",
  );
  req.setRequestHeader("Content-Type", "application/json");

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      const result = JSON.parse(req.responseText);
      console.log(result);
    }
  };
  const requestData = JSON.stringify({
    limit: 100,
  });
  req.send(requestData);

  //Send to PHP
}

//* Helper to send data to PHP
function sendToPhp(endpoint, payload) {
  fetch(endpoint, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(payload),
  });
}

//* RUN IT
getCountries();
