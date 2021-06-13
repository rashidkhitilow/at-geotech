@php
$item_name = 'employee_data';
@endphp


<table class="table table-bordered" id="all_items_tbl">
    <thead>
        <tr class="table-secondary text-center">
            <th>Name</th>
            <th>Surame</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Department</th>
            <th>Position</th>
            <th>Created at</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($all['items'] as $item)
            <tr class="tr_{{ $item_name }}_user" data_id="{{ $item['id'] }}">
                <td class="td_name">{!! $item['name'] !!}</td>
                <td class="td_surname">{!! $item['surname'] !!}</td>
                <td class="td_phone">{!! $item['phone'] !!}</td>
                <td class="td_address">{!! $item['address'] !!}</td>
                <td class="td_department">{!! $item['department'] !!}</td>
                <td class="td_position">{!! $item['position'] !!}</td>
                <td class="td_created_at">{{ $item['created_at'] }}</td>
                <td class="td_buttons">
                    <div class="btn-group" role="group">
                        @if(auth()->user()->hasPermissionTo('edit-employee_datas') 
                        && auth()->user()->id == $item['user_id'] 
                        ||auth()->user()->hasRole('admin') )
                            <button type="button" {{$item['id'] == '<i class="fas fa-lock"></i>' ? "disabled" : ""}} class="btn btn-outline-success btn-sm show_edit_{{ $item_name }}_btn"
                                name="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        @endif
                        @if(auth()->user()->hasPermissionTo('delete-employee_datas') 
                        && auth()->user()->id == $item['user_id'] 
                        ||auth()->user()->hasRole('admin') )
                            <button type="button" {{$item['id'] == '<i class="fas fa-lock"></i>' ? "disabled" : ""}} class="btn btn-outline-danger btn-sm remove_{{ $item_name }}_btn"
                                title="Remove">
                                <i class="fas fa-minus"></i>
                            </button>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@include('snippets.load_more_btn')
