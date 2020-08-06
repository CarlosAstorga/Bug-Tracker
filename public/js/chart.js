function initChart(userName) {
    const user = userName;
    const dashboard = document.getElementById("dashboard");

    const types = ["horizontalBar", "pie", "doughnut", "bar"];

    fetch("chart")
        .then(response => response.json())
        .then(response => {
            setData(response);
        });

    function setData(response) {
        if (response.total == 0) {
            return (dashboard.innerHTML = `<div class="col-md-12 text-center"><p class="text-muted" style="font-size: 3rem">Bienvenido <strong>${user}</strong>!</p></div>`);
        }

        let index = 0;
        for (let type in response.chart) {
            const data = {
                labels: [],
                datasets: [
                    {
                        label: response.chart[type].title,
                        backgroundColor: [
                            "#ff6f69",
                            "#ffcc5c",
                            "#ffeead",
                            "#96ceb4",
                            "#f2ae72"
                        ],
                        data: []
                    }
                ]
            };
            const option = {
                legend: {
                    position: "bottom"
                }
            };

            response.chart[type]["data"].forEach(item => {
                data.labels.push(
                    item[type].title != undefined
                        ? item[type].title
                        : item[type].name
                );
                data.datasets[0].data.push(item.total);
            });

            const div = document.createElement("div");
            div.className = "col-md-6";
            div.innerHTML = `
                <div class="card mb-3">
                        <div class="card-header text-center bg-dark text-white">${response.chart[type]["title"]}</div>
                        <div class="card-body">
                            <canvas id="${type}"></canvas>
                        </div>
                    </div>
                    `;
            dashboard.appendChild(div);
            const canvas = document.getElementById(type).getContext("2d");
            createChart(canvas, data, option, types[index]);
            index++;
        }
    }

    function createChart(node, data = {}, options = {}, type = "pie") {
        new Chart(node, {
            type: type,
            data: data,
            options: options
        });
    }
}
