<script>
    var filter_timeout;
    function item_filter(e) {
        clearTimeout(filter_timeout);
        filter_timeout = setTimeout(function(){
            $('#all_items_tbl tr').not(':first').remove()
            $('#all_items_tbl tr:first').after('<tr><td style="text-align: center" colspan="30" class="tr"><img src="{{asset('assets/css/loading_16x16.gif')}}"></td></tr>')
            var formData = new FormData($(e.target).parents('form:first')[0])
            var data = {}
            for(var pair of formData.entries()) {
                if (pair[0].startsWith('ff__') && pair[1] != '') {
                    data[pair[0]] = pair[1]
                }
            }
            $.ajax({
                url: '{{ $filter_url }}',
                data: data,
            }).done(function(data) {
                history.pushState({}, null, this.url.replace('/filter',''));
                $('#tbl_holder').html(data)
            })
            .fail(function() {
                MyUtils.toastError()
            })
            .always(function() {
                MyUtils.loadingHide()
            });
        }, 800)

        if (typeof adjustFilters === "function") adjustFilters()
        if (typeof adjustFilters === "resetLoadMore") resetLoadMore()
    }
    $(document).on('touchup keyup', 'input[name^="ff__"]', item_filter)
    $(document).on('change', 'select[name^="ff__"]', item_filter)
    $('#reset_filter').click(()=> {
        // $('[name^="ff__"]').each(function(index){
        //     $(this).val('')
        // })
        // $('.select2[name^="ff__"]').trigger('change');
        // item_filter(this)

        location.href = location.protocol + '//' + location.host + location.pathname
    })


    var last_loaded_page = 1
    var loading_more = false;
    var can_load_more = true;
    function resetLoadMore() {
        last_loaded_page = 1
        loading_more = false;
        can_load_more = true;
        $('#load_more_btn').show()
    }
    $(document).on('click', '#load_more_btn', function(){
        if (loading_more) return;
        loading_more = true
        var old_content = $('#load_more_btn').html()
        $('#load_more_btn').html('<img src="{{asset('assets/css/loading_16x16.gif')}}">')

        var formData = new FormData($(this).parents('form:first')[0])
        var data = {}
        for(var pair of formData.entries()) {
            if (pair[0].startsWith('ff__') && pair[1] != '') {
                data[pair[0]] = pair[1]
            }
        }

        last_loaded_page += 1
        data['page'] = last_loaded_page

        $.ajax({
            url: '{{ $filter_url }}',
            data: data
        }).done(function(data) {
            var can_load_more = false
            $('tr', $(data)).each(function(index) {
                if (index > 0){
                    can_load_more = true
                    $('#all_items_tbl tr:last').after($(this))
                }
            })
            if (!can_load_more) $('#load_more_btn').hide()
        })
        .fail(function() {
            MyUtils.toastError()
        })
        .always(function() {
            loading_more = false
            $('#load_more_btn').html(old_content)
        });
    })

    $(window).scroll(function(){
        if (can_load_more && !loading_more && $(window).scrollTop() >= ($(document).height() - $(window).height() - 1)) {
            $('#load_more_btn').trigger('click')
        }
    });


    // $('input[name="ff__date_range"], .filter_date_range').daterangepicker({
    //     locale: {
    //         format: 'DD.MM.YYYY'
    //     }
    // },function(start, end, label) {
    //     item_filter({target: document.querySelector('input[name="ff__date_range"]')})
    // });

    $('.filter_date_picker').datetimepicker({
        timepicker: false,
        format: 'd.m.Y',
        onSelectDate:function(ct,$i){
           item_filter({target: $i})
        }
    });
    $('.filter_datetime_picker').datetimepicker({
        format: 'd.m.Y H:i',
        onSelectDate:function(ct,$i){
            item_filter({target: $i})
        },
        onSelectTime:function(ct,$i){
            item_filter({target: $i})
        }
    });
    $('.filter_time_picker').datetimepicker({
        datepicker: false,
        format: 'H:i',
        onSelectTime:function(ct,$i){
            item_filter({target: $i})
        }
    });

</script>