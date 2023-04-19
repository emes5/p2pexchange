<section class="market-trend-area section section-bg-two" id="trend">
    <div class="container">
        <div class="section-title text-center mb-55">
            <h2 class="title">{{$section_parent->section_title}}</h2>
            <span class="devider"></span>
            <p class="sub-title">{{$section_parent->section_description}}</p>
        </div>
        <div class="table-responsive">
            <table class="table table-striped cryptocurrencies-table" id="cryptocurrencies-table">
                <thead>
                <tr>
                    <th scope="col" style="width: 25%">Name</th>
                    <th scope="col" style="width: 25%">Last price</th>
                    <th scope="col" style="width: 25%">24h change</th>
                    <th scope="col" style="width: 25%">markets</th>
                </tr>
                </thead>
                <tbody id="table_body">
                </tbody>
            </table>
        </div>
        <div class="view-more-area mt-40 text-center">
            <a href="#" class="primary-btn-two view-more">view more markets</a>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    "use strict";
    jQuery(document).ready(function () {

        var host = '{!! $settings['host_chart'] ?? '' !!}';
        var key = '{!! $settings['key_chart'] ?? '' !!}';
        var today_second = new Date().getTime() / 1000;
        var from_second = (new Date().getTime() / 1000) - 604800;
        call_api_for_live_data(10);
        function call_api_for_live_data(per_page) {

            const settings = {
                "async": true,
                "crossDomain": true,
                "url": "https://coingecko.p.rapidapi.com/coins/markets?vs_currency=usd&page=1&per_page="+per_page+"&order=market_cap_desc",
                "method": "GET",
                "headers": {
                    "x-rapidapi-host": host,
                    "x-rapidapi-key": key
                }
            };

            $.ajax(settings).done(function (response) {
                var html = '';
                $.each(response, function (i, data) {
                    html = `<tr>
                    <td>
                        <a href="javascript::void(0)" class="coin-info">
                            <img class="coin-icon" src="${data.image}" alt="bitcoin" />
                            <h4 class="coin-name">${data.symbol} <span>${data.name}</span></h4>
                        </a>
                    </td>
                    <td>${data.current_price}</td>
                    <td>${data.price_change_percentage_24h}%</td>
                    <td><div class="price-graph"><div id="${data.symbol}" class="${data.symbol}"></div></div></td>
                </tr>`;
                    $('#table_body').append(html);
                    var options = {
                        series: [{
                            data: []
                        }],
                        chart: {
                            type: 'area',
                            height: '85px',
                            id: data.symbol,
                            toolbar: {
                                show: false,
                            },

                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            colors: (0 < data.price_change_percentage_24h) ? ["#288E50"] : ["#E07B6D"],
                            width: .5,
                            dashArray: 0,
                        },
                        fill: {
                            colors: (0 < data.price_change_percentage_24h) ? '#BAFDE1' : '#FCB0A7',
                            type: 'gradient',
                            gradient: {
                                shade: 'light',
                                gradientToColors: (0 < data.price_change_percentage_24h) ? ["#A0F4AE"] : ["#F7DDC1"],
                                type: "horizontal",
                                shadeIntensity: 0.5,
                                inverseColors: true,
                                opacityFrom: .6,
                                opacityTo: .8,
                                stops: [0, 50, 100],
                            },
                        },
                        tooltip: {
                            custom: function ({series, seriesIndex, dataPointIndex, w}) {
                                return '<div class="arrow_box">' +
                                    '<span>' + series[seriesIndex][dataPointIndex] + '</span>' +
                                    '</div>'
                            }
                        },
                        grid: {
                            show: false,
                            padding: {
                                top: 0,
                                bottom: 0,
                            },
                        },
                        noData: {
                            text: "Loading...",
                            align: 'center',
                            verticalAlign: 'middle',
                            offsetX: 0,
                            offsetY: 0,
                            style: {
                                color: "#000000",
                                fontSize: '14px',
                                fontFamily: "Helvetica"
                            }
                        },
                        xaxis: {
                            labels: {
                                show: false,
                            },
                            axisBorder: {
                                show: false,
                            },
                            axisTicks: {
                                show: false,
                            },
                            tooltip: {
                                enabled: false,
                            },
                        },
                        yaxis: {
                            show: false,
                            labels: {
                                show: false,
                            },
                            axisBorder: {
                                show: false,
                            },
                            axisTicks: {
                                show: false,
                            },
                            tooltip: {
                                enabled: false,
                            },
                        }
                    };
                    var charSymble = '.' + data.symbol;
                    var liveCart = document.querySelector(charSymble);

                    if(jQuery(liveCart).length){
                        var chart = new ApexCharts(liveCart, options);
                        chart.render();
                    }

                    const settings2 = {
                        "async": true,
                        "crossDomain": true,
                        "url": "https://coingecko.p.rapidapi.com/coins/" + data.id + "/market_chart/range?from=1638357091&vs_currency=usd&to=1638529891",
                        "method": "GET",
                        "headers": {
                            "x-rapidapi-host": host,
                            "x-rapidapi-key": key
                        }
                    };
                    jQuery.ajax(settings2).done(function (response) {
                        try {
                            ApexCharts.exec(data.symbol, 'updateSeries', [{
                                data: response.market_caps
                            }]);
                        } catch (e) {
                        }
                    });
                });
            });
        }


        $(document).on('click','.view-more',function (e){
            e.preventDefault();
            call_api_for_live_data(400);
            $(this).html('Show Less Markets');
            $(this).removeClass('view-more');
            $(this).addClass('show-less');
        });
        $(document).on('click','.show-less',function (e){
            e.preventDefault();
            call_api_for_live_data(10);
            $(this).html('View More Markets');
            $(this).removeClass('show-less');
            $(this).addClass('view-more');
        });


    });


</script>
