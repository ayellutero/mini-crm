<!-- Modal -->
<div class="modal fade" id="schedule-email-modal" role="dialog" aria-labelledby="schedule-email-modal-title" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header pb-2 border-0">
                <span class="d-block h5 text-uppercase font-weight-bold"><i class="far fa-clock"></i> SCHEDULE EMAIL</span>
            </div>
            <div class="modal-body pt-0">
                <div class="form-group">
                    <label class="text-small font-weight-bold" for="schedule">Date and time you want your email sent</label>
                    <input type="text" class="form-control @error('schedule') is-invalid @enderror" id="schedule" name="schedule" value="{{ old('schedule') }}" placeholder="Date and time" data-field="datetime" readonly>
                    @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div id="dtBox"></div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cancel-schedule-btn" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-info set-schedule-btn">Set</button>
            </div>
        </div>
    </div>
</div>