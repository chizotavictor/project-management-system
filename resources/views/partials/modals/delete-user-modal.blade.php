<div class="modal fade zoom" tabindex="-1" id="{{ $modalId }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Delete User</h3>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </a>
            </div>
            <div class="modal-body">
                <form action="{{ route('staff.delete') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $id }}">
                    <p>Are you sure you want to delete this user?</p>
                    <button type="submit" class="btn btn-primary float-right mt-4">
                        <span>Yes</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
