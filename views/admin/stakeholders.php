<div class="card card-primary">
    <div class="card-header">
        <h3><?= __('files')  ?></h3>
    </div>
    <div class="card-body">
        <table class="" id="StakeHoldersGrid"></table>

    </div>
</div>


<?php include __DIR__ . "/../layouts/footer.php"; ?>
<?php include __DIR__ . "/../layouts/scripts.php"; ?>


<script>
    $("#StakeHoldersGrid").jsGrid({
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
                    url: "/api/admin/stakeholders",
                    data: filter
                });
            },
            updateItem: function(item) {

                return $.ajax({
                    type: "PUT",
                    url: "/api/admin/stakeholders",
                    data: item
                }).then(res => {
                    if (res.status) {
                        toastr.success(res.message)
                    } else {
                        toastr.error(res.message)
                    }
                });
            },
            insertItem: function(item) {
                return $.ajax({
                    type: "POST",
                    url: "/api/admin/stakeholders",
                    data: item
                }).then(res => {
                    if (res.status) {
                        toastr.success(res.message)
                    } else {
                        toastr.error(res.message)
                    }
                });
            },
            deleteItem: function(item) {
                return $.ajax({
                    type: "DELETE",
                    url: "/api/admin/stakeholders",
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
                name: "i_holder",
                title: <?= "'" . __('i_holder') . "'" ?>,
                type: "text",
                editing: true,
            },
            {
                name: "Agenda_ID",
                title: <?= "'" . __('Agenda_ID') . "'" ?>,
                type: "select",
                items: [
                    <?
                    foreach ($agendas as  $agenda) {
                        echo "{Id: " . $agenda['ID'] . ",Name:'" . $agenda['AGENDA_ID'] . "'},";
                    }
                    ?>
                ],
                editing: true,
                valueField: "Id",
                textField: "Name",
            },
            {
                name: "vote-type",
                title: <?= "'" . __('vote-type') . "'" ?>,
                type: "select",
                items: [
                    "Approved",
                    "NotApproved",
                    "Abstain",
                    "NoVote",
                    "StakeHolder",
                ],
                editing: true,
            },
            {
                name: "q_share",
                title: <?= "'" . __('q_share') . "'" ?>,
                type: "text",
                editing: true,
            },
            {
                type: "control",
                editButton: true, // show edit button
                deleteButton: true, // show delete button
            }
        ]

    });
</script>
