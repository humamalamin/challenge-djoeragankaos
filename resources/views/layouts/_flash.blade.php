@if (session()->has('flash_notification.message'))
    <div class="alert alert-{{ session()->get('flash_notification.level') }}">
        {{ session()->get('flash_notification.message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif