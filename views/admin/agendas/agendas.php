<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div id="AgendaGrid"></div>
    </div>
</section>


<div class="modal fade" id="AgendaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AgendaDetailModalLabel">Input Extra Fields</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="AgendaDetails"></div>
            <div class="modal-body" id="DirectorDetails"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

            </div>
        </div>
    </div>
</div>


<?php include __DIR__ . "/../../layouts/footer.php"; ?>
<?php include __DIR__ . "/../../layouts/scripts.php"; ?>

<script>
    $('#AgendaGrid').off().on('keydown', 'input[type=text], input[type=number]', (event) => {
        if (event.which === 13) { // Detect enter keypress
            // args.jsGrid.updateItem(); // Update the row
            $("#AgendaGrid").jsGrid("updateItem");
        }
    });
</script>
<script>
    var $pk = 0;
    var HaveDirector = false;
    var $AgnedaDispalyID = '';
    var PreviousVotingType = '';
    $(function() {

        var ButtonField = function(config) {
            jsGrid.Field.call(this, config);
        };
        ButtonField.prototype = new jsGrid.Field({
            //css: "date-field", // redefine general property 'css'
            align: "center", // redefine general property 'align'
            filtering: false,
            sorting: false,
            editing: false,
            label: "+",
            onClick: $.noop,
            itemTemplate: function(value, item) {
                var self = this;
                var $customButton = $("<button>")
                    .text(this.label)
                    .click(function(e) {
                        $pk = item.ID;
                        $AgnedaDispalyID = 'Details for Agenda: ' + item.AGENDA_ID;
                        $('#AgendaDetailModalLabel').html($AgnedaDispalyID);
                        $('#AgendaModal').modal('show');
                        $("#AgendaDetails").jsGrid("loadData");
                        $('#DirectorDetails').hide();
                        if (item.Voting_Required === "C" || item.Voting_Required === "S") {
                            HaveDirector = true;
                            $("#DirectorDetails").jsGrid("loadData");
                            $('#DirectorDetails').show();
                        }
                        self.onClick(item);
                        e.stopPropagation();
                    });
                return $customButton;
            }
        });
        jsGrid.fields.button = ButtonField;

        $("#AgendaGrid").jsGrid({
            width: "100%",
            height: "auto",
            inserting: true,
            editing: true,
            deleting: true,
            sorting: false,
            paging: true,
            autoload: true,
            pageSize: 10,
            pageButtonCount: 5,
            deleteConfirm: "Do you really want to delete data?",
            filtering: false,
            controller: {
                loadData: function(filter) {
                    return $.ajax({
                            type: "GET",
                            url: "/admin/agendas",
                            data: filter
                        }).then(res => res.data)
                        .fail(function(err) {
                            alert(JSON.stringify(err));
                        });

                },
                insertItem: function(item) {
                    return $.ajax({
                        type: "POST",
                        url: "/admin/agendas",
                        data: item
                    }).then(res => {
                        if (res.status) {
                            toastr.success(res.message);
                        } else {
                            toastr.error(res.message);
                        }
                    });
                },
                updateItem: function(item) {

                    return $.ajax({
                        type: "PUT",
                        url: "/admin/agendas",
                        data: item
                    }).then(res => {
                        if (res.status) {
                            toastr.success(res.message);
                        } else {
                            toastr.error(res.message);
                        }
                    });
                },
                deleteItem: function(item) {

                    return $.ajax({
                        type: "DELETE",
                        url: "/admin/agendas",
                        data: item
                    }).then(res => {
                        if (res.status) {
                            toastr.success(res.message);
                        } else {
                            toastr.error(res.message);
                        }
                    });
                },
            },
            onItemInserted: function(args) {
                // prints [{ field: "Name", message: "Enter client name" }]
                console.log(args.item);
                //$('#logoutModal').modal('show');
            },
            onItemEditing: function(args) {
                PreviousVotingType = args.item.Voting_Required;
            },
            //onItemUpdated: function (args) { if ((PreviousVotingType == 'S' || PreviousVotingType == 'C' ) && (args.item.Voting_Required != 'C' || args.item.Voting_Required != 'S' ) ) { args.cancel = true; alert('You can not Change Cumulative/Selection to Normal');  };$("#AgendaGrid").jsGrid("loadData"); },
            onItemUpdated: function(args) {
                $("#AgendaGrid").jsGrid("loadData");
            },
            onItemUpdating: function(args) {
                if (args.item.Voting_Required === "C" || args.item.Voting_Required === "S") {
                    if (args.item.NumberOfDirectorsToEleect < 1) {
                        args.cancel = true;
                        alert("Check Number of Directors to Elect ");
                    }
                }

            },
            onItemInserting: function(args) {
                if (args.item.Voting_Required === "C" || args.item.Voting_Required === "S") {
                    if (parseInt(args.item.NumberOfDirectorsToEleect) < 1) {
                        args.cancel = true;
                        alert("Check Number of Directors to Elect ");
                    }
                }

            },
            onError: function(args) {
                // prints [{ field: "Name", message: "Enter client name" }]
                console.log(args.item);

            },

            fields: [

                {
                    name: "ID",
                    type: "text",
                    editing: false,
                    visible: false
                },
                {
                    name: "BTN",
                    title: "",
                    type: "button",
                    editing: false,
                    width: 10
                },
                {
                    name: "Sort_ID",
                    title: "Sort",
                    type: "text",
                    editing: true,
                    width: 30,
                    validate: "required"
                },
                {
                    name: "AGENDA_ID",
                    title: "AG ID",
                    type: "text",
                    width: 25,
                    validate: "required"
                },
                {
                    name: "Special_Formula",
                    title: "Formula",
                    type: "select",
                    width: 100,
                    items: [{
                            Name: "NORMAL",
                            Id: 'NORMAL'
                        },
                        {
                            Name: "EXCLUDE_ABSTAIN",
                            Id: 'EXCLUDE_ABSTAIN'
                        },
                        {
                            Name: "EXCLUDE_VOID",
                            Id: 'EXCLUDE_VOID'
                        },
                        {
                            Name: "EXCLUDE_ABSTAIN_AND_VOID",
                            Id: 'EXCLUDE_ABSTAIN_AND_VOID'
                        },
                        {
                            Name: "EXCLUDE_NO_VOTE",
                            Id: 'EXCLUDE_NO_VOTE'
                        },
                        {
                            Name: "EXCLUDE_NO_VOTE_AND_VOID",
                            Id: 'EXCLUDE_NO_VOTE_AND_VOID'
                        },
                        {
                            Name: "EXCLUDE_ABSTAIN_AND_VOID_AND_NOVOTE",
                            Id: 'EXCLUDE_ABSTAIN_AND_VOID_AND_NOVOTE'
                        }
                    ],
                    valueField: "Id",
                    textField: "Name",
                    validate: "required",
                    filtering: true,
                    editing: true

                },
                {
                    name: "Voting_Required",
                    title: "Voting",
                    type: "select",
                    items: [

                        {
                            Name: "YES",
                            Id: 'Y'
                        },
                        {
                            Name: "NO",
                            Id: 'N'
                        },
                        {
                            Name: "CUMULATIVE",
                            Id: 'C'
                        },
                        {
                            Name: "SELECTION",
                            Id: 'S'
                        }
                    ],
                    valueField: "Id",
                    textField: "Name",
                    validate: "required",
                    filtering: true,
                    width: 35,
                    editing: true
                },
                {
                    name: "Reverse_Vote",
                    title: "INITIAL VOTE",
                    type: "select",

                    items: [

                        {
                            Name: "Approve",
                            Id: 'Approve'
                        },
                        {
                            Name: "DisApprove",
                            Id: 'DisApprove'
                        },
                        {
                            Name: "Abstain",
                            Id: 'Abstain'
                        },
                        {
                            Name: "NoVote",
                            Id: 'NoVote'
                        }
                    ],
                    valueField: "Id",
                    textField: "Name",
                    validate: "required",
                    filtering: true,
                    width: 50,
                    editing: true

                },
                {
                    name: "Approval_Percent",
                    title: "Approval",
                    valueField: "Id",
                    textField: "Name",
                    type: "select",
                    width: 30,
                    editing: true,
                    items: [{
                            Name: "Majorty",
                            Id: 'Majorty'
                        },
                        {
                            Name: "One Third",
                            Id: 'OneThird'
                        },
                        {
                            Name: "Two Third",
                            Id: 'TwoThird'
                        },
                        {
                            Name: "One Half",
                            Id: 'Half'
                        }
                    ],
                    validate: "required"
                },
                {
                    name: "NumberOfDirectorsToEleect",
                    title: "Directors to Select",
                    type: "text",
                    width: 30,
                    validate: {
                        validator: "range",
                        param: [0, 50]
                    }
                },
                {
                    name: "Voting_Started",
                    title: "Voting Started",
                    type: "select",

                    items: [

                        {
                            Name: "YES",
                            Id: 'Y'
                        },
                        {
                            Name: "NO",
                            Id: 'N'
                        }

                    ],
                    valueField: "Id",
                    textField: "Name",
                    validate: "required",
                    filtering: true,
                    width: 30,
                    editing: true

                },
                {
                    name: "Percent_Based_On_FullShares",
                    title: "% on Full Shares",
                    type: "select",

                    items: [{
                            Name: "NO",
                            Id: 'N'
                        },
                        {
                            Name: "YES",
                            Id: 'Y'
                        }


                    ],
                    valueField: "Id",
                    textField: "Name",
                    validate: "required",
                    filtering: true,
                    width: 30,
                    editing: true

                },
                {
                    type: "control",
                    //insertButton:true,
                    editButton: true, // show edit button
                    deleteButton: true // show delete button

                }
            ]

        });
    });
    $(document).ready(function() {
        $(document).ajaxError(function() {
            alert("An error occured in ajax call!");
        });
    });
</script>
<script>
    $(function() {
        console.log($pk);
        $("#AgendaDetails").jsGrid({
            width: "auto%",
            height: "auto",
            inserting: false,
            editing: true,
            deleting: false,
            sorting: false,
            paging: true,
            autoload: true,
            pageSize: 10,
            pageButtonCount: 5,
            controller: {
                loadData: function(filter) {
                    return $.ajax({
                        type: "GET",
                        url: "/admin/agenda-details?ID=" + $pk,
                        data: filter
                    }).then(res => res.data)
                },
                insertItem: function(item) {
                    return $.ajax({
                        type: "POST",
                        url: "/admin/agenda-details",
                        data: item
                    }).then(res => {
                        if (res.status) {
                            toastr.success(res.message);
                        } else {
                            toastr.error(res.message);
                        }
                    });
                },
                updateItem: function(item) {
                    return $.ajax({
                        type: "PUT",
                        url: "/admin/agenda-details",
                        data: item
                    }).fail(function(err) {
                        alert(JSON.stringify(err));
                    }).then(res => {
                        if (res.status) {
                            toastr.success(res.message);
                        } else {
                            toastr.error(res.message);
                        }
                    });
                },
                deleteItem: function(item) {
                    return $.ajax({
                        type: "DELETE",
                        url: "/admin/agenda-details",
                        data: item
                    }).then(res => {
                        if (res.status) {
                            toastr.success(res.message);
                        } else {
                            toastr.error(res.message);
                        }
                    });
                },
            },
            onItemInserted: function(args) {
                // prints [{ field: "Name", message: "Enter client name" }]
                console.log(args.item);
                //$('#logoutModal').modal('show');
            },
            onError: function(args) {
                // prints [{ field: "Name", message: "Enter client name" }]
                console.log(args.item);

            },
            onItemEditing: function(args) {
                //if(args.item='Agenda_Name') { self.args.item.width='100';  }
            },

            fields: [{
                name: "ID",
                type: "text",
                editing: false,
                visible: false
            }, {
                name: "AGENDAID",
                title: "AG ID",
                type: "text",
                editing: true,
                width: 10,
                validate: "required",
                visible: false
            }, {
                name: "Agenda_Name",
                title: "Agenda",
                type: "textarea",
                width: 50,
                validate: "required"
            }, {
                name: "Agenda_Info",
                title: "Info",
                type: "textarea",
                width: 30,
                editing: true
            }, {
                name: "Approve_Text",
                title: "Approve",
                type: "text",
                width: 25,
                editing: true
            }, {
                name: "DisApprove_Text",
                title: "DisApprove",
                type: "text",
                width: 25,
                validate: "required"
            }, {
                name: "Abstain_Text",
                title: "Abstain",
                type: "text",
                width: 25,
                validate: "required"
            }, {
                name: "NoVote_Text",
                title: "NoVote",
                type: "text",
                width: 30,
                validate: "required"
            }, {
                name: "Language",
                title: "Language",
                type: "text",
                width: 10,
                editing: false,
                validate: "required"
            }, {
                type: "control",
                editButton: true,
                width: 15,
                deleteButton: false
            }]

        });
    });
</script>
<script>
    $(function() {

        $("#DirectorDetails").jsGrid({
            width: "auto%",
            height: "auto",
            inserting: false,
            editing: true,
            deleting: true,
            sorting: false,
            paging: true,
            autoload: true,
            filtering: false,
            pageSize: 10,
            pageButtonCount: 5,
            controller: {

                loadData: function(filter) {
                    return $.ajax({
                        type: "GET",
                        url: "/admin/directors?Agenda_ID=" + $pk,
                        data: filter
                    }).then(res => res.data);
                },
                insertItem: function(item) {
                    return $.ajax({
                        type: "POST",
                        url: "/admin/directors",
                        data: item
                    });
                },
                updateItem: function(item) {

                    return $.ajax({
                        type: "PUT",
                        url: "/admin/directors",
                        data: item
                    }).then(res => {
                        if (res.status) {
                            toastr.success(res.message);
                        } else {
                            toastr.error(res.message);
                        }
                    });
                },
                deleteItem: function(item) {

                    return $.ajax({
                        type: "DELETE",
                        url: "/admin/directors",
                        data: item
                    }).then(res => {
                        if (res.status) {
                            toastr.success(res.message);
                        } else {
                            toastr.error(res.message);
                        }
                    });
                },
            },
            onItemInserted: function(args) {
                // prints [{ field: "Name", message: "Enter client name" }]
                console.log(args.item);
                //$('#logoutModal').modal('show');
            },
            onError: function(args) {
                // prints [{ field: "Name", message: "Enter client name" }]
                console.log(args.item);

            },
            onItemEditing: function(args) {
                //alert($pk);
                //args.item.ID=$pk;
                //if(args.item='Agenda_Name') { self.args.item.width='100';  }
            },
            onItemInserting: function(args) {
                //if(args.item='Agenda_Name') { self.args.item.width='100';  }
                //alert($pk);
                //args.item.ID=$pk;
            },

            fields: [{
                    name: "ID",
                    type: "text",
                    editing: false,
                    inserting: false,
                    visible: false
                }, {
                    name: "Agenda_ID",
                    title: "AG ID",
                    type: "",
                    editing: false,
                    width: 10,
                    validate: "required",
                    inserting: false,
                    visible: false
                },
                {
                    name: "Director_ID",
                    title: "Director ID",
                    type: "text",
                    width: 50,
                    editing: false
                },
                {
                    name: "Director_Name",
                    title: "Director Name",
                    type: "text",
                    width: 50,
                    validate: "required"
                }, {
                    name: "Language",
                    title: "Language",
                    type: "text",
                    width: 10,
                    editing: false,
                    //filtering: true,
                    validate: "required"
                }, {
                    type: "control",
                    editButton: true,
                    width: 15,
                    deleteButton: true
                }
            ]

        });
    });
</script>