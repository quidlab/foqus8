<script>
    var yes = <?php echo $CountData3[0]['Approved']; ?>;
    var no = <?php echo $CountData2[0]['notApproved']; ?>;
    var totalcoowners = <?php echo $TotCoowners; ?>;
    var totalcoownerVotes = <?php echo $TotCoownerVotes; ?>;
</script>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Donut Chart -->
            <div class="col-xl-4 col-lg-4">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Login Chart</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-4">
                            <canvas id="myPieChart"></canvas>
                        </div>
                        <hr />
                        <span>
                            <script>
                                document.write("Approved: " + yes + " | Not Approved: " + no);
                            </script>
                        </span><br>
                        <span>
                            <script>
                                document.write("Total Units: " + totalcoowners.toLocaleString() + " | Total Votes: " + totalcoownerVotes.toLocaleString());
                            </script>
                        </span>
                        <hr />
                        <button type="submit" onclick="updateData()" id="updateButton" data-egmid="updateEGMData" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Update Data</button>

                        <a href="" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-spinner fa-sm text-white-50"></i> Refresh Data</a>
                        <!--</form>-->
                    </div>
                </div>
            </div>

            <div id="tableEGM" class="col-xl-8 col-lg-8">
                <div class="card">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3">
                        <div class="col-sm-6 text-right  float-right">
                            <div class="sendEmailContainer ">
                                <button onclick="sendMany()" class="m-0 font-weight-bold text-primary sendingEmail">Send 1000 Emails <i class='fa fa-paper-plane'></i></button>

                            </div>
                        </div>
                        <div class="col-sm-6 text-left">
                            <h6 class="m-0 font-weight-bold text-primary">EGM Table</h6>
                        </div>
                    </div>
                    <div id="Grid"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

<?php include __DIR__ . "/../layouts/footer.php"; ?>
<?php include __DIR__ . "/../layouts/scripts.php"; ?>


<script>
    $("#Grid").jsGrid({
        width: "100%",
        editing: true,
        inserting: true,
        deleting: true,
        sorting: true,
        paging: true,
        autoload: true,
        pageSize: 20,
        pageButtonCount: 5,
        deleteConfirm: "Do you really want to delete data?",
        filtering: false,
        controller: {
            loadData: function(filter) {
                return $.ajax({
                    type: "GET",
                    url: "/api/admin/shareholders",
                    data: filter
                });
            },
            deleteItem: function(item) {

                return $.ajax({
                    type: "DELETE",
                    url: "/api/admin/shareholders",
                    data: item
                }).then(res => {
                    if (res.status) {
                        toastr.success(res.message)
                    } else {
                        toastr.error(res.message)
                    }
                });
            },
            updateItem: function(item) {
                return $.ajax({
                    type: "PUT",
                    url: "/api/admin/shareholders",
                    data: item
                }).then(res => {
                    if (res.status) {
                        toastr.success(res.message)
                    } else {
                        toastr.error(res.message)
                    }
                });
            },

        },
        fields: [{
                name: "username",
                title: <?= "'" . __('username') . "'" ?>,
                type: "text",
                editing: true,
            },
            {
                name: "password",
                title: <?= "'" . __('password') . "'" ?>,
                type: "text",
                editing: true,
            },
            {
                name: "i_holder",
                title: <?= "'" . __('i_holder') . "'" ?>,
                type: "text",
                editing: true,
            },
            {
                title: 'email',
                name: 'email',
                type: "text",
                editing: true,

            },
            {
                name: "",
                title: 'login',
                type: "custom",
                editing: false,
                itemTemplate(value, item) {
                    console.log(item.status);
                    console.log(item.ID);

                    return `
                    <div class="jsgrid-align-center" >
                        <button onclick="toggleStatus(${item.ID},${item.status})" class='btn btn-sm  ${item.status?'btn-success':'btn-info'}'>${item.status?'active':'pending'}</button>
                    </div>
                    `;
                },
            },
            {
                title: 'send email',
                name: 'ID',
                type: "custom",
                editing: false,
                itemTemplate(value, item) {

                    return `
                    <div class="jsgrid-align-center" >
                        <button onclick="sendEmail(${value})" class='btn btn-sm  ${value?'btn-success':'btn-primary'}'>Send ${item['email-sent']}</button>
                    </div>
                    `;
                },
            },
            {
                type: "control",
                editButton: true, // show edit button
                deleteButton: false, // show delete button
            }
        ]

    });
</script>

<script>
    function sendEmail(ID) {
        $.ajax({
            method: 'POST',
            url: '/api/admin/shareholders/email',
            data: {
                'ID': ID
            }
        }).then(res => {
            console.log(res);
            if (res.status) {
                toastr.success(res.message)
            } else {
                toastr.error(res.message)
            }
        })
    }
    function toggleStatus(ID,status) {
        $.ajax({
            method: 'PUT',
            url: '/api/admin/shareholders/status',
            data: {
                'ID': ID,
                'status':status?0:1
            }
        }).then(res => {
            console.log(res);
            if (res.status) {
                toastr.success(res.message)
            } else {
                toastr.error(res.message)
            }
        })
    }

    function sendMany() {
        $.ajax({
            method: 'POST',
            url: '/api/admin/shareholders/email/many',
        }).then(res => {
            console.log(res);
            if (res.status) {
                toastr.success(res.message)
            } else {
                toastr.error(res.message)
            }
        })
    }

    function updateData() {
        $.ajax({
            method: 'POST',
            url: '/api/admin/shareholders/update-data',
        }).then(res => {
            console.log(res);
            if (res.status) {
                toastr.success(res.message)
            } else {
                toastr.error(res.message)
            }
        })
    }
</script>

<script src="<?= assets('/assets/custom.js') ?>"></script>