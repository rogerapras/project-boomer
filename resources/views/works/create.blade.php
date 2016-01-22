{{-- */ $breadcrumbs = [
    trans('all.settings') => route('settings.index'),
    trans_choice('all.works', 2) => route('works.index'),
    trans('all.create') => null
] /* --}}

@extends('layouts.settings')

@section('content')
    <form class="ui form {{ count($errors) ? 'error' : '' }}" method="POST" action="{{ route('works.store') }}">
        {{ csrf_field() }}

        <div class="field">
            <label>{{ trans('all.select_type_order') }}</label>
            <flowtype-select></flowtype-select>
        </div>

        <div class="field">
            <label>{{ trans('all.select_unit') }}</label>
            <unit-select></unit-select>
        </div>

        <div class="field">
            <label>{{ trans('all.select_workflow') }}</label>
            <workflow-select></workflow-select>
        </div>

        <div class="equal width fields">
            <div class="field {{ $errors->has('name') ? 'error' : '' }}">
                <label>{{ trans('all.name') }}</label>
                <input type="text" name="name" placeholder="名稱">
            </div>
            <div class="field {{ $errors->has('amount') ? 'error' : '' }}">
                <label>{{ trans('all.amount') }}</label>
                <input type="text" name="amount" placeholder="數量">
            </div>
        </div>

        @if (count($errors))
            <div class="ui error message">
                <div class="header">{{ trans('all.please_fill_the_form') }}</div>
                <p>{{ trans('all.please_fill_the_form') }}</p>
            </div>
        @endif

        <button class="ui primary button" type="submit">{{ trans('all.create') }}</button>
    </div>
@stop
