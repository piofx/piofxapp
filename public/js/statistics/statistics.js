$(document).ready(function () {
    let KTAppSettings = initSettings();
    adminPageChart(KTAppSettings);

    let data = document.getElementById("statChartData");
    totalClicksChart(data);
    avgPositionChart(data);
});

function adminPageChart(KTAppSettings) {
    var chart = document.getElementById("admin_page_chart");
    if (!chart) {
        return;
    } else {
        let chart_data = JSON.parse(chart.getAttribute("data-value"));

        if (chart_data) {
            let clicks_max = Math.max.apply(Math, chart_data["clicks"]);

            var options = {
                series: [
                    {
                        name: "Clicks",
                        data: Object.values(chart_data["clicks"]),
                    }
                ],
                chart: {
                    type: "bar",
                    height: 75,
                    zoom: {
                        enabled: false,
                    },
                    sparkline: {
                        enabled: true,
                    },
                    padding: {
                        left: 20,
                        right: 20,
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: ["25%"],
                        endingShape: "rounded",
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    type: ["solid", "gradient"],
                },
                xaxis: {
                    categories: Object.values(chart_data["dates"]),
                },
                yaxis: {
                    min: 0,
                    max: clicks_max,
                },
                states: {
                    normal: {
                        filter: {
                            type: "none",
                            value: 0,
                        },
                    },
                    hover: {
                        filter: {
                            type: "none",
                            value: 0,
                        },
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: "none",
                            value: 0,
                        },
                    },
                },
                tooltip: {
                    style: {
                        fontSize: "12px",
                        fontFamily: KTAppSettings["font-family"],
                    },
                    fixed: {
                        enabled: false,
                    },
                    x: {
                        format: "dd/MM/yy",
                    },
                    y: {
                        title: {
                            formatter: function (val) {
                                return val + "";
                            },
                        },
                    },
                    marker: {
                        show: false,
                    },
                },
                colors: ["#ffffff", "#ffffff"],
            };

            var chart = new ApexCharts(chart, options);
            chart.render();
        }
    }
}

function totalClicksChart(data) {
    let total_clicks = document.getElementById('total_clicks_chart');
    if (!total_clicks) {
        return;
    } else {
        let chart_data = JSON.parse(data.getAttribute("data-value"));

        if (chart_data) {
            const apexChart = "#total_clicks_chart";
            var options = {
                series: [
                    {
                        name: "Total Clicks",
                        data: Object.values(chart_data["clicks"]),
                    },
                ],
                chart: {
                    height: 350,
                    type: "area",
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    curve: "smooth",
                },
                xaxis: {
                    type: "datetime",
                    categories: Object.values(chart_data["dates"]),
                },
                tooltip: {
                    x: {
                        format: "dd/MM/yy",
                    },
                },
                colors: [primary, success],
            };

            var chart = new ApexCharts(
                document.querySelector(apexChart),
                options
            );
            chart.render();
        }
    }
}

function avgPositionChart(data){
    let avg_position = document.getElementById('avg_position_chart');
    if (!avg_position) {
        return;
    } else {
        let chart_data = JSON.parse(data.getAttribute("data-value"));

        if (chart_data) {
            const apexChart = "#avg_position_chart";
            var options = {
                series: [
                    {
                        name: "Average Position",
                        data: Object.values(chart_data["position"]),
                    },
                ],
                chart: {
                    height: 350,
                    type: "area",
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    curve: "smooth",
                },
                xaxis: {
                    type: "datetime",
                    categories: Object.values(chart_data["dates"]),
                },
                tooltip: {
                    x: {
                        format: "dd/MM/yy",
                    },
                },
                colors: [primary, success],
            };

            var chart = new ApexCharts(
                document.querySelector(apexChart),
                options
            );
            chart.render();
        }
    }
}

function initSettings() {
    var KTAppSettings = {
        breakpoints: { sm: 576, md: 768, lg: 992, xl: 1200, xxl: 1200 },
        colors: {
            theme: {
                base: {
                    white: "#ffffff",
                    primary: "#6993FF",
                    secondary: "#E5EAEE",
                    success: "#1BC5BD",
                    info: "#8950FC",
                    warning: "#FFA800",
                    danger: "#F64E60",
                    light: "#F3F6F9",
                    dark: "#212121",
                },
                light: {
                    white: "#ffffff",
                    primary: "#E1E9FF",
                    secondary: "#ECF0F3",
                    success: "#C9F7F5",
                    info: "#EEE5FF",
                    warning: "#FFF4DE",
                    danger: "#FFE2E5",
                    light: "#F3F6F9",
                    dark: "#D6D6E0",
                },
                inverse: {
                    white: "#ffffff",
                    primary: "#ffffff",
                    secondary: "#212121",
                    success: "#ffffff",
                    info: "#ffffff",
                    warning: "#ffffff",
                    danger: "#ffffff",
                    light: "#464E5F",
                    dark: "#ffffff",
                },
            },
            gray: {
                "gray-100": "#F3F6F9",
                "gray-200": "#ECF0F3",
                "gray-300": "#E5EAEE",
                "gray-400": "#D6D6E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#80808F",
                "gray-700": "#464E5F",
                "gray-800": "#1B283F",
                "gray-900": "#212121",
            },
        },
        "font-family": "Poppins",
    };
    return KTAppSettings;
}
