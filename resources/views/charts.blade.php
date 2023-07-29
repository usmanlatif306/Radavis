<script type="text/javascript">
    let fromMonth = null;
    let fromYear = null;
    if (window.location.href.indexOf('#') != -1) {
        url = window.location.href.substr(0, window.location.href.indexOf('#'))
    } else {
        url = window.location.href;
    }

    let query = url.split("?")[1];
    if (query) {
        let params = new URLSearchParams(query);
        fromMonth = params.get('from_month');
        fromYear = params.get('from_year');
    }

    $.ajax({
        url: "{{ route('home.ajax') }}",
        method: 'GET',
        data: {
            from_month: fromMonth,
            from_year: fromYear
        },
        dataType: 'JSON',
        success: function(response) {
            // console.log(response);

            drawTonShippedGrapgh(response.loads, response.load_dates);
            drawCommissionGrapgh(response.commissions, response.commissions_dates);
            drawApexChart('scoreboard', response.salesmans, response.salesman_scores);
            drawApexChart('topProducts', response.top_products, response.top_products_scores);


        },
        error: function(response) {}
    });


    function drawTonShippedGrapgh(loads, load_dates) {
        var KTCardWidget12 = (function() {
            var e = {
                    self: null,
                    rendered: !1
                },
                t = function(e) {
                    var t = document.getElementById("kt_card_widget_12_chart");
                    if (t) {
                        var a = parseInt(KTUtil.css(t, "height")),
                            l = KTUtil.getCssVariableValue("--bs-border-dashed-color"),
                            r = KTUtil.getCssVariableValue("--bs-gray-800"),
                            o = {
                                series: [{
                                    name: "Tons",
                                    data: loads,
                                }, ],
                                chart: {
                                    fontFamily: "inherit",
                                    type: "area",
                                    height: a,
                                    toolbar: {
                                        show: !1
                                    },
                                },
                                legend: {
                                    show: !1
                                },
                                dataLabels: {
                                    enabled: !1
                                },
                                fill: {
                                    type: "solid",
                                    opacity: 0
                                },
                                stroke: {
                                    curve: "smooth",
                                    show: !0,
                                    width: 2,
                                    colors: [r],
                                },
                                xaxis: {
                                    categories: load_dates,
                                    axisBorder: {
                                        show: !1
                                    },
                                    axisTicks: {
                                        show: !1
                                    },
                                    labels: {
                                        show: !1
                                    },
                                    crosshairs: {
                                        position: "front",
                                        stroke: {
                                            color: r,
                                            width: 1,
                                            dashArray: 3
                                        },
                                    },
                                    tooltip: {
                                        enabled: !0,
                                        formatter: void 0,
                                        offsetY: 0,
                                        style: {
                                            fontSize: "12px"
                                        },
                                    },
                                },
                                yaxis: {
                                    labels: {
                                        show: !1
                                    }
                                },
                                states: {
                                    normal: {
                                        filter: {
                                            type: "none",
                                            value: 0
                                        }
                                    },
                                    hover: {
                                        filter: {
                                            type: "none",
                                            value: 0
                                        }
                                    },
                                    active: {
                                        allowMultipleDataPointsSelection: !1,
                                        filter: {
                                            type: "none",
                                            value: 0
                                        },
                                    },
                                },
                                tooltip: {
                                    style: {
                                        fontSize: "12px"
                                    },
                                    // x: {
                                    //     formatter: function(e) {
                                    //         return "March " + e;
                                    //     },
                                    // },
                                    y: {
                                        formatter: function(e) {
                                            return e + " Tons";
                                        },
                                    },
                                },
                                colors: [KTUtil.getCssVariableValue("--bs-success")],
                                grid: {
                                    borderColor: l,
                                    strokeDashArray: 4,
                                    padding: {
                                        top: 0,
                                        right: -20,
                                        bottom: -20,
                                        left: -20,
                                    },
                                    yaxis: {
                                        lines: {
                                            show: !0
                                        }
                                    },
                                },
                                markers: {
                                    strokeColor: r,
                                    strokeWidth: 2
                                },
                            };
                        (e.self = new ApexCharts(t, o)),
                        e.self.render(), (e.rendered = !0);
                        // setTimeout(function() {
                        //     e.self.render(), (e.rendered = !0);
                        // }, 200);
                    }
                };
            return {
                init: function() {
                    t(e),
                        KTThemeMode.on("kt.thememode.change", function() {
                            e.rendered && e.self.destroy(), t(e);
                        });
                },
            };
        })();
        "undefined" != typeof module && (module.exports = KTCardWidget12),
            KTUtil.onDOMContentLoaded(function() {
                KTCardWidget12.init();
            });

    }

    function drawCommissionGrapgh(commissions, commissions_dates) {

        var KTCardWidget13 = (function() {
            var e = {
                    self: null,
                    rendered: !1
                },
                t = function(e) {
                    var t = document.getElementById("kt_card_widget_13_chart");
                    if (t) {
                        var a = parseInt(KTUtil.css(t, "height")),
                            l = KTUtil.getCssVariableValue("--bs-border-dashed-color"),
                            r = KTUtil.getCssVariableValue("--bs-gray-800"),
                            o = {
                                series: [{
                                    name: "Commission",
                                    data: commissions,
                                }, ],
                                chart: {
                                    fontFamily: "inherit",
                                    type: "area",
                                    height: a,
                                    toolbar: {
                                        show: !1
                                    },
                                },
                                legend: {
                                    show: !1
                                },
                                dataLabels: {
                                    enabled: !1
                                },
                                fill: {
                                    type: "solid",
                                    opacity: 0
                                },
                                stroke: {
                                    curve: "smooth",
                                    show: !0,
                                    width: 2,
                                    colors: [r],
                                },
                                xaxis: {
                                    categories: commissions_dates,
                                    axisBorder: {
                                        show: !1
                                    },
                                    axisTicks: {
                                        show: !1
                                    },
                                    labels: {
                                        show: !1
                                    },
                                    crosshairs: {
                                        position: "front",
                                        stroke: {
                                            color: r,
                                            width: 1,
                                            dashArray: 3
                                        },
                                    },
                                    tooltip: {
                                        enabled: !0,
                                        formatter: void 0,
                                        offsetY: 0,
                                        style: {
                                            fontSize: "12px"
                                        },
                                    },
                                },
                                yaxis: {
                                    labels: {
                                        show: !1
                                    }
                                },
                                states: {
                                    normal: {
                                        filter: {
                                            type: "none",
                                            value: 0
                                        }
                                    },
                                    hover: {
                                        filter: {
                                            type: "none",
                                            value: 0
                                        }
                                    },
                                    active: {
                                        allowMultipleDataPointsSelection: !1,
                                        filter: {
                                            type: "none",
                                            value: 0
                                        },
                                    },
                                },
                                tooltip: {
                                    style: {
                                        fontSize: "12px"
                                    },
                                    // x: {
                                    //     formatter: function(e) {
                                    //         return e;
                                    //     },
                                    // },
                                    y: {
                                        formatter: function(e) {
                                            return "$" + e;
                                        },
                                    },
                                },
                                colors: [KTUtil.getCssVariableValue("--bs-success")],
                                grid: {
                                    borderColor: l,
                                    strokeDashArray: 4,
                                    padding: {
                                        top: 0,
                                        right: -20,
                                        bottom: -20,
                                        left: -20,
                                    },
                                    yaxis: {
                                        lines: {
                                            show: !0
                                        }
                                    },
                                },
                                markers: {
                                    strokeColor: r,
                                    strokeWidth: 2
                                },
                            };
                        (e.self = new ApexCharts(t, o)),
                        e.self.render(), (e.rendered = !0);
                        // setTimeout(function() {
                        //     e.self.render(), (e.rendered = !0);
                        // }, 200);
                    }
                };
            return {
                init: function() {
                    t(e),
                        KTThemeMode.on("kt.thememode.change", function() {
                            e.rendered && e.self.destroy(), t(e);
                        });
                },
            };
        })();
        "undefined" != typeof module && (module.exports = KTCardWidget13),
            KTUtil.onDOMContentLoaded(function() {
                KTCardWidget13.init();
            });
    }

    function drawApexChart(id, top_products, top_products_scores) {
        var element = document.getElementById(id);
        var height = parseInt(KTUtil.css(element, 'height'));
        var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
        var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');
        var baseColor = 'rgba(62, 151, 255, 0.85)';
        var secondaryColor = KTUtil.getCssVariableValue('--kt-gray-300');

        var options = {
            series: [{
                name: 'Est. Tons Shipped',
                data: top_products_scores
            }],
            chart: {
                fontFamily: 'inherit',
                type: 'bar',
                height: height,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: ['30%'],
                    endingShape: 'rounded'
                },
            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: top_products,
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '12px'
                    }
                }
            },
            fill: {
                opacity: 1
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: '12px'
                },
                y: {
                    formatter: function(val) {
                        return val + ' Tons'
                    }
                }
            },
            colors: [baseColor, secondaryColor],
            grid: {
                borderColor: borderColor,
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            }
        };

        var chart = new ApexCharts(element, options);
        chart.render();
    }
</script>
