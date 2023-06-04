<!-- Main content -->

<div class="container-fluid">
    <!-- Info boxes -->
    <div id="AdminTools">
        <div class="table-responsive min-vh-100">

            <!-- Example split danger button -->
            <div class="btn-group">
                <select id="WithUsers" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <option class="without-users">Without users</option>
                    <option value="with-users">With Users</option>
                </select>
                <button class="btn btn-danger" data-toggle="modal" data-target="#myDeleteModal">
                    <i class="fa fa-trash"></i> <?= __('delete-test-data') ?>
                </button>
            </div>


            <!-- Example split primary button -->
            <div class="btn-group ml-4">
                <select id="WithUsers" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <option class="without-users">Option 1</option>
                    <option value="with-users">Option 2</option>
                </select>
                <button class="btn btn-primary" data-toggle="modal" data-target="#myDeleteModal">
                     <?= __('make-meeting-for') ?>
                </button>
            </div>
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
            data: {
                'with-users': $('#WithUsers').val()
            },
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