   <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><?= __('logout-text-1') ?></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="/admin/logout" method="post">
          <div class="modal-body"><?= __('logout-text-2') ?></div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal"><?= __('cancel') ?></button>
            <button class="btn btn-primary" type="submit" href="/admin/logout"><? echo constant('TR_BTN_LOGOUT'); ?> </button>
          </div>
        </form>
      </div>
    </div>
  </div>