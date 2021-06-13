@php
    $item_name = "employee_data";
    $form_id = "add_employee_data_frm";
    $url = "employee_datas";
@endphp
<script>

$(document).on('click', '.show_add_{{ $item_name }}_btn', (e) => {
    MyUtils.popup(
        'Add new employee_data',
        `<form id="{{ $form_id }}" autocomplete="off">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form">
                    <div class="row">
                        <div class="col-auto mb-3">
                            <label>Name*</label>
                            <input style="width: 100%;" type="text" class="form-control" name="name" placeholder="Name..." >
                        </div>
                        <div class="col-auto mb-3">
                            <label>Surname*</label>
                            <input style="width: 100%;" type="text" class="form-control" name="surname" placeholder="Surname..." >
                        </div>
                        <div class="col-auto mb-3">
                            <label>Phone</label>
                            <input style="width: 100%;" type="text" class="form-control" name="phone" placeholder="Phone..." >
                        </div>
                        <div class="col-auto mb-3">
                            <label>Address*</label>
                            <input style="width: 100%;" type="text" class="form-control" name="address" placeholder="Address..." >
                        </div>
                        <div class="col-auto mb-3">
                            <div class="form-group">
                                <label style="width: 100%;">Department*</label>
                                <select style="width: 170px;" class="form-select form-control" name="department_id"  placeholder="Department..."></select>
                            </div>
                        </div>
                        <div class="col-auto mb-3">
                            <div class="form-group">
                                <label style="width: 100%;">Position*</label>
                                <select style="width: 170px;" class="form-select form-control" name="position_id"  placeholder="Position..."></select>
                            </div>
                        </div>
                        <div class="col-auto mb-3">
                            <label style="width: 100%;">&nbsp;</label>
                            <button type="button" class="btn btn-primary add_{{ $item_name }}_btn">Save</button>
                        </div>
                    </div>
                </div>
            </form>
            `,
        650);
        setTimeout(()=>MyUtils.select2('#{{ $form_id }} [name="department_id"]', '/autocomplete/departments'), 300)
        setTimeout(()=>MyUtils.select2('#{{ $form_id }} [name="position_id"]', '/autocomplete/positions'), 300)
})
$(document).on('click', '#{{ $form_id }} .add_{{ $item_name }}_btn', async (e) => {
    MyUtils.loadingShow();
    var formData = new FormData($('#{{ $form_id }}')[0])
    $.ajax({
        url: '/{{ $url }}/new',
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
    }).done(function(data) {
        if (data && data['result'] == 'success') {
            MyUtils.clearPopupForm('{{ $form_id }}')

            $.get('/{{ $url }}/filter?ff__id='+data['employee_data']['id']).done(function(data) {
                $('tr', $(data)).each(function(index) {
                    if (index == 0 || index > 1) return;
                    $('#all_items_tbl tr:first').after($(this))
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