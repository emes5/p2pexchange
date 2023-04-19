@extends('user.master',['menu'=>'dashboard'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
        <!-- TradingView Widget BEGIN -->
            <div class="tradingview-widget-container">
            <div class="tradingview-widget-container__widget"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
                    {
                    "symbols": [
                        {
                        "proName": "FOREXCOM:SPXUSD",
                        "title": "S&P 500"
                        },
                        {
                        "proName": "FOREXCOM:NSXUSD",
                        "title": "Nasdaq 100"
                        },
                        {
                        "proName": "FX_IDC:EURUSD",
                        "title": "EUR/USD"
                        },
                        {
                        "proName": "BITSTAMP:BTCUSD",
                        "title": "BTC/USD"
                        },
                        {
                        "proName": "BITSTAMP:ETHUSD",
                        "title": "ETH/USD"
                        }
                    ],
                    "colorTheme": "light",
                    "isTransparent": false,
                    "displayMode": "adaptive",
                    "locale": "en"
                    }
                </script>
            </div>
            <!-- TradingView Widget END -->
        </div>

    </div>
    <div class="row mt-4">
        <div class="col-xl-8 mb-3">
            <div class="card cp-user-custom-card mb-3">
                <div class="card-body">
                    <div class="cp-user-card-header-area">
                        <div class="cp-user-title">
                            <h4>{{__('Trade History')}}</h4>
                        </div>
                    </div>
                    <p class="subtitle">{{__('Current Year')}}</p>
                    <canvas id="tradeChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 mb-3">
            <div class="card cp-user-custom-card mb-3">
                <div class="card-body">
                    <div class="cp-user-card-header-area">
                        <div class="cp-user-title">
                            <h4>{{__('Trading Status')}}</h4>
                        </div>
                    </div>
                    <div id="withdrawal-pie-chart"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 mb-3">
            <div class="card cp-user-custom-card mb-3">
                <div class="card-body">
                    <div class="cp-user-card-header-area">
                        <div class="cp-user-title">
                            <h4>{{__('Last 6 Months Trade History')}}</h4>
                        </div>
                    </div>
                    <div id="last-history-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 mb-3">
            <div class="card cp-user-custom-card mb-3">
                <div class="card-body">
                    <div class="deposite-list-area">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="activity-area">
                                    <div class="activity-top-area">
                                        <div class="row align-items-center">
                                            <div class="col-lg-6">
                                                <div class="cp-user-card-header-area mb-0">
                                                    <div class="cp-user-title">
                                                        <h4>{{__('All Deposit List')}}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="tabe-menu">
                                                    <ul class="nav dashboard-tabs" id="myTab" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="deposit-tab"
                                                               data-toggle="tab"
                                                               onclick="$('#list_title').html('All Deposit List')"
                                                               href="#deposit" role="tab" aria-controls="deposit"
                                                               aria-selected="true"> Deposit</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link profile" id="withdraw-tab"
                                                               data-toggle="tab"
                                                               onclick="$('#list_title').html('All Withdrawal List')"
                                                               href="#withdraw" role="tab" aria-controls="withdraw"
                                                               aria-selected="false"> Withdraw</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="activity-list">
                                                <div class="tab-content">
                                                    <div id="deposit" class="tab-pane fade in active show text-center">

                                                        <div class="cp-user-transaction-history-table table-responsive">
                                                            <table class="table " id="table">
                                                                <thead>
                                                                <tr>
                                                                    <th>{{__('Address')}}</th>
                                                                    <th>{{__('Amount')}}</th>
                                                                    <th>{{__('Transaction Hash')}}</th>
                                                                    <th>{{__('Status')}}</th>
                                                                    <th>{{__('Created At')}}</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                    <div id="withdraw" class="tab-pane fade in  text-center">

                                                        <!-- withdraw_table -->

                                                        <div class="cp-user-transaction-history-table  table-responsive">
                                                            <table class="table" id="withdraw_table">
                                                                <thead>
                                                                <tr>
                                                                    <th>{{__('Address')}}</th>
                                                                    <th>{{__('Amount')}}</th>
                                                                    <th>{{__('Transaction Hash')}}</th>
                                                                    <th>{{__('Status')}}</th>
                                                                    <th>{{__('Created At')}}</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- user chart -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card cp-user-custom-card mb-3">
                <div class="card-body">
                    <div class="cp-user-card-header-area">
                        <div class="cp-user-title">
                            <h4>{{__('Deposit')}}</h4>
                        </div>
                    </div>
                    <p class="subtitle">{{__('Current Year')}}</p>
                    <canvas id="depositChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6 mb-3">
            <div class="card cp-user-custom-card mb-3">
                <div class="card-body">
                    <div class="cp-user-card-header-area">
                        <div class="cp-user-title">
                            <h4>{{__('Withdrawal')}}</h4>
                        </div>
                    </div>
                    <p class="subtitle">{{__('Current Year')}}</p>
                    <canvas id="withdrawalChart"></canvas>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{asset('assets/common/chart/chart.min.js')}}"></script>
    <script src="{{asset('assets/common/chart/apexcharts.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('#withdraw_table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                bLengthChange: true,
                responsive: false,
                ajax: '{{route('transactionHistories')}}?type=withdraw',
                order: [4, 'desc'],
                autoWidth: false,
                language: {
                    paginate: {
                        next: 'Next &#8250;',
                        previous: '&#8249; Previous'
                    }
                },
                columns: [
                    {"data": "address", "orderable": false},
                    {"data": "amount", "orderable": false},
                    {"data": "hashKey", "orderable": false},
                    {"data": "status", "orderable": false},
                    {"data": "created_at", "orderable": false}
                ],
            });
        });

        $(document).ready(function () {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                retrieve: true,
                bLengthChange: true,
                responsive: false,
                ajax: '{{route('transactionHistories')}}?type=deposit',
                order: [4, 'desc'],
                autoWidth: false,
                language: {
                    paginate: {
                        next: 'Next &#8250;',
                        previous: '&#8249; Previous'
                    }
                },
                columns: [
                    {"data": "address", "orderable": false},
                    {"data": "amount", "orderable": false},
                    {"data": "hashKey", "orderable": false},
                    {"data": "status", "orderable": false},
                    {"data": "created_at", "orderable": false}
                ],
            });
        });


        var ctx = document.getElementById('depositChart').getContext("2d")
        var depositChart = new Chart(ctx, {
            type: 'bar',
            yaxisname: "Monthly Deposit",

            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Monthly Deposit",
                    borderColor: "#1cf676",
                    pointBorderColor: "#1cf676",
                    pointBackgroundColor: "#1cf676",
                    pointHoverBackgroundColor: "#1cf676",
                    pointHoverBorderColor: "#D1D1D1",
                    pointBorderWidth: 4,
                    pointHoverRadius: 2,
                    pointHoverBorderWidth: 1,
                    pointRadius: 3,
                    fill: false,
                    borderWidth: 3,
                    data: {!! json_encode($monthly_deposit) !!}
                }]
            },
            options: {
                legend: {
                    position: "bottom",
                    display: true,
                    labels: {
                        fontColor: '#928F8F'
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            fontColor: "#928F8F",
                            fontStyle: "bold",
                            beginAtZero: true,
                            // maxTicksLimit: 5,
                            padding: 20
                        },
                        gridLines: {
                            drawTicks: false,
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            zeroLineColor: "transparent",
                            drawTicks: false,
                            display: false
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "#928F8F",
                            fontStyle: "bold"
                        }
                    }]
                }
            }
        });


        var ctx = document.getElementById('withdrawalChart').getContext("2d");
        var withdrawalChart = new Chart(ctx, {
            type: 'bar',
            yaxisname: "Monthly Withdrawal",

            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Monthly Withdrawal",
                    borderColor: "#f691be",
                    pointBorderColor: "#f691be",
                    pointBackgroundColor: "#f691be",
                    pointHoverBackgroundColor: "#f691be",
                    pointHoverBorderColor: "#D1D1D1",
                    pointBorderWidth: 4,
                    pointHoverRadius: 2,
                    pointHoverBorderWidth: 1,
                    pointRadius: 3,
                    fill: false,
                    borderWidth: 3,
                    data: {!! json_encode($monthly_withdrawal) !!}
                }]
            },
            options: {
                legend: {
                    position: "bottom",
                    display: true,
                    labels: {
                        fontColor: '#928F8F'
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            fontColor: "#928F8F",
                            fontStyle: "bold",
                            beginAtZero: true,
                            // maxTicksLimit: 5,
                            // padding: 20,
                            // max: 1000
                        },
                        gridLines: {
                            drawTicks: false,
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            zeroLineColor: "transparent",
                            drawTicks: true,
                            display: false
                        },
                        ticks: {
                            // padding: 20,
                            fontColor: "#928F8F",
                            fontStyle: "bold",
                            // max: 10000,
                            autoSkip: false
                        }
                    }]
                }
            }
        });


        var ctx = document.getElementById('tradeChart').getContext("2d")
        var tradeChart = new Chart(ctx, {
            type: 'line',
            yaxisname: "Monthly Trade",

            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Monthly Trade",
                    borderColor: "#1cf676",
                    pointBorderColor: "#1cf676",
                    pointBackgroundColor: "#1cf676",
                    pointHoverBackgroundColor: "#1cf676",
                    pointHoverBorderColor: "#D1D1D1",
                    pointBorderWidth: 4,
                    pointHoverRadius: 2,
                    pointHoverBorderWidth: 1,
                    pointRadius: 3,
                    fill: false,
                    borderWidth: 3,
                    data: {!! json_encode($monthly_trade) !!}
                }]
            },
            options: {
                legend: {
                    position: "bottom",
                    display: true,
                    labels: {
                        fontColor: '#928F8F'
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            fontColor: "#928F8F",
                            fontStyle: "bold",
                            beginAtZero: true,
                            // maxTicksLimit: 5,
                            padding: 20
                        },
                        gridLines: {
                            drawTicks: false,
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            zeroLineColor: "transparent",
                            drawTicks: false,
                            display: false
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "#928F8F",
                            fontStyle: "bold"
                        }
                    }]
                }
            }
        });


        var options = {
            series: ['{{$trade_success_status}}'],
            chart: {
                height: 350,
                type: 'radialBar',
            },
            fill: {
                colors: ['#FE8F28'],
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '60%',
                    },
                    track: {
                        opacity: 1,
                        background: '#FC541F'
                    }
                },
            },
            labels: ['Success Trade'],
        };

        var chart = new ApexCharts(document.querySelector("#withdrawal-pie-chart"), options);
        chart.render();


        var options = {
            series: [{
                name: "Buy",
                data: {!! json_encode($six_buys) !!}
            }, {
                name: "Sell",
                data: {!! json_encode($six_sells) !!}
            }],
            chart: {
                type: 'bar',
                height: 430
            },
            colors: ["#4337FC", "#FFB127"],
            plotOptions: {
                bar: {
                    horizontal: true,
                    dataLabels: {
                        position: 'top',
                    },
                }
            },
            dataLabels: {
                enabled: true,
                offsetX: -6,
                style: {
                    fontSize: '12px',
                    colors: ['#fff']
                }
            },
            stroke: {
                show: true,
                width: 1,
                colors: ['#fff']
            },
            xaxis: {
                categories: {!! json_encode($last_six_month) !!},
            },
        };

        var chart = new ApexCharts(document.querySelector("#last-history-chart"), options);
        chart.render();
    </script>
@endsection
