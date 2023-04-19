const labels = ['January','February','March','April','May','June', 'Julay'];
const data = {
    labels: labels,
    datasets: [{
      backgroundColor: '#FF4624',
      borderColor: '#FF4624',
      borderWidth: 2,
      data: [0, 10, 5, 2, 20, 30, 20],
      tension: .4,
      fill: false,
      pointBorderColor: 'transparent',
      pointBorderWidth: 0,
      pointHitRadius: 0,
      pointBackgroundColor: "transparent",
    }]
};
const config = {
    type: 'line',
    data: data,
    backgroundColor: false,
    options: {
        responsive: true,
        point: {
            pointBorderColor: "blue",
        },
        plugins: {
            legend: {
                display: false,
            },
            tooltip: {
                enabled: false,
            },
        },
        scales: {
            x: {
                grid: {
                  display: false,
                  drawBorder: false,
                },
                ticks: {
                    display: false,
                }
            },
            y: {
                grid: {
                  display: false,
                  drawBorder: false,
                },
                ticks: {
                    display: false,
                }
            },
        }
    },
};
const marketsChart = new Chart(
    document.getElementById('marketsChart'),
    config,
);
const marketsChart1 = new Chart(
    document.getElementById('marketsChart1'),
    config,
);
const marketsChart2 = new Chart(
    document.getElementById('marketsChart2'),
    config,
);
const marketsChart3 = new Chart(
    document.getElementById('marketsChart3'),
    config,
);
const marketsChart4 = new Chart(
    document.getElementById('marketsChart4'),
    config,
);
