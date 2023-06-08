<?
if (count($notValidColumns)) {
    echo '<div class="font-weight-bold text-danger text-center text-lg py-4 mb-2" >Columns (' . implode(",", $notValidColumns) . ') Are Not Valid, Please Update Required Fields From <a href="/admin/manage-company">Manage Company</a></div>';
} else {
?>


    <link rel="stylesheet" href="<?= assets('/assets/plugins/jqvmap/jqvmap.min.css') ?>" />
    <link rel="stylesheet" href="<?= assets('/assets/file.css') ?>" />
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Shareholer Selection -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 " style="display: inline;"><?= __('import-shareholders-data') ?></h6><span style="float: right" class="m-0 " id="log">
                    </span>

                </div>

                <div class="card-body">
                    <div id="result"></div>
                    <div class="columns">

                        <div class="col1">
                            <h6><?= __('required-files') ?></h6>
                            <ul id="" class="back">

                                <?
                                foreach ($requiredFields as $key => $value) {
                                    echo '<li id="' . $value->id . '" class="li-class">' . $value->title . '</li>';
                                }
                                ?>

                            </ul>
                            <iframe name="hidden-iframe" style="display: none;"></iframe>
                            <div class="upload-btn-wrapper">
                                <form action="agm/import.php" enctype="multipart/form-data" id="import_form" method="post" target="hidden-iframe">
                                    <input type="hidden" name="action" value="save_data">
                                    <input type="hidden" name="shorting_field" value="" id="after_shorting">
                                    <button class="btn btn-excel btn-sm"><?= __('select-excel-file') ?></button>
                                    <input required class="btn-excel" type="file" name="uploadFile" onchange="handleFile()" id='file' accept=".xlsx, .xls, .csv" />
                                </form>
                            </div>
                        </div>

                        <div class="col2">
                            <h6><?= __('fields-in-excel-files') ?></h6>
                            <ul id="sortable" class="back b1">
                                <!--      <li id="result" class="ui-state-default"></li> -->
                            </ul>
                            <button onclick="sortFields()" id="sort_btn" class="btn btn-primary btn-sm"><?= __('sort') ?></button>
                            <button id="import_btn" type="button" class="btn-primary btn-sm" style="display: none;"><?= __('import') ?></button>
                        </div>

                    </div>


                </div>
            </div>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
<? } ?>

<?php include __DIR__ . "/../layouts/footer.php"; ?>
<?php include __DIR__ . "/../layouts/scripts.php"; ?>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script src="<?= assets('/assets/xlsx.full.min.js') ?>"></script>
<script>
    $(function() {
        $("#sortable").sortable({
            revert: true
        });
        $("#draggable").draggable({
            connectToSortable: "#sortable",
            helper: "clone",
            revert: "invalid"
        });
        $("ul, li").disableSelection();
    });
</script>
<script>
    let requiredFieldsObj = <?= json_encode($requiredFields); ?>;
    let requiredFieldsArr = requiredFieldsObj.map(f => f.id);

    function extractHeader(ws) {
        const header = []
        const columnCount = XLSX.utils.decode_range(ws['!ref']).e.c + 1
        for (let i = 0; i < columnCount; ++i) {
            header[i] = ws[`${XLSX.utils.encode_col(i)}1`].v
        }
        return header
    }


    /* 
    
    */
    function handleFile() {
        const input = document.getElementById("file")
        const file = input.files[0]
        if (file.type !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            input.value = null;
            toastr.error("File Should be Excel File");
            return;

        }

        const reader = new FileReader()
        const rABS = !!reader.readAsBinaryString
        reader.onload = e => {
            /* Parse data */
            const bstr = e.target.result

            const wb = XLSX.read(bstr, {
                type: rABS ? 'binary' : 'array'
            })
            /* Get first worksheet */
            const wsname = wb.SheetNames[0]
            const ws = wb.Sheets[wsname]

            let header = extractHeader(ws)


            var ExcelData1 = XLSX.utils.sheet_to_json(ws, {
                header: 1
            });
            var ExcelData = XLSX.utils.sheet_to_json(ws);

            AddListItem(header)

            var ExcelDataMapped = ExcelData.map(ExcelData => {
                let obj = {};
                requiredFieldsObj.forEach(element => {
                    obj[element.id] = ExcelData[element.id]
                });
                return obj;
            });
        }

        if (rABS) reader.readAsBinaryString(file)
        else reader.readAsArrayBuffer(file)
    }


    function AddListItem(header) {

        document.getElementById("sortable").innerHTML = "";
        for (let i in header) {
            let key = header[i];
            if (header[i] == 'Account_ID') {
                key = 'i_holder';
            }
            var ul = document.getElementById("sortable");
            var li = document.createElement("li");
            li.dataset.key = key;
            li.setAttribute("id", "l" + i);
            li.setAttribute("class", "li-class");
            li.appendChild(document.createTextNode(header[i]));
            ul.appendChild(li);
        }


    }



    /* 
    
    */
    function sortFields() {
        if ($("#sort_btn").text() == "Finished Sorting") {
            $("#import_btn").show();
        }
        var requiredFields = requiredFieldsArr;
        var presentFields = [];
        let lis = document.getElementById('sortable').childNodes;
        for (var i = 0; i < lis.length; i++) {
            var arrValue = lis[i].dataset.key;
            presentFields.push(arrValue);
        }
        console.log(presentFields);
        shorting_list = presentFields;
        $("#after_shorting").val(shorting_list);
        //alert();



        let checker = (arr, target) => target.every(v => arr.map(a => a.toLowerCase()).includes(v.toLowerCase()));

        if (checker(presentFields, requiredFields)) {
            $(sortable).empty();

            AddListItem(requiredFields);
            sortFieldsSecond();
            $("#import_btn").show();
        } else {
            if ($("#sort_btn").text() == "Finished Sorting") {
                $("#import_btn").show();
            } else {
                //  $("#import_btn").show();
                $("#sort_btn").text("Finished Sorting");
                alert("Fields do not match, please arrange manually");

            }
        }
    }


    /* 
    
    */
    function sortFieldsSecond() {
        var requiredFields = requiredFieldsArr;
        var presentFields = [];
        let lis = document.getElementById('sortable').childNodes;
        for (var i = 0; i < lis.length; i++) {
            var arrValue = lis[i].innerHTML;
            presentFields.push(arrValue);
        }
        shorting_list = presentFields;
        $("#after_shorting").val(shorting_list);
        //alert();

        let checker = (arr, target) => target.every(v => arr.includes(v));

        if (checker(presentFields, requiredFields)) {
            $(sortable).empty();

            AddListItem(requiredFields);
            $("#import_btn").show();

        } else {
            $("#import_btn").show();
        }
    }
</script>

<!-- IMPORT -->
<script>
    $('#loading').fadeOut(0);
    let egmCount = <?= $egmCount ?>;


    $("#import_btn").on("click", function() {
        if (egmCount) {
            var r = confirm("Record already exist. You want to delete??");

            if (r == true) {
                IMPORT();
            }
        } else {
            IMPORT();
        }

    });


    function IMPORT() {
        $('#import_btn').fadeOut(0);
        $('#loading').fadeIn(0);

        var formData = new FormData();
        formData.append("file_name", file.files[0], file.files[0].name);
        formData.append('shorting_field', $("#after_shorting").val())
        formData.append('required_fields', requiredFieldsArr)
        $.ajax({
            type: "POST",
            url: "/api/admin/shareholders/import",
            contentType: false,
            processData: false,
            data: formData,
            success: function(res) {
                if (res.status) {
                    toastr.success(res.message)
                } else {
                    toastr.error(res.message)
                }
            },
            error: err => {
                console.log(err);
            },

        }).then(res => {
            $('#import_btn').fadeIn(0);
            $('#loading').fadeOut(0);
        });
    }
</script>