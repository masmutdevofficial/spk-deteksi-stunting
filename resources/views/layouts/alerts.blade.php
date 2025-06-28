@if(session('success') || session('error'))
    <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 1rem; right: 1rem; z-index: 9999;">
        <div class="toast show text-white {{ session('success') ? 'bg-success' : 'bg-danger' }}" id="liveToast" role="alert" data-delay="3000" style="min-width: 250px;">
            <div class="toast-header {{ session('success') ? 'bg-success text-white' : 'bg-danger text-white' }}">
                <strong class="mr-auto">{{ session('success') ? 'Sukses' : 'Gagal' }}</strong>
                <small>Barusan</small>
                <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close" onclick="document.getElementById('liveToast').remove();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                {{ session('success') ?? session('error') }}
            </div>
        </div>
    </div>
@endif
