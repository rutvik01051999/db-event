<div class="d-flex align-items-center">
    <a class="text-primary mx-2" href="{{ route('event.edit', $event->id) }}">
        <i class="fa fs-18 fa-regular fa-edit"></i>
    </a>
    <a class="text-secondary mx-2" href="{{ route('question.list', ['id' => $event->id]) }}">
        <i class="fa fs-18 fa-regular fa-eye"></i>
    </a>
    <a class="text-danger mx-2 editor-delete" href="javascript:void(0)" data-id="{{ $event->id }}">
        <i class="fa fs-18 fa-regular fa-trash-alt"></i>
    </a>
</div>
