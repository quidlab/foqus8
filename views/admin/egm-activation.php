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

            <div id="tableEGM" class="">
                <div class="card">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 row">
                        <div class="text-left">
                            <h6 class="m-0 font-weight-bold text-primary">EGM Table</h6>
                            <section>
                                <input id="searchInput" type="text">
                                <button onclick="search(this)"><?= __('search') ?></button>
                            </section>
                        </div>

                        <div class=" text-center">
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
                        </div>
                        <div class="text-right">
                            <div class="sendEmailContainer ">
                                <button type="submit" onclick="updateData()" id="updateButton" data-egmid="updateEGMData" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Update Data</button>
                                <a href="" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-spinner fa-sm text-white-50"></i> Refresh Data</a>
                                <button onclick="sendMany()" class="m-0 font-weight-bold text-primary sendingEmail">Send 1000 Emails <i class='fa fa-paper-plane'></i></button>
                            </div>
                        </div>
                    </div>
                    <div id="Grid"></div>
                    <!-- <div id="Grid2"></div> -->
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
        editing: false,
        inserting: false,
        deleting: true,
        pageLoading: true,
        sorting: true,
        paging: true,
        pageNextText: "<?= __("next") ?>",
        pagePrevText: "<?= __("prev") ?>",
        pageSize: 10,
        pageIndex: 1,
        autoload: true,
        pageButtonCount: 5,
        deleteConfirm: "Do you really want to delete data?",
        filtering: false,
        controller: {
            loadData: function(filter) {
                let search = $('#searchInput').val();

                filter.search = search
                return $.ajax({
                    type: "GET",
                    url: "/api/admin/shareholders",
                    data: filter
                }).then(res => {
                    console.log(res);
                    return {
                        data: res,
                        itemsCount: 1000 // MOSTAFA_TODO
                    };
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
                editing: false,
            },
            {
                name: "n_title",
                title: <?= "'" . __('title') . "'" ?>,
                type: "text",
                editing: true,
            },
            {
                name: "n_first",
                title: <?= "'" . __('first name') . "'" ?>,
                type: "text",
                editing: true,
            },
            {
                name: "n_last",
                title: <?= "'" . __('last name') . "'" ?>,
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
                title: 'phone',
                name: 'm_phone',
                type: "text",
                editing: true,

            },
            {
                name: "",
                title: 'login',
                type: "custom",
                editing: false,
                itemTemplate(value, item) {
                    return `
                    <div class="jsgrid-align-center" >
                        <button onclick="toggleStatus(${item.ID},'${item.ApprovedForOnline}')" class='btn btn-sm  ${item.ApprovedForOnline == 'Y'?'btn-success':'btn-info'}'>${item.ApprovedForOnline == 'Y'?'active':'pending'}</button>
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
                    if (item.ApprovedForOnline == 'Y') {
                        return `
                        <div class="jsgrid-align-center" >
                            <button onclick="sendEmail(${value})" class='btn btn-sm  ${value?'btn-success':'btn-primary'}'>Send ${item['email-sent']}</button>
                        </div>
                        `;
                    } else {
                        return '';
                    }
                },
            },
            {
                type: "custom",
                itemTemplate(value, item) {
                    return `
                        <div class="jsgrid-align-center">
                            <button onclick='Edit(${JSON.stringify(item)})' class='btn btn-sm btn-primary'>Edit</button>
                        </div>
                        `;
                },
            },
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
                $("#Grid").jsGrid("search")
            } else {
                toastr.error(res.message)
            }
        })
    }

    function toggleStatus(ID, ApprovedForOnline) {
        $.ajax({
            method: 'PUT',
            url: '/api/admin/shareholders/status',
            data: {
                'ID': ID,
                'ApprovedForOnline': ApprovedForOnline == 'Y' ? 'N' : 'Y'
            }
        }).then(res => {
            console.log(res);
            if (res.status) {
                toastr.success(res.message)
                $("#Grid").jsGrid("search")
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


    function Edit(item) {
        console.log(item);
        $('body').append(`
            <div id="editPopup" class='popup'>
                <div class='popup-body'>
                <div class="modal-content" style="width: max-content;">
				<div class="modal-body">
                <form id="editForm">
				<div class="col-lg-12">
					<div class="p-10">
					  <div class="text-center">
						<h1 class="h4 text-gray-900 mb-4">Update Profile</h1>
					  </div>
						<div class="form-group row">
						  <div class="col-sm-12 mb-3 mb-sm-0">
							<input type="text" class="form-control form-control-user" id="title" placeholder="Title" required="required" name="n_title" readonly="" value="${item.n_title??''}">
						  </div>
						</div>
						<div class="form-group row">
						  <div class="col-sm-12 mb-3 mb-sm-0">
							<input type="text" class="form-control form-control-user" id="first" placeholder="First Name" required="required" name="n_first" readonly="" value="${item.n_first??''}">
						  </div>
						</div>
						<div class="form-group row">
						  <div class="col-sm-12">
							<input type="text" class="form-control form-control-user" id="last" placeholder="Last Name" required="required" name="n_last" readonly="" value="${item.n_last??''}">
						  </div>
						</div>
						<div class="form-group">
						  <input type="email" class="form-control form-control-user" id="email" placeholder="Email Address" required="required" name="email" value="${item.email??''}">
						</div>
						<div class="form-group row">
						  <div class="col-sm-6 mb-3 mb-sm-0">
							<input type="text" class="form-control form-control-user" id="phone" placeholder="Mobile No" name="m_phone" value="${item.m_phone??''}">
						  </div>
						  <div class="col-sm-6 mb-3 mb-sm-0">
							<select name="Proxy" class="form-control" value="${item.ApprovedForOnline}" id="proxy" required="required">
							  <option value="">Set Proxy</option>
							  <option ${item.ApprovedForOnline == 'N' ?'selected':''} value="N">No</option>
							  <option ${item.ApprovedForOnline == 'Y' ?'selected':''} value="Y">Yes</option>
							</select>
						  </div>
						</div>
						<div class="form-group row">
						  <div class="col-sm-6 mb-3 mb-sm-0">
							<input type="text" class="form-control form-control-user" placeholder="Proxy Name" name="Proxy_name" value="${item.Proxy_name??''}">
						  </div>
						  <div class="col-sm-6">
							<select name="ProxyType" class="form-control">
							  <option value="">Type of Proxy</option>
							  <option ${item.ProxyType == 'A' ?'selected':''} value="A">A</option>
							  <option ${item.ProxyType == 'B' ?'selected':''} value="B">B</option>
							</select>
						  </div>
						</div>
						<div class="form-group row">
						  <div class="col-sm-6 mb-3 mb-sm-0">
							<input type="text" class="form-control form-control-user" placeholder="Proxy ID" name="proxy_I_ref" value="${item.proxy_I_ref??''}">
						  </div>
						</div>
						<!--
						<div class="form-group row">
						  <div class="col-sm-6 mb-3 mb-sm-0">
							<input type="password" class="form-control form-control-user" id="pass1" placeholder="Password" required="required" name="pass" value="">
						  </div>
						  <div class="col-sm-6">
							<input type="password" class="form-control form-control-user" id="pass2" placeholder="Repeat Password" required="required" name="pass2" value="">
						  </div>
						</div>
						-->
					</div>
				</div>
				  <input style="display:none" value="${item.ID}" name="ID" id="egmid">

                </form>
				</div>
				<div>
					<input type="hidden" name="CSRFToken" value="5ae4a4da820e16c229cc5a51ac298ac5edc7aa9e584895fb">
					</div>
				<div class="modal-footer">
				  <button class="btn btn-secondary" onclick="CancelEdit()" type="button" data-dismiss="modal">Cancel</button>
				  <button onclick="Update()" class="btn btn-primary">Save</button>
				</div>
			  </div>
                </div>
            </div>
        `);
    }

    function CancelEdit() {
        $('#editPopup').remove();
    }

    function Update() {
        console.log('update');
        let form = $('#editForm').serializeArray();

        return $.ajax({
            type: "PUT",
            url: "/api/admin/shareholders",
            data: form
        }).then(res => {
            if (res.status) {
                toastr.success(res.message)
                $("#Grid").jsGrid("loadData");
                CancelEdit();
            } else {
                toastr.error(res.message)
            }
        });
    }
</script>


<script>
    function search(e) {
        $("#Grid").jsGrid("search")
    }
</script>