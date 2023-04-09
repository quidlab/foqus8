<!-- Main content -->

<div class="container-fluid">
    <!-- Info boxes -->
    <div id="AdminTools">
        <div class="table-responsive">
            <button class="btn btn-danger" data-toggle="modal" data-target="#myDeleteModal">
                <i class="fa fa-trash"></i> Delete Test Data </button>
        </div>
    </div>
</div><!--/. container-fluid -->

<!-- /.content -->

<!-- /.content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- Remove Modal Start -->
<div class="modal modal_remove_pres" id="myDeleteModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Remove Test Data</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                Do you want to remove Test Data?
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" data-dismiss="modal" onclick="deleteAllRows()">Remove Item</button>
            </div>

        </div>
    </div>
</div>
<!-- Remove Modal End -->

<script>
    //presenter data delete
    function deleteAllRows() {
        //console.log(actionData);
        //alert(actionData);
        var geVal = 'eData';
        $("tbody").remove();
        $.ajax({
            url: "admin-tools-script.php",
            method: "POST",
            data: {
                'deleteAllRows': geVal
            },
            success: function(regResponse) {
                let regResponseData = JSON.parse(regResponse);
                if (regResponseData.message == '1') {
                    new PNotify({
                        title: 'Success!',
                        text: regResponseData.status,
                        type: 'success',
                        nonblock: {
                            nonblock: true
                        },
                        styling: 'bootstrap3'
                    });
                } else {
                    new PNotify({
                        title: 'Command Failed!',
                        text: regResponseData.status,
                        type: 'danger',
                        nonblock: {
                            nonblock: true
                        },
                        styling: 'bootstrap3'
                    });
                }
            },
            error: function(error) {
                new PNotify({
                    title: 'Error!',
                    text: 'Something went wrong, refresh the page and check later.',
                    type: 'error',
                    nonblock: {
                        nonblock: true
                    },
                    styling: 'bootstrap3'
                });
            }
        });
    }


    // $('.modal_remove_pres').on('show.bs.modal', function(event) {
    // 	var button = $(event.relatedTarget)
    // 	var remid = button.data('remid')
    // 	$('#remid').val(remid);
    // })
</script>