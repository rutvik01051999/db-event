@if (!(\Carbon\Carbon::parse($event->start_date)->format('Y-m-d') < \Carbon\Carbon::now()->format('Y-m-d')))
    <div class="d-flex align-items-center">
        <a class="text-danger mx-2 set_coreect_answer" href="{{ route('event.set-correct-answer', $event->id) }}"
            data-id="{{ $event->id }}">
            <i class="fa fs-18 fa-regular fa-check"></i>
        </a>
        <a class="text-primary mx-2" href="{{ route('event.edit', $event->id) }}">
            <i class="fa fs-18 fa-regular fa-edit"></i>
        </a>
        <a class="text-secondary mx-2" href="{{ route('question.list', ['id' => $event->id]) }}">
            <i class="fa fs-18 fa-regular fa-eye"></i>
        </a>
        <a class="text-danger mx-2 editor-delete" href="javascript:void(0)" data-id="{{ $event->id }}">
            <i class="fa fs-18 fa-regular fa-trash-alt"></i>
        </a>
        @if ($event->status == 1)
            <a class="text-success mx-2" href="javascript:void(0)" onclick="changeStatus({{ $event->id }}, 0)">
                <i class="fa fs-24 fa-solid fa-toggle-on fa-toggle-on"></i>
            </a>
        @else
            <a class="text-danger mx-2" href="javascript:void(0)" onclick="changeStatus({{ $event->id }}, 1)">
                <i class="fa fs-24 fa-solid fa-toggle-off mt-1"></i>
            </a>
        @endif
    </div>
@else
    -
@endif
