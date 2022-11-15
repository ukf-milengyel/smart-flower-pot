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
    document.getElementById("restartbtn").disabled = true;
    document.getElementById("updatebtn").disabled = true;

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
      alert("System is restarting");
        let timer = 20;
        const interval = setInterval(()=>{
            if (timer<=0){
                clearInterval(interval);
                fetchData();
                document.getElementById("restartbtn").disabled = false;
                document.getElementById("updatebtn").disabled = false;
            }else{
                setSummary("Refreshing data... "+timer);
                timer--;
            }
        }, 1000);
    });
}

function manualUpdate(){
    document.getElementById("updatebtn").disabled = true;

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
      alert("Data will be updated");
      let timer = 5;
      const interval = setInterval(()=>{
          if (timer<=0){
              clearInterval(interval);
              fetchData();
              document.getElementById("updatebtn").disabled = false;
          }else{
              setSummary("Refreshing data... "+timer);
              timer--;
          }
      }, 1000);
    });
}

function generateTable(data) {
    const table = document.getElementById("table");
    const tbody = document.createElement("tbody");

    document.getElementById("t_soil").innerHTML = (Math.round (data[0].soil_humidity * 1000) / 10) + "%";
    document.getElementById("t_temp").innerHTML = data[0].temperature + "°C";
    document.getElementById("t_light").innerHTML = (Math.round (data[0].light_level * 1000) / 10) + "%";
    document.getElementById("t_air").innerHTML = data[0].air_humidity + "%";
    document.getElementById("t_last").innerHTML = new Date(data[0].timestamp).toLocaleString();

    for(let i = 0; i < data.length; i++){
        const row = document.createElement("tr");

        var air_humidity  = document.createElement("td");
        const airHumidity_text = document.createTextNode(data[i].air_humidity);
        air_humidity.appendChild(airHumidity_text);
        row.appendChild(air_humidity);

        var soil_humidity  = document.createElement("td");
        const soilHumidity_text = document.createTextNode( (Math.round (data[i].soil_humidity * 1000) / 10) );
        soil_humidity.appendChild(soilHumidity_text);
        row.appendChild(soil_humidity);

        var temp  = document.createElement("td");
        const temp_text = document.createTextNode(data[i].temperature);
        temp.appendChild(temp_text);
        row.appendChild(temp);

        var light_level  = document.createElement("td");
        const lightLevel_text = document.createTextNode(Math.round (data[i].light_level * 1000) / 10);
        light_level.appendChild(lightLevel_text);
        row.appendChild(light_level);

        var time  = document.createElement("td");
        const time_text = document.createTextNode(new Date(data[i].timestamp).toLocaleString());
        time.appendChild(time_text);
        row.appendChild(time);

        tbody.appendChild(row);
    }

    table.appendChild(tbody);
}

function setSummary(text){
    document.getElementById("t_soil").innerHTML = text;
    document.getElementById("t_temp").innerHTML = text;
    document.getElementById("t_light").innerHTML = text;
    document.getElementById("t_air").innerHTML = text;
    document.getElementById("t_last").innerHTML = text;
}

fetchData();