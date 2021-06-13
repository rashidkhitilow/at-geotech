class MyUtils {

    //Mamed's functions
    static toastSuccess(msg) {
        Swal.fire({
            title: msg||'Operation successfully completed!',
            showConfirmButton: false,
            timer: 5000,
            icon: 'success',
            timerProgressBar: true,
            showCloseButton: true,
            toast: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    }
    static toastError(msg) {
        Swal.fire({
            title: msg??'Operation failed!',
            showConfirmButton: false,
            timer: 5000,
            icon: 'error',
            timerProgressBar: true,
            showCloseButton: true,
            toast: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    }
    static alertSuccess(msg) {
        Swal.fire({
            title: msg||'Operation successfully completed!',
            showConfirmButton: false,
            timer: 5000,
            icon: 'success',
            timerProgressBar: true,
            showCloseButton: true,
            toast: false,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    }
    static alertError(msg) {
        Swal.fire({
            title: msg??'Operation failed!',
            showConfirmButton: false,
            timer: 5000,
            icon: 'error',
            timerProgressBar: true,
            showCloseButton: true,
            toast: false,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    }
    static async loadingShow() {
        await $.LoadingOverlay("show", {imageColor: '#968DF4'});
    }
    static async loadingHide() {
        await $.LoadingOverlay("hide");
    }
    static msg(title, msg, icon='info') {
        Swal.fire({
            title: title,
            html: msg,
            showConfirmButton: true,
            icon: icon,
            showCloseButton: true,
            toast: false,
        })
    }
    // https://select2.org/programmatic-control/events
    // use select2ExtraParams map to select extra params to select2 url
    // you can populate select2ExtraParams in onOpening
    static select2ExtraParams = {}
    static select2(descriptor, url, onChange, onClear, onOpening){
        for (var i = 0; i <  $(descriptor).length; i++) {
            var elm = $(descriptor).eq(i);
            var placeholder = elm.attr('placeholder')??' ';
            if (url != '' && url != undefined && url != null){
                if (elm.data('select2')) { elm.select2('destroy');}
                elm.select2({
                    placeholder: placeholder,
                    allowClear: true,
                    language: 'en',
                    ajax: {
                        url: url,
                        dataType: 'json',
                        delay: 350,
                        data: function (params) {
                            return {
                                term: params.term,
                                query: params.term,
                                page: params.page,
                                ...MyUtils.select2ExtraParams
                            }
                        },
                        processResults: function (data, params) {
                          params.page = params.page || 1;
                          return {
                            results: data??[],
                            pagination: {
                                more: data.length>0
                            }
                          };
                        },
                        cache: false
                      },
                      minimumInputLength: 1
                });
            } else {
                elm.select2({
                    placeholder: placeholder,
                    allowClear: true,
                });
            }
            if (onChange)
                $(elm).on('select2:select', onChange);
            if (onClear)
                $(elm).on('select2:clear', onClear);
            if (onOpening)
                $(elm).on('select2:opening', onOpening);
            $(elm).on('select2:close', e => MyUtils.select2ExtraParams = {});
            $('.select2-search__field').addClass('form-control');
        }
    }
    static select2Remove(descriptor){
        $(descriptor).each(function(){
            if ($(this).data('select2'))  $(this).select2('destroy');
        });
    }

    // https://api.jqueryui.com/autocomplete/
    static autocompleteExtraParams = {}
    static autocomplete(descriptor, url, onSelectCallback){
        for (var i = 0; i <  $(descriptor).length; i++) {
            var elm = $(descriptor).eq(i);

            $( elm ).autocomplete({
                delay: 200,
                source: function( request, response ) {
                  $.ajax( {
                    url: url,
                    dataType: "json",
                    data: {
                        term: request.term,
                        query: request.term,
                        ...MyUtils.autocompleteExtraParams
                    },
                    success: function( data ) {
                      response( data );
                    }
                  } );
                },
                minLength: 1,
                select: onSelectCallback
              } );
        }
    }
    static randId = () => Math.floor(Math.random() * 10**9) + 10**2;

    static async confirm(title, text, icon) {
        var result = await Swal.fire({
            title: title??'Are you sure?',
            text: text??"You won't be able to revert this!",
            icon: icon??'warning',
            showCancelButton: true,
            // confirmButtonColor: '#3085d6',
            // cancelButtonColor: '#d33',
            // confirmButtonText: 'Yes, delete it!'
        })
        return result.isConfirmed
    }

    // mapping = {'col1_attr_name': 'col1_title', 'col2_attr_name': 'col2_title'}
    // data = [{'col1_attr_name': 'col1_val', 'col2_attr_name': 'col2_val'}]
    static generateTableFromJson(mapping, data, table_id='swal_list_table') {
        var html = '';
        html += '<table class="table table-sm table-bordered" id="'+table_id+'"><tr>';
        for (var attr in mapping) {
            html += '<th>'+mapping[attr]+'</th>'
        }
        html += '</tr>'
        for (var i=0; i < data.length; i++){
            html += '<tr>'
            for (var attr in mapping) {
                var val = data[i][attr];
                if (!val || val == 'null') val = '';
                html += '<td>'+val+'</td>'
            }
            html += '</tr>'
        }
        html += '</table>'
        return html;
    }

    static popup(title, body, width=600, max_width=1000) {
        $('.erp_popup_window').remove();
        var a = $(`<div class="erp_popup_window card shadow-lg d-print-none " style="min-width: ${width}px; max-width: ${max_width}px; position: fixed; top: 100px; left: 50%; margin-left: -${width/2}px;z-index: 999;">
                    <div class="card-header alert alert-primary text-white p-0" style="cursor: move">
                        <h5 class="m-0 p-3 w-100 text-white">
                        ${title}
                        <button style="float: right" onclick="this.closest('.erp_popup_window').remove();" type="button" class="btn btn-outline text-white m-0 p-0">
                        <h5 class="m-0">&times;</h5>
                        </button>
                        </h5>
                    </div>
                    <div class="card-body" style="max-height: 700px;overflow: auto;">
                        ${body}
                    </div>
                </div>`)
        a.appendTo('body')
        a.draggable({ handle: ".card-header" })
        a.resizable()
    }

    static getDraggableIndicator( args ) {
        args = args || {};
        var 	width 	= args.width || 32,
                height 	= args.height || 32,
                dotWidth 	= args.dotWidth || 4,
                rows		= args.rows || 4,
                cols		= args.cols || 4,
        initialX	= 0,
        initialY 	= 0;
        var h_space = Math.floor((width - cols * dotWidth) / (cols - 1)) + dotWidth
        var v_space = Math.floor((height - rows * dotWidth) / (rows - 1)) + dotWidth
        var svg = '<svg viewBox="0 0 ' + width + ' ' + height + '">';
            for ( var i = 0; i < rows; i++ ) {
                for( var j = 0; j < cols; j++ ) {
                    svg += '<rect x="' + ( initialX + j*h_space ) + '" ' +
                        'y="' + ( initialY + i*v_space ) + '"' +
                        ' width="' + dotWidth + '" height="' + dotWidth + '" ' +
                    ' />';
                }
            }
        svg += '</svg>';
        return svg;
    }
    static getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
          color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    // https://github.com/dtjohnson/xlsx-populate
    static numberToExcelLetter(num) {
        let letters = ''
        while (num >= 0) {
            letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'[num % 26] + letters
            num = Math.floor(num / 26) - 1
        }
        return letters
    }
    static async tableToExcel(table_selector, file_name="generated_excel.xlsx", first_row_bgcolor='C8CBCF', border=true) {
        var workbook = await XlsxPopulate.fromBlankAsync()
        var sheet = workbook.sheet(0)
        var rows = document.querySelectorAll(table_selector+' tr');
        var maxColWidth = {};
        for (var r = 0; r < rows.length; r++) {
            var cols = rows[r].children;
            for (var c = 0; c < cols.length; c++) {
                var inputs = cols[c].getElementsByTagName('select');
                for(var j = 0; j<inputs.length; j++){
                    var input = inputs[j];
                    $(input).replaceWith($('option:selected',$(input)).text());
                }
                var inputs = cols[c].getElementsByTagName('input');
                for(var j = 0; j<inputs.length; j++){
                    var input = inputs[j];
                    if ($(input).attr('type') == 'hidden') $(input).remove();
                    else {
                        $(input).replaceWith($(input).val());
                    }
                }
                var val = cols[c].innerText.trim();
                var cell = sheet.row(r+1).cell(c+1)
                if (!isNaN(val) && val != '' && (val[0] != '0' || val == '0')) val *= 1
                // else if (Date.parse(val))  val = Date.parse(val).toString('s')
                cell.value(val)
                if (r == 0) {
                    cell.style({ bold: true, fill: first_row_bgcolor.replace('#', '') });
                }
                cell.style({ border: border });
                if (cols[c].colSpan && cols[c].colSpan*1 > 1) {
                    cell.rangeTo(sheet.row(r+1).cell(c+cols[c].colSpan)).merged(true).style({ border: border })
                }
                maxColWidth[c] = Math.max(maxColWidth[c]??0, val.toString().length);
            }
        }

        for (var c in maxColWidth) {
            sheet.column(MyUtils.numberToExcelLetter(c)).width(maxColWidth[c]+3)
        }

        var blob = await workbook.outputAsync();
        if (window.navigator && window.navigator.msSaveOrOpenBlob) {
            window.navigator.msSaveOrOpenBlob(blob, file_name);
        } else {
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement("a");
            document.body.appendChild(a);
            a.href = url;
            a.download = file_name;
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        }
    }

    static clearPopupForm(form_id) {
        $('#'+form_id+' div input, #'+form_id+' div select').val('')
        $('#'+form_id+' div select').trigger('change.select2')
    }
    static flash(selector) {
        $(selector).addClass('flash');
        setTimeout(()=>$(selector).removeClass('flash'), 2000);
    }


    static row_num(descriptor){
        $(descriptor).each(function(idx){
            $(this).html(idx+1)
            $(this).attr('data-row_num', idx+1)
        });
    }


    //Tural's functions
    static showSelectedCurrency(){
        $(document).on('change', '.curerency_select', function () {
            $('.show_selected_currency').text($(this).val());
        });
    }

    static datePicker(elem = '.sales_date') {
        $(elem).datetimepicker({
            timepicker: false,
            format: 'd.m.Y',
        });
    }

    static timePicker(elem = '.sales_time') {
        $(elem).datetimepicker({
            datepicker: false,
            format: 'H:i',
        });
    }

    static dateTimePicker(elem = '.sales_datetime') {
        $(elem).datetimepicker({
            format: 'd.m.Y H:i',
        });
    }

    static is_numeric(mixed_var) {
        // Returns true if value is a number or a numeric string
        //
        // version: 1109.2015
        // discuss at: http://phpjs.org/functions/is_numeric
        // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // +   improved by: David
        // +   improved by: taith
        // +   bugfixed by: Tim de Koning
        // +   bugfixed by: WebDevHobo (http://webdevhobo.blogspot.com/)
        // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
        // *     example 1: is_numeric(186.31);
        // *     returns 1: true
        // *     example 2: is_numeric('Kevin van Zonneveld');
        // *     returns 2: false
        // *     example 3: is_numeric('+186.31e2');
        // *     returns 3: true
        // *     example 4: is_numeric('');
        // *     returns 4: false
        // *     example 4: is_numeric([]);
        // *     returns 4: false
        return (typeof(mixed_var) === 'number' || typeof(mixed_var) === 'string') && mixed_var !== '' && (' ' +
            mixed_var).replace(/ /g, '') !== '' && !isNaN(mixed_var);
    }

    static roundNumber(a, precision) {
        if (!MyUtils.is_numeric(a)) return '';
        a = a * 1;
        if (precision === undefined) precision = 5;
        var b = a.toFixed(precision);
        b = b * 1;
        return b;
    }
}