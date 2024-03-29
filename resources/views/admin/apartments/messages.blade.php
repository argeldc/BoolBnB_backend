@php
    use App\Functions\Helper;
@endphp
@extends('layouts.admin')
@section('content')
    <div>
        @if ($number_messages > 0)
            <h2>Hai <span class="number-email text-center">{{ $number_messages }}</span> messaggi</h2>
        @endif

        @forelse ($messages as $message)
            <div class="accordion accordion-flush email-box " id="accordionFlushExample{{ $message->id }}">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed p-1 p-sm-3" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapse{{ $message->id }}" aria-expanded="false"
                            aria-controls="flush-collapseOne">
                                <i class="fa-solid fa-envelope text-primary me-2">
                                <strong class="me-2 d-none d-md-block"></i>Messaggio dell'appartamento:</strong>
                            {{ $message->title }}
                        </button>
                    </h2>
                    <div id="flush-collapse{{ $message->id }}" class="accordion-collapse collapse"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <span class="text-secondary">Inviato da: {{ $message->sender_email }}</span> <br />
                            <span class="text-secondary">Inviato il: {{ Helper::formatDate($message->sended_at) }}</span>
                            <p>{{ $message->text }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <h2>Non hai messaggi</h2>
        @endforelse
    </div>
@endsection
