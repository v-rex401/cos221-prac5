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
