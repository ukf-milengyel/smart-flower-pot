fetch("http://localhost/project/get_data.php", {
  method: "get",
  // may be some code of fetching comes here
})
  .then(function (response) {
    if (response.status >= 200 && response.status < 300) {
      return response.text();
    }
    throw new Error(response.statusText);
  })
  .then(function (response) {
    var data = JSON.parse(response);
    parseData(data);
  });

function parseData(data) {
  var airHumidity = [];
  var soilHumidity = [];
  var temperature = [];
  var lightLevel = [];

  data.forEach((element) => {
    const date = element.timestamp;
    var air = {
      x: date,
      y: element.air_humidity,
      type: element.pump,
    };
    var soil = {
      x: date,
      y: element.soil_humidity,
      type: element.pump,
    };
    var temp = {
      x: date,
      y: element.temperature,
      type: element.pump,
    };
    var light = {
      x: date,
      y: element.light_level,
      type: element.pump,
    };
    airHumidity.push(air);
    soilHumidity.push(soil);
    temperature.push(temp);
    lightLevel.push(light);
  });

  drawGraph_AirHumidity(airHumidity.reverse());
  drawGraph_SoilHumidity(soilHumidity.reverse());
  drawGraph_temperature(temperature.reverse());
  drawGraph_LightLevel(lightLevel.reverse());
}

function drawGraph_AirHumidity(XY) {
  var labels = [];
  var database = [];
  XY.forEach((element) => {
    labels.push(element.x);
    database.push(element.y);
  });

  const data = {
    labels: XY.map((a) => a.x),
    datasets: [
      {
        label: "Air humidity (%)",
        data: XY.map((a) => a.y),
      },
    ],
  };

  const config = {
    type: "line",
    data: data,
    options: {
      pointRadius: 1,
      pointBackgroundColor: 'blue',
      cubicInterpolationMode: 'monotone',
      spanGaps: true,
      scales: {
        x: {
          type: 'time',
          time: {
            unit: 'day',
          }
        }
      },
    },
  };

  new Chart(document.getElementById("airHumidity"), config);
}

function drawGraph_SoilHumidity(XY) {
  var labels = [];
  var database = [];
  XY.forEach((element) => {
    labels.push(element.x);
    database.push(element.y);
  });

  const data = {
    labels: XY.map((a) => a.x),
    datasets: [
      {
        label: "Soil humidity (%)",
        data: XY.map((a) => a.y),
      },
    ],
  };

  const config = {
    type: "line",
    data: data,
    options: {
      pointRadius: 1,
      pointBackgroundColor: 'blue',
      cubicInterpolationMode: 'monotone',
      spanGaps: true,
      scales: {
        x: {
          type: 'time',
          time: {
            unit: 'day',
          }
        }
      }
    },
  };

  new Chart(document.getElementById("soilHumidity"), config);
}

function drawGraph_temperature(XY) {
  var labels = [];
  var database = [];
  XY.forEach((element) => {
    labels.push(element.x);
    database.push(element.y);
  });

  const data = {
    labels: XY.map((a) => a.x),
    datasets: [
      {
        label: "Temperature (°C)",
        data: XY.map((a) => a.y),
      },
    ],
  };

  const config = {
    type: "line",
    data: data,
    options: {
      pointRadius: 1,
      pointBackgroundColor: 'blue',
      cubicInterpolationMode: 'monotone',
      spanGaps: true,
      scales: {
        x: {
          type: 'time',
          time: {
            unit: 'day',
          }
        }
      }
    },
  };

  new Chart(document.getElementById("temperature"), config);
}

function drawGraph_LightLevel(XY) {
  var labels = [];
  var database = [];
  XY.forEach((element) => {
    labels.push(element.x);
    database.push(element.y);
  });

  const data = {
    labels: XY.map((a) => a.x),
    datasets: [
      {
        label: "Light level (%)",
        data: XY.map((a) => a.y),
      },
    ],
  };

  const config = {
    type: "line",
    data: data,
    options: {
      pointRadius: 1,
      pointBackgroundColor: 'blue',
      cubicInterpolationMode: 'monotone',
      spanGaps: true,
      scales: {
        x: {
          type: 'time',
          time: {
            unit: 'day',
          }
        }
      }
    },
  };

  new Chart(document.getElementById("lightLevel"), config);
}
