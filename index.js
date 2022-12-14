function fetchData() {
  disableButtons(true);
  setSummary("-");
  const limit = document.getElementById("limit").value;
  const offset = document.getElementById("offset").value;
  fetch("get_data.php?limit="+limit+"&offset="+offset, {
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
      for (const el of document.getElementsByTagName("tbody")) { el.remove(); }
      if (data.length == 0){
          setSummary("No data.");
      }else{
          generateTable(data);
      }
      let timer = 2;
      setTimeout(()=>{
        disableButtons(false);
      }, 1000);
    });
}


function restart(){
    disableButtons(true);

    fetch("manual_restart.php", {
    method: "get",
   
  })
    .then(function (response) {
      if (response.status >= 200 && response.status < 300) {
        return response.text();
      }
      throw new Error(response.statusText);
    })
    .then(function (response) {
        let timer = 20;
        const interval = setInterval(()=>{
            if (timer<=0){
                clearInterval(interval);
                fetchData();
            }else{
                setSummary("System restarting... "+timer);
                timer--;
            }
        }, 1000);
    });
}

function manualUpdate(){
    disableButtons(true);

    fetch("manual_update.php", {
    method: "get",
  })
    .then(function (response) {
      if (response.status >= 200 && response.status < 300) {
        return response.text();
      }
      throw new Error(response.statusText);
    })
    .then(function (response) {
      let timer = 5;
      const interval = setInterval(()=>{
          if (timer<=0){
              clearInterval(interval);
              fetchData();
          }else{
              setSummary("Refreshing data... "+timer);
              timer--;
          }
      }, 1000);
    });
}

function manualWater(){
    disableButtons(true);

    fetch("manual_water.php", {
        method: "get",
    })
        .then(function (response) {
            if (response.status >= 200 && response.status < 300) {
                return response.text();
            }
            throw new Error(response.statusText);
        })
        .then(function (response) {
            let timer = 20;
            const interval = setInterval(()=>{
                if (timer<=0){
                    clearInterval(interval);
                    fetchData();
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
    document.getElementById("t_temp").innerHTML = data[0].temperature + "??C";
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

function disableButtons(state){
    const collection = document.getElementsByTagName("button");
    for (const el of collection) {
        el.disabled = state;
    }
}

fetchData();