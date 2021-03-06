{{-- $project, $checkitem --}}
<div class="item">
    <div class="middle aligned content">
        <div class="header">
            @if (!is_null($checkitem->passes) && $checkitem->passes)
                <i class="green check icon"></i>
            @endif
            @if (!is_null($checkitem->passes) && !$checkitem->passes)
                <i class="red remove icon"></i>
            @endif
            {{ $checkitem->name }}
        </div>
        <div class="description">{{ $checkitem->detail }}</div>
        <div class="extra">
            <div class="inline right floated fields">
                @include('components.checkitem-radio-buttons', compact('checkitem'))
            </div>

            @if (!is_null($checkitem->faultImprovement))
                @if (is_null($checkitem->faultImprovement->passes))
                    <a
                        href="{{ route('projects.fault-improvements.show', [$project->id, $checkitem->faultImprovement->id]) }}"
                        class="ui label"
                    >
                        {{ trans_choice('all.fault_improvements', 1) }}
                    </a>
                @elseif (!is_null($checkitem->faultImprovement->passes) && $checkitem->faultImprovement->passes)
                    <a
                        href="{{ route('projects.fault-improvements.show', [$project->id, $checkitem->faultImprovement->id]) }}"
                        class="ui green label"
                    >
                        {{ trans_choice('all.fault_improvements', 1) }}
                    </a>
                @else
                    <a
                        href="{{ route('projects.fault-improvements.show', [$project->id, $checkitem->faultImprovement->id]) }}"
                        class="ui red label"
                    >
                        {{ trans_choice('all.fault_improvements', 1) }}
                    </a>
                @endif
            @endif
        </div>
    </div>
</div>
