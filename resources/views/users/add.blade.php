@php
    $item_name = "user";
    $form_id = "add_user_frm";
    $url = "users";
@endphp
<script>

$(document).on('click', '.show_add_{{ $item_name }}_btn', (e) => {
    MyUtils.popup(
        'Add new user',
        `<form id="{{ $form_id }}" autocomplete="off">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form">
                    <div class="row">
                        <div class="col-auto mb-3">
                            <label>Full Name*</label>
                            <input style="width: 100%;" type="text" class="form-control" name="name" placeholder="Full name..." >
                        </div>
                        <div class="col-auto mb-3">
                            <label>Email*</label>
                            <input style="width: 100%;" type="text" class="form-control" name="email" placeholder="Email..." >
                        </div>
                        <div class="col-auto mb-3">
                            <label>Phone*</label>
                            <input style="width: 100%;" type="text" class="form-control" name="phone_number" placeholder="Phone..." >
                        </div>
                        <div class="col-auto mb-3">
                            <label>Password*</label>
                            <input style="width: 100%;" type="password" class="form-control" name="password" placeholder="Password..." >
                        </div>
                        <div class="col-auto mb-3">
                            <label>Repeat Password*</label>
                            <input style="width: 100%;" type="password" class="form-control" name="password2" placeholder="Repeat Password..." >
                        </div>

                        <div class="col-auto mb-3">
                            <div class="form-group">
                                <label style="width: 100%;">Role*</label>
                                <select style="width: 170px;" class="form-select form-control" name="role_id"  placeholder="Role..."></select>
                            </div>
                        </div>
                        <div class="col-auto col-3">
                            <div class="form-group">
                                <label for="role">Departments*</label>
                                <select class="select2 form-control departments" name="departments[]" multiple>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->title }}</option>
                                    @endforeach
                                </select>
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
        setTimeout(()=>MyUtils.select2('#{{ $form_id }} [name="role_id"]', '/autocomplete/roles'), 300)
        setTimeout(()=>MyUtils.select2('#{{ $form_id }} [name="departments[]"]', '/autocomplete/departments'), 300)
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

            $.get('/{{ $url }}/filter?ff__id='+data['user']['id']).done(function(data) {
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