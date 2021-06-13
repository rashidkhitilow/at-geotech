@extends('layouts.master')

@section('content')
@php if (!isset($mode)) $mode = 'all'; @endphp
<div class="content-wrapper">
    <div class="content-body">
        <section class="section">
            @if ($mode == 'all')
                @include('employee_datas.all')
            @endif
        </section>
    </div>
</div>

@endsection
