$(document).ready(function () {
    let KTAppSettings = initSettings();
    adminPageChart(KTAppSettings);
    mainStatistics();
});

function adminPageChart(KTAppSettings) {
    var element = document.getElementById("admin_page_chart");

    if (!element) {
        return;
    }

    var options = {
        series: [
            {
                name: "Net Profit",
                data: [10, 15, 18, 14],
            },
            {
                name: "Revenue",
                data: [8, 13, 16, 12],
            },
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
            opacity: 0.25,
        },
        xaxis: {
            categories: ["Feb", "Mar", "Apr", "May"],
        },
        yaxis: {
            min: 0,
            max: 20,
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
                show: false,
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

    var chart = new ApexCharts(element, options);
    chart.render();
}

function mainStatistics() {
    const apexChart = "#statistics";
    var options = {
        series: [
            {
                name: "Total Clicks",
                data: [50, 40, 28, 51, 42, 109, 100],
            },
            {
                name: "Total Impressions",
                data: [11, 32, 45, 32, 34, 52, 41],
            },
            {
                name: "Avg CTR",
                data: [11, 32, 45, 32, 34, 52, 41],
            },
            {
                name: "Avg Position",
                data: [11, 32, 45, 32, 34, 52, 41],
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
            categories: [
                "2018-09-19T00:00:00.000Z",
                "2018-09-19T01:30:00.000Z",
                "2018-09-19T02:30:00.000Z",
                "2018-09-19T03:30:00.000Z",
                "2018-09-19T04:30:00.000Z",
                "2018-09-19T05:30:00.000Z",
                "2018-09-19T06:30:00.000Z",
            ],
        },
        tooltip: {
            x: {
                format: "dd/MM/yy HH:mm",
            },
        },
        colors: [primary, success],
    };

    var chart = new ApexCharts(document.querySelector(apexChart), options);
    chart.render();
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
