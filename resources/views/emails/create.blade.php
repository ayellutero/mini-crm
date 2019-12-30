@extends('layouts.admin-app')

@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/datetimepicker@latest/dist/DateTimePicker.min.css" />
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> -->
<style>
textarea {
    resize: vertical;
}
</style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Send Email</div>

                <div class="card-body">
                    @if(Session::has('message'))
                    <div class="alert alert-{{ Session::get('message.status') }} alert-dismissible fade show" role="alert">
                        {{ Session::get('message.text') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" @auth('employee') action="{{ route('e.emails.send') }}" @else action="{{ route('emails.send') }}" @endauth enctype="multipart/form-data" id="send-email-form">
                    @csrf
                        <div class="form-row">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Recipient</span>
                                </div>
                                <input type="text" aria-label="Name" class="form-control @error('recipient_name') is-invalid @enderror" name="recipient_name" value="{{ old('recipient_name') }}" placeholder="Name">
                                <input type="text" aria-label="Email" class="form-control @error('recipient_email') is-invalid @enderror" name="recipient_email" value="{{ old('recipient_email') }}" placeholder="Email">
                            </div>
                        </div>

                        <div class="form-row my-2">
                            <textarea type="text" class="form-control @error('message') is-invalid @enderror" id="message" name="message" value="{{ old('message') }}" placeholder="Type message" maxlength=1000 rows=10></textarea>
                            @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-row my-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Sender</span>
                                </div>
                                <input type="text" aria-label="Name" class="form-control @error('sender_name') is-invalid @enderror" name="sender_name" value="{{ old('sender_name') }}" placeholder="Name">
                                <input type="text" aria-label="Email" class="form-control @error('sender_email') is-invalid @enderror" name="sender_email" value="{{ old('sender_email') }}" placeholder="Email">
                            </div>
                        </div>
                        <input type="hidden" name="scheduled_at">
                        <hr class="mt-4">
                        <div class="row">
                            <div class="col-4 d-flex justify-content-start">
                                <a href="#" class="btn btn-outline-primary send-later-btn" data-toggle="modal" data-target="#schedule-email-modal">Send Later</a>
                            </div>
                            <div class="col-8 d-flex justify-content-end">
                                <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button href="#" class="btn btn-outline-primary ml-2 send-now-btn">Send Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('emails.partials.schedule-modal')
@endsection

@section('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/datetimepicker@latest/dist/DateTimePicker.min.js"></script>
<script defer>
$(document).ready(() => {
    

    $('#schedule-email-modal').on('show.bs.modal', function (e) {
        var today = new Date().getFullYear() + '-' + (new Date().getMonth() + 1) + '-' + new Date().getDate();
        var minTime = new Date().getHours() + ':' + (new Date().getMinutes() + 2);
        var minTimeOpt = {
            [today]: {
                minTime: minTime,
                maxTime: '23:59',
            }
        }

        // change minimum time every time the modal is shown
        $('#schedule-email-modal input[name=schedule]').flatpickr({
            enableTime: true,
            dateFormat: 'Y-m-d H:i',
            minDate: 'today',
            plugins: [
                new minMaxTimePlugin({
                    table: minTimeOpt
                }),
            ]
        });
    });

    $('#schedule-email-modal input[name=schedule]').on('change', (e) => {
        var sch = $(e.target).val();
        // set schedule for sending at specific time
        $('#send-email-form input[name=scheduled_at]').val(sch);
    });

    $('.set-schedule-btn').on('click', () => {
        $('#send-email-form').submit();
    });

    $('.cancel-schedule-btn').on('click', () => {
        // clear set schedule
        $('#send-email-form input[name=scheduled_at]').val('');
    });
});
</script>
@endsection