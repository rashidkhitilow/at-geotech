@php
    $url = 'users';
    $item_name = "user";
@endphp
<script>
$(document).on('click', '.remove_{{ $item_name }}_btn', async (e) => {
    if (!(await MyUtils.confirm('Delete '+$(e.target).parents('tr:first').find('.td_name').html()))) return;
    MyUtils.loadingShow();
    var formData = new FormData()
    formData.append('id', $(e.target).parents('tr:first').attr('data_id'))
    formData.append('_token', '{{ csrf_token() }}')
    $.ajax({
        url: '/{{ $url }}/remove',
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
    }).done(function(data) {
        if (data && data['result'] == 'success') {
            $(e.target).parents('tr:first').remove();
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