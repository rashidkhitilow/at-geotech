@extends('layouts.master')

@section('content')
@php if (!isset($mode)) $mode = 'all'; @endphp
<div class="content-wrapper">
    <div class="content-body">
        <section class="section">
            @if ($mode == 'all')
                @include('users.all')
            @endif
        </section>
    </div>
</div>

@endsection
