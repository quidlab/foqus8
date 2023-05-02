<!-- Main content -->

<div class="container-fluid">
    <!-- Info boxes -->
    <div id="AdminTools">
        <div class="table-responsive">
            <button class="btn btn-danger" data-toggle="modal" data-target="#myDeleteModal">
                <i class="fa fa-trash"></i> <?= __('delete-test-data') ?> </button>
        </div>
    </div>
</div><!--/. container-fluid -->

<?php include __DIR__ . "/../layouts/footer.php"; ?>
<?php include __DIR__ . "/../layouts/scripts.php"; ?>

<!-- Remove Modal Start -->
<div class="modal modal_remove_pres" id="myDeleteModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><?= __('delete-test-data') ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <?= __('remove-test-data-alert') ?>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?= __('close') ?></button>
                <button type="button" class="btn btn-success" data-dismiss="modal" onclick="deleteAllRows()"><?= __('submit') ?></button>
            </div>

        </div>
    </div>
</div>
<!-- Remove Modal End -->

<script>
    //presenter data delete
    function deleteAllRows() {
        $("tbody").remove();
        $.ajax({
            url: "/database/truncate",
            method: "POST",
            data: {},
            success: function(regResponse) {
                let regResponseData = regResponse;
                console.log(regResponseData);
                if (regResponseData.status) {
                    toastr.success(regResponseData.message)
                } else {
                    toastr.error(regResponseData.message)
                }
            },
            error: function(error) {
                toastr.error('Something went wrong!', '')
            }
        });
    }
</script>