@php
    $item_name = "employee_data";
    $form_id = "edit_employee_data_frm";
    $url = "employee_datas";
@endphp
<script>
$(document).on('click', '.show_edit_{{ $item_name }}_btn', (e) => {
    var name = $(e.target).parents('tr:first').find('.td_name:first').html();
    if(name == '<i class="fas fa-lock"></i>') name = "no-permission";
    var surname = $(e.target).parents('tr:first').find('.td_surname:first').html()
    if(surname == '<i class="fas fa-lock"></i>') surname = "no-permission";
    MyUtils.popup(
        'Edit employee_data - ' + $(e.target).parents('tr:first').attr('data_id'),
        `<form id="{{ $form_id }}" autocomplete="off">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="id" value="${$(e.target).parents('tr:first').attr('data_id')}" />
                <div class="form">
                    <div class="row">
                        <div class="col-auto mb-3">
                            <label>Name*</label>
                            <input style="width: 100%;" type="text" class="form-control" name="name" value="${name}" placeholder="Name..." >
                        </div>
                        <div class="col-auto mb-3">
                            <label>Surname*</label>
                            <input style="width: 100%;" type="text" class="form-control" name="surname" value="${surname}" placeholder="Surname..." >
                        </div>
                        <div class="col-auto mb-3">
                            <label style="width: 100%;">Department*</label>
                            <select style="width: 170px;" class="form-select form-control" name="department_id"  placeholder="Department..."></select>
                        </div>
                        <div class="col-auto">
                            <label style="width: 100%;">&nbsp;</label>
                            <button type="button" class="btn btn-primary update_{{ $item_name }}_btn">Update</button>
                        </div>
                    </div>
                </div>
            </form>
            `,
        650);
        setTimeout(()=>MyUtils.select2('#{{ $form_id }} [name="department_id"]', '/autocomplete/departments'), 300)
})

$(document).on('click', '#{{ $form_id }} .update_{{ $item_name }}_btn', async (e) => {
    MyUtils.loadingShow();
    var id = $('#{{ $form_id }} [name="id"]').val()
    var formData = new FormData($('#{{ $form_id }}')[0])
    $.ajax({
        url: '/{{ $url }}/save',
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
    }).done(function(data) {
        if (data && data['result'] == 'success') {
            $.get('/{{ $url }}/filter?ff__id='+id).done(function(data) {
                $('tr', $(data)).each(function(index) {
                    if (index == 0 || index > 1) return;
                    var a = $('#all_items_tbl tr[data_id='+id+']')
                    a.after($(this))
                    a.remove()
                    MyUtils.flash(this)
                })
            })
            MyUtils.toastSuccess(data['message'])
        } else MyUtils.toastError(data['message'])
    })
    .fail(function(data) {
        MyUtils.toastError(data && data.responseJSON ? data.responseJSON['message'] : null)
    })
    .always(function() {
        MyUtils.loadingHide()
    });
})
</script>