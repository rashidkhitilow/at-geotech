<div class="form">
    <div class="row">
        <div class="col-auto mb-3">
            <h5 style="padding-top: 7px;"><i class="fas fa-filter"></i></h5>
        </div>
        <div class="col-1 mb-3">
            <input placeholder="ID..." type="text" class="form-control" name="ff__id" value="{{request('ff__id')}}"/>
        </div>
        <div class="col-auto mb-3">
            <input placeholder="Name..." type="text" class="form-control" name="ff__name"
                value="{{ request('ff__name') }}" />
        </div>
        <div class="col-auto mb-3">
            <input placeholder="Surname..." type="text" class="form-control" name="ff__surname"
                value="{{ request('ff__surname') }}" />
        </div>
        <div class="col-auto mb-3">
            <button type="button" id="reset_filter" class="btn btn-primary"><i class="fas fa-eraser"></i> Reset</button>
        </div>
        <div class="col-auto mb-3">
            @include('snippets.export_excel_btn')
        </div>
    </div>
</div>
