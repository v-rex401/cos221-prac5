//Get Data for packages
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
      fetch("populateDatabase.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(countries),
      });
    }
  };
  req.send();
}
getCountries();
