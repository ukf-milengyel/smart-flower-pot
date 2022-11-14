function fetchData() {
  fetch("http://localhost/project/get_data.php", {
    method: "get",
  })
    .then(function (response) {
      if (response.status >= 200 && response.status < 300) {
        return response.text();
      }
      throw new Error(response.statusText);
    })
    .then(function (response) {
      var data = JSON.parse(response);
      generateTable(data);
    });
}


function restart(){
    fetch("http://localhost/project/manual_restart.php", {
    method: "get",
   
  })
    .then(function (response) {
      if (response.status >= 200 && response.status < 300) {
        return response.text();
      }
      throw new Error(response.statusText);
    })
    .then(function (response) {
      alert("System is restarting")
    });
}

function manualUpdate(){
    fetch("http://localhost/project/manual_update.php", {
    method: "get",
  })
    .then(function (response) {
      if (response.status >= 200 && response.status < 300) {
        return response.text();
      }
      throw new Error(response.statusText);
    })
    .then(function (response) {
      alert("Data will be updated")
    });
}

function generateTable(data) {
    const table = document.getElementById("table");
    const tbody = document.createElement("tbody");

    const row = document.createElement("tr");
    
    var air_humidity  = document.createElement("td");
    const airHumidity_text = document.createTextNode(data[0].air_humidity);
    air_humidity.appendChild(airHumidity_text);
    row.appendChild(air_humidity);

    var soil_humidity  = document.createElement("td");
    const soilHumidity_text = document.createTextNode(data[0].soil_humidity);
    soil_humidity.appendChild(soilHumidity_text);
    row.appendChild(soil_humidity);

    var temp  = document.createElement("td");
    const temp_text = document.createTextNode(data[0].temperature);
    temp.appendChild(temp_text);
    row.appendChild(temp);

    var light_level  = document.createElement("td");
    const lightLevel_text = document.createTextNode(data[0].light_level);
    light_level.appendChild(lightLevel_text);
    row.appendChild(light_level);

    var time  = document.createElement("td");
    const time_text = document.createTextNode(data[0].timestamp);
    time.appendChild(time_text);
    row.appendChild(time);

    tbody.appendChild(row);
    table.appendChild(tbody);
}

fetchData();