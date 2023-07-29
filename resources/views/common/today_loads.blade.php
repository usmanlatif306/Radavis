<div class="col-md-12 mt-4">
    <div class="card shadow mb-4">
        <div class="card-header card-header-height d-flex align-items-center">
            <h6 class="font-weight-bold text-primary mb-0 pb-0">Today’s Loads</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th data-priority="1">Commodity</th>
                            <th data-priority="2">Destination</th>
                            <th>Via</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dispatches as $dispatch)
                            <tr class="{{ $dispatch->release_code == '' ? 'table-info' : ' ' }}{{ $dispatch->noship == 1 ? 'table-danger' : ' ' }}{{ $dispatch->void == 1 ? 'table-dark' : ' ' }}{{ $dispatch->delivered == 1 ? 'table-success' : ' ' }}"
                                @if ($dispatch->void == 1) style="background-color: #D3D3D3; text-decoration: line-through;" @endif>
                                <td style="color:{{ $dispatch->commodity?->color ?? '' }};font-weight: bold;">
                                    <span>{!! $dispatch->commodity?->name ?? $dispatch->commodity_id !!}</span>
                                </td>
                                <td><span>{!! $dispatch->destination?->name ?? $dispatch->destination_id !!}<br>{!! $dispatch->destination?->address !!}</span>
                                </td>
                                <td>{!! $dispatch->via->name ?? $dispatch->via_id !!}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
