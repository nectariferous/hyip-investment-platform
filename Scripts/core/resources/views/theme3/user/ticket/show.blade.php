@extends(template().'layout.master2')

@section('content2')
    <div class="dashboard-body-part">
        <div class="row">
            <div class="col-md-8 text-md-start text-center">
                <div class="d-flex align-items-center">
                    <h5>{{ $ticket->support_id }} - {{ $ticket->subject }} </h5>
                </div>
            </div>
            <div class="col-md-4  text-md-end text-center">
                <a href="{{ route('user.ticket.index') }}" class="sp_text_secondary"><i class="fas fa-arrow-left"></i> {{ __('Back to Ticket List') }}</a>
            </div>
        </div>

        <div class="mt-4">
            <div class="site-card">
                <div class="card-body">
                    <form action="{{ route('user.ticket.reply', $ticket->id) }}" enctype="multipart/form-data"
                        method="post">
                        @csrf
                        <div class="row justify-content-md-between">
                            <div class="col-md-12">
                                <div class="form-group ticket-comment-box">
                                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                    <label for="exampleFormControlTextarea1">{{ __('Message') }}</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                        name="message"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 form-group mt-3">
                                <div id="image-preview" class="image-preview">
                                    <label for="image-upload" id="image-label">{{ __('Choose File') }}</label>
                                    <input type="file" name="file" id="image-upload" class="form-control" />
                                </div>
                            </div>

                            <div class="col-lg-12 mt-3 text-end">
                                    <button type="submit" class="btn main-btn ticket-reply"><i
                                            class="fas fa-reply"></i>
                                        {{ __('Reply') }}
                                    </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="ticket-reply-area mt-5">
                @forelse(@$ticket_reply as $ticket)
                    <div class="single-reply {{$ticket->admin_id != null ? 'admin-reply' : ''}}">
                        <span class="text-small sp_text_secondary mb-2">{{ 'Reply In' }} {{ $ticket->created_at->format('Y-m-d H:i:s') }}</span>
                        <p>
                            {{ $ticket->message }}
                        </p>
                        @if ($ticket->file)
                            <p class="mb-0 mt-2">
                                <a class="color-change" href="{{ route('user.ticket.download', $ticket->id) }}"> <i class="fas fa-cloud-download-alt"></i> {{ __('View Attachement') }}</a>
                            </p>
                        @endif
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
@endsection
