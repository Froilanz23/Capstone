@extends('layouts.admin')
@section('content')
<div class="main-content-inner">

    <div class="main-content-wrap">
        <!-- Dashboard Overview -->
        <div class="tf-section-2 mb-30">
            <div class="flex gap20 flex-wrap-mobile">
                
                <!-- Left Section -->
                <div class="w-half">

                    <!-- Total Orders -->
                    <div class="wg-chart-default mb-20">
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Total Orders</div>
                                    <h4>{{ $dashboardDatas[0]->Total ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Amount -->
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon">₱</i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Total Amount</div>
                                    <h4>₱{{ number_format($TotalAmount ?? 0, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Orders -->
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Pending Orders</div>
                                    <h4>{{ $dashboardDatas[0]->TotalOrdered ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Orders Amount -->
                    <div class="wg-chart-default">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon">₱</i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Pending Orders Amount</div>
                                    <h4>₱{{ number_format($dashboardDatas[0]->TotalOrderedAmount ?? 0, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="w-half">

                    <!-- Delivered Orders -->
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Delivered Orders</div>
                                    <h4>{{ $dashboardDatas[0]->TotalDelivered ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delivered Orders Amount -->
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon">₱</i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Delivered Orders Amount</div>
                                    <h4>₱{{ number_format($dashboardDatas[0]->TotalDeliveredAmount ?? 0, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Canceled Orders -->
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Canceled Orders</div>
                                    <h4>{{ $dashboardDatas[0]->TotalCanceled ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Canceled Orders Amount -->
                    <div class="wg-chart-default">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon">₱</i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Canceled Orders Amount</div>
                                    <h4>₱{{ number_format($dashboardDatas[0]->TotalCanceledAmount ?? 0, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Earnings Revenue -->
            <div class="wg-box">
                <div class="flex items-center justify-between">
                    <h5>Earnings Revenue</h5>
                </div>
                <div class="flex flex-wrap gap40">
                    <div>
                        <div class="mb-2">
                            <div class="block-legend">
                                <div class="dot t1"></div>
                                <div class="text-tiny">Revenue Total</div>
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                            <h4>₱{{ number_format($TotalAmount ?? 0, 2) }}</h4>
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">
                            <div class="block-legend">
                                <div class="dot t2"></div>
                                <div class="text-tiny">Pending</div>
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                            <h4>₱{{ number_format($TotalOrderedAmount ?? 0, 2) }}</h4>
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">
                            <div class="block-legend">
                                <div class="dot t2"></div>
                                <div class="text-tiny">Delivered</div>
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                            <h4>₱{{ number_format($TotalDeliveredAmount ?? 0, 2) }}</h4>
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">
                            <div class="block-legend">
                                <div class="dot t2"></div>
                                <div class="text-tiny">Canceled</div>
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                            <h4>₱{{ number_format($TotalCanceledAmount ?? 0, 2) }}</h4>
                        </div>
                    </div>
                </div>
                <div id="line-chart-8"></div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="tf-section mb-30">
            <div class="wg-box">
                <div class="flex items-center justify-between">
                    <h5>Recent Orders</h5>
                    <div class="dropdown default">
                        <a class="btn btn-secondary dropdown-toggle" href="{{ route('admin.orders') }}">
                            <span class="view-all">View all</span>
                        </a>
                    </div>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Order No</th>
                                    <th class="text-center">Customer Name</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Artwork Price</th>
                                    <th class="text-center">Fee</th>
                                    <th class="text-center">Total (Fee Included)</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Order Date</th>
                                    <th class="text-center">Delivered On</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tbody>
                                    @forelse ($orders as $order)
                                        @php
                                            // Filter order items for the current artist
                                            $artistOrderItems = $order->orderItems->filter(fn($item) => $item->product->artist_id == Auth::id());
                                
                                            // Calculate subtotal (regular price only)
                                            $artistSubtotal = $artistOrderItems->sum(fn($item) => $item->product->regular_price * $item->quantity);
                                
                                            // Calculate fees (commission)
                                            $feePercentage = 0.15; // Example: 12% commission
                                            $artistFee = $artistSubtotal * $feePercentage;
                                
                                            // Calculate total (Subtotal + Fee)
                                            $artistTotal = $artistSubtotal + $artistFee;
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $order->id }}</td>
                                            <td class="text-center">{{ $order->name }}</td>
                                            <td class="text-center">{{ $order->phone }}</td>
                                            <td class="text-center">₱{{ number_format($artistSubtotal, 2) }}</td> <!-- Regular Price -->
                                            <td class="text-center">₱{{ number_format($artistFee, 2) }}</td> <!-- Admin Fee -->
                                            <td class="text-center">₱{{ number_format($artistTotal, 2) }}</td> <!-- Total -->
                                            <td class="text-center">
                                                <span class="badge {{ $order->status === 'delivered' ? 'bg-success' : ($order->status === 'canceled' ? 'bg-danger' : 'bg-warning') }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">{{ $order->created_at->format('Y-m-d') }}</td>
                                            <td class="text-center">{{ $order->delivered_date ?? 'N/A' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.order.details', ['order_id' => $order->id]) }}" class="btn btn-sm btn-primary">
                                                    <i class="icon-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">No recent orders found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        </div>
    </div>
</div>
@endsection


@push("scripts")

<script>
    (function ($) {

        var tfLineChart = (function () {

            var chartBar = function () {

                var options = {
                    series: [{
                        name: 'Total',
                        data: [{{$AmountM}}]
                    }, {
                        name: 'Pending',
                        data: [{{$OrderedAmountM}}]
                    },
                    {
                        name: 'Delivered',
                        data: [{{$DeliveredAmountM}}]
                    }, {
                        name: 'Canceled',
                        data: [{{$CanceledAmountM}}]
                    }],
                    chart: {
                        type: 'bar',
                        height: 325,
                        toolbar: {
                            show: false,
                        },
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '10px',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        show: false,
                    },
                    colors: ['#2377FC', '#FFA500', '#078407', '#FF0000'],
                    stroke: {
                        show: false,
                    },
                    xaxis: {
                        labels: {
                            style: {
                                colors: '#212529',
                            },
                        },
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    },
                    yaxis: {
                        show: false,
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return "$ " + val + ""
                            }
                        }
                    }
                };

                chart = new ApexCharts(
                    document.querySelector("#line-chart-8"),
                    options
                );
                if ($("#line-chart-8").length > 0) {
                    chart.render();
                }
            };

            /* Function ============ */
            return {
                init: function () { },

                load: function () {
                    chartBar();
                },
                resize: function () { },
            };
        })();

        jQuery(document).ready(function () { });

        jQuery(window).on("load", function () {
            tfLineChart.load();
        });

        jQuery(window).on("resize", function () { });
    })(jQuery);
</script>

@endpush