<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-size: 1rem;
            font-family: "Nunito", sans-serif;
            font-weight: initial;
            line-height: normal;
            color: #000 !important;
        }

        .main-content {
            padding: 1.5rem;
        }

        .text-center {
            text-align: center;
        }

        .semibold {
            font-weight: 600;
        }

        .bold {
            font-weight: bold;
        }

        .btn-genix {
            display: inline-block;
            font-weight: 400;
            color: #212529;
            text-align: center;
            border: 1px solid transparent;
            padding: 0.34rem 0.5rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            color: #fff;
            background-color: #1d345e;
            border-color: #1d345e !important;
        }

        .decoration-none {
            text-decoration: none;
        }

        .py-1 {
            padding: 0.5rem 0;
        }

        .py-2 {
            padding: 0.75rem 0;
        }

        .py-3 {
            padding: 1rem 0;
        }

        .pb-1 {
            padding-bottom: 0.5rem;
        }

        .pb-2 {
            padding-bottom: 0.75rem;
        }

        .pb-3 {
            padding-bottom: 1rem;
        }

        .pt-1 {
            padding-top: 0.5rem;
        }

        .pt-2 {
            padding-top: 0.75rem;
        }

        .pt-3 {
            padding-top: 1rem;
        }

        .pl-3 {
            padding-left: 1rem;
        }

        .pl-4 {
            padding-left: 1.5rem;
        }

        .pl-5 {
            padding-left: 2rem;
        }

        .fs-16 {
            font-size: 16px;
        }

        .fs-18 {
            font-size: 18px;
        }

        .fs-20 {
            font-size: 20px;
        }

        .fs-25 {
            font-size: 25px;
        }

        ul>li {
            list-style-type: disc;
        }

        .center {
            display: flex;
            justify-content: center;
        }

        .logo {
            max-width: 100%;
            height: 45px;
            margin: auto;
            vertical-align: middle;
        }

        .bg-genix {
            background-color: #1d345e;
        }

        .p-1 {
            padding: 0.50rem;
        }

        .flex {
            display: flex
        }

        .items-center {
            align-items: center
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table thead tr th,
        table thead tr {
            text-align: left;
            font-weight: 600;
        }

        table th {
            padding: 5px 6px;
            border-bottom: 1px solid #c1ced9;
            white-space: nowrap;
        }

        table td {
            padding: 10px;
            /* text-align: right; */
            border-bottom: 1px solid #eceeef
        }
    </style>
</head>

<body>
    <div class="main-content">
        @php
            $company = config('app.name');
        @endphp
        @include('mails.header')

        <main class="main-content">
            <h5 class="semibold py-2">Dear {{ $driver->full_name }},</h5>
            <p class="pb-2">Please find attached all dispatches that you have booked in for today
                {{ $date }}.</p>

            {{-- dispatches --}}
            <div class="pb-3">
                <h4 class="fs-20 semibold pb-2" style="text-decoration: underline;">Today's Dispatches</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Commodity</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">Exit</th>
                            <th scope="col">Release Code</th>
                            <th scope="col">Via</th>
                            <th scope="col">Destination</th>
                            <th scope="col">Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dispatches as $dispatch)
                            <tr>
                                <td>{!! date('m/d/Y', $dispatch?->date) !!}</td>
                                <td class="bold">
                                    <span>{!! $dispatch->commodity?->name ?? $dispatch->commodity_id !!}</span>
                                </td>
                                <td> {!! $dispatch->supplier->name ?? $dispatch->supplier_id !!}</td>
                                <td>{!! $dispatch->exit->name ?? $dispatch->exit_id !!}</td>
                                <td>{!! $dispatch->release_code ?? ' ' !!}</td>
                                <td><span>{!! $dispatch->via->name ?? $dispatch->via_id !!}</span>
                                </td>
                                <td><span>{!! $dispatch->destination?->name ?? $dispatch->destination_id !!}<br>{!! $dispatch->destination?->address !!}</span>
                                </td>
                                <td>{!! $dispatch->rate->name ?? $dispatch->rate_id !!}</td>
                            </tr>
                            {{-- @empty
                                <tr>
                                    <td colspan="8">No Dispatch Today</td>
                                </tr> --}}
                        @endforeach
                    </tbody>
                </table>
            </div>

            @include('mails.footer', ['company' => $company])
        </main>

    </div>

</body>

</html>
