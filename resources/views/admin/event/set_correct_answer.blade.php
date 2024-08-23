@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-9">
                        <h1>Set Correct Answers</h1>
                    </div>
                </div>
            </div>
        </section>


        <section class="content">
            <div class="container-fluid">
                @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <span>{!! \Session::get('success') !!}</span>
                    </div>
                @endif
                <div class="card shadow-lg">
                    <div class="card-header">
                        <h3 class="card-title">{{ $event->name }}</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('event.save-correct-answer', $event->id) }}" method="POST">
                            @csrf
                            @foreach ($event->questions as $key => $question)
                                {{-- Make A UI like ul li with correct answer checkbox --}}

                                <div class="form-group">
                                    <label for="question">{{ $question->name }}</label>
                                    <input type="hidden" name="question_id[]" value="{{ $question->id }}">
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    
                                    @if ($question->options()->count() > 0  )
                                        @foreach ($question->options as $option)
                                        @if ($option->name)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="option_id[]"
                                                    value="{{ $option->id }}"
                                                    id="option-{{ $key }}-{{ $loop->iteration }}" @if ($option->is_correct) checked @endif>
                                                <label class="form-check-label"
                                                    for="option-{{ $key }}-{{ $loop->iteration }}">
                                                    {{ $option->name }}
                                                </label>
                                            </div>
                                        @endif
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('content-js')
@endsection
