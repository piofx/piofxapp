$(document).ready(function () {
    // auto fill phone number column in create form if exixts
    let phone = document.getElementById("phone_number_input");

    if (phone) {
        document.getElementById("phone_number_output").value = phone.value;
    }

    // Initialize the functions as soon as page loads
    customer_chart();
    credit_redeem_chart();
    revenue_chart();

    // Add d-block class to default credits element on init
    let pathname = window.location.pathname;
    if (pathname.indexOf("create") != -1) {
        $(".default").addClass("d-block");
    }
    visible_sections();
});

// Change visible sections in settings page based on mode
function visible_sections() {
    if (document.getElementById("mode")) {
        let mode = document.getElementById("mode").value;

        if (mode == "generic") {
            $(".default").removeClass("d-block");
            $(".range_percent").removeClass("d-block");
            $(".range_fixed").removeClass("d-block");
        } else if (mode == "range_percent") {
            $(".range_percent").addClass("d-block");
            $(".default").removeClass("d-block");
            $(".generic").removeClass("d-block");
            $(".range_fixed").removeClass("d-block");
        } else if (mode == "range_fixed") {
            $(".range_fixed").addClass("d-block");
            $(".default").removeClass("d-block");
            $(".generic").removeClass("d-block");
            $(".range_percent").removeClass("d-block");
        } else if (mode == "default") {
            $(".default").addClass("d-block");
            $(".generic").removeClass("d-block");
            $(".range_percent").removeClass("d-block");
            $(".range_fixed").removeClass("d-block");
        }
    }
}

// Chart for Customers
function customer_chart() {
    let json_data = document.getElementById("customer_chart_data");

    if (json_data) {
        json_data = json_data.getAttribute("data-value");

        let customer_chart_data = JSON.parse(json_data);

        const apexChart = "#customers_chart";
        var options = {
            series: [
                {
                    name: "New Customers",
                    data: Object.values(customer_chart_data),
                },
            ],
            chart: {
                height: 350,
                type: "area",
                toolbar: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: "smooth",
            },
            xaxis: {
                categories: Object.keys(customer_chart_data),
            },
            colors: [primary, success],
        };

        var chart = new ApexCharts(document.querySelector(apexChart), options);
        chart.render();
    }
}

// Chart for revenue
function revenue_chart() {
    let json_data = document.getElementById("revenue_chart_data");

    if (json_data) {
        json_data = json_data.getAttribute("data-value");

        let revenue_chart_data = JSON.parse(json_data);

        // customers_chart_data = sortObject(revenue_chart_data);

        const apexChart = "#revenue_chart";
        var options = {
            series: [
                {
                    name: "Total Revenue",
                    data: Object.values(revenue_chart_data),
                },
            ],
            chart: {
                height: 350,
                type: "area",
                toolbar: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: "smooth",
            },
            xaxis: {
                categories: Object.keys(revenue_chart_data),
            },
            colors: [primary, success],
        };

        var chart = new ApexCharts(document.querySelector(apexChart), options);
        chart.render();
    }
}

// Chart for credits and redeem points
function credit_redeem_chart() {
    let rewards_data = document.getElementById("rewards_data");

    if (rewards_data) {
        rewards_data = rewards_data.getAttribute("data-value");

        let rewards = JSON.parse(rewards_data);

        let credits = [];
        let redeem = [];

        for (let i in rewards) {
            credits.push(rewards[i]["credits"]);
            redeem.push(rewards[i]["redeem"]);
        }

        const apexChart = "#rewards_chart";
        var options = {
            series: [
                {
                    name: "Credit",
                    data: credits,
                },
                {
                    name: "Redeem",
                    data: redeem,
                },
            ],
            chart: {
                type: "bar",
                height: 350,
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "55%",
                    endingShape: "rounded",
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                show: true,
                width: 2,
                colors: ["transparent"],
            },
            xaxis: {
                categories: Object.keys(rewards),
            },
            yaxis: {
                title: {
                    text: "Points",
                },
            },
            fill: {
                opacity: 1,
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " points";
                    },
                },
            },
            colors: [primary, success, warning],
        };

        var chart = new ApexCharts(document.querySelector(apexChart), options);
        chart.render();
    }
}

// Auto refresh page when filter changes in dashboard page
function filter_charts_result() {
    document.getElementById("filter_form").submit();
}
