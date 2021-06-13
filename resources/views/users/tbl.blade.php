@php
$item_name = 'user';
@endphp


<table class="table table-bordered" id="all_items_tbl">
    <thead>
        <tr class="table-secondary text-center">
            <th>Full name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Role</th>
            <th>Departments</th>
            <th>Field names</br>can show</th>
            <th>Created at</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($all['items'] as $user)
            <tr class="tr_{{ $item_name }}_user" data_id="{{ $user['id'] }}">
                <td class="td_name">{{ $user['name'] }}</td>
                <td class="td_email">{{ $user['email'] }}</td>
                <td class="td_phone_number">{!! $user['phone_number'] !!}</td>
                <td class="td_role">{!! $user['role'] !!}</td>
                <td class="td_user_departments">{!! $user['user_departments'] !!}</td>
                <td class="td_user_department_field_names">{!! $user['user_department_field_names'] !!}</td>
                <td class="td_created_at">{{ $user['created_at'] }}</td>
                <td class="td_buttons">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-success btn-sm show_edit_{{ $item_name }}_btn"
                            name="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm remove_{{ $item_name }}_btn"
                            title="Remove">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@include('snippets.load_more_btn')
