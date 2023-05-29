<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <p class="mt-4 mb-2 text-bold"><?= __('approve-online-joiners') ?></p>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width:10%">Srl No.</th>
                                <th style="width:20%">Description</th>
                                <th style="width:30%">Download</th>
                                <th style="width:40%" colspan="2">Upload</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <form action="/api/admin/shareholders/update/without-share" enctype="multipart/form-data" id="import_form" method="post">
                                    <td> 1 </td>
                                    <td>
                                        <p style="font-weight: bold; font-size: 14px;">Without Share</p>
                                    </td>
                                    <td>

                                        <a href="<?= assets('/assets/templates/update-shareholder-sample.xlsx') ?>" class="btn btn-info btn-sm">
                                            <i class="fa fa-download" aria-hidden="true"></i> Sample Data
                                        </a>
                                    </td>
                                    <td>
                                        <div class="upload-btn-wrapper">

                                            <input type="hidden" name="action" value="update_record">
                                            <input type="hidden" name="shorting_field" value="" id="after_shorting">
                                            <button class="btn btn-success btn-sm"><i class="fa fa-file-excel" aria-hidden="true"></i> Select Excel File</button>
                                            <input type="file" name="uploadFile" id='without_share_file' accept=".xlsx, .xls, .csv" required style="font-size: 20px;" />

                                        </div>
                                    </td>

                                    <td>
                                        <div class="upload-btn-wrapper">
                                            <button type="submit" class="btn-danger btn-sm cursor-pointer" disabled id="without_share_btn"><i class="fa fa-upload" aria-hidden="true"></i> Import</button>
                                        </div>
                                    </td>
                                </form>
                            </tr>

                            <tr>
                                <form action="/api/admin/shareholders/update/with-share" enctype="multipart/form-data" id="import_form2" method="post">
                                    <td> 2 </td>
                                    <td>
                                        <p style="font-weight: bold; font-size: 14px;">With Share</p>
                                    </td>
                                    <td>
                                        <a href="<?= assets('/assets/templates/update-shareholder-with-share-sample.xlsx') ?>" class="btn btn-info btn-sm">
                                            <i class="fa fa-download" aria-hidden="true"></i> Sample Data
                                        </a>
                                    </td>
                                    <td>
                                        <div class="upload-btn-wrapper">

                                            <input type="hidden" name="action" value="update_record_with_share">
                                            <input type="hidden" name="shorting_field" value="" id="after_shorting1">
                                            <button class="btn btn-success btn-sm"><i class="fa fa-file-excel" aria-hidden="true"></i> Select Excel File</button>
                                            <input type="file" name="uploadFile" id='with_share_file' accept=".xlsx, .xls, .csv" style="font-size: 20px;" required />

                                        </div>
                                    </td>

                                    <td>
                                        <div class="upload-btn-wrapper">
                                            <button type="submit" class="btn-danger btn-sm" disabled id="with_share_btn"><i class="fa fa-upload" aria-hidden="true"></i> Import</button>
                                        </div>
                                    </td>
                                </form>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- /.content -->








<?php include __DIR__ . "/../layouts/footer.php"; ?>
<?php include __DIR__ . "/../layouts/scripts.php"; ?>
<script type="text/javascript">
    $(document).ready(
        function() {
            $('#with_share_btn').attr('disabled', true);
            $('#with_share_file').change(
                function() {
                    if ($(this).val()) {
                        $('#with_share_btn').removeAttr('disabled');
                    } else {
                        $('#with_share_btn').attr('disabled', true);
                    }
                });
        });


    $(document).ready(
        function() {
            $('#without_share_btn').attr('disabled', true);
            $('#without_share_file').change(
                function() {
                    if ($(this).val()) {
                        $('#without_share_btn').removeAttr('disabled');
                    } else {
                        $('#without_share_btn').attr('disabled', true);
                    }
                });
        });
</script>

<script>
    <?
    foreach (errors() as $key => $value) {
        echo  'toastr.error("' . $value . '");';
    }

    ?>
</script>
<script>
    <?
    foreach (successes() as $key => $value) {
        echo  'toastr.success("' . $value . '");';
    }

    ?>
</script>