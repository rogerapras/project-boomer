{{-- */ $breadcrumbs = [
    'Settings' => route('settings.index'),
    'Works' => route('works.index'),
    "{$work->name}" => route('works.show', $work->id),
    'Workflow' => null
] /* --}}

@extends('layouts.general')

@section('sidebar')
    @include('partials.settings-sidebar')
@stop

@section('content')
    <div class="ui secondary pointing menu">
        <a href="{{ route('works.show', $work->id) }}" class="item">基本資料</a>
        <a href="{{ route('works.work-items.index', $work->id) }}" class="item">工料項目列表</a>
        <a href="{{ route('works.workflow', $work->id) }}" class="active item">流程圖</a>
        <a href="{{ route('works.checklist', $work->id) }}" class="item">Check List</a>
    </div>

    <div id="workflow-node-list" data-workflow-id="{{ $work->workflow->id }}"></div>
@stop
