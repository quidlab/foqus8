<?php
session_start();
if(isset($_SESSION['uname'])){
//include('../ajax/connection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Import Shareholders Data</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="css/pnotify.css" rel="stylesheet">
  <link href="css/pnotify.buttons.css" rel="stylesheet">
  <link href="css/pnotify.nonblock.css" rel="stylesheet">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="css/custom.min.css" rel="stylesheet">
  <link rel="stylesheet" href="agm/css/file.css">
      <style>
          #pageloader{
              background: rgba( 255, 255, 255, 0.8 );
              display: none;
              height: 100%;
              position: fixed;
              width: 100%;
              z-index: 9999;
          }
          #pageloader img{
              left: 50%;
              margin-left: -32px;
              margin-top: -32px;
              position: absolute;
              top: 50%;
            }
      </style>
    <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
    
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
	<?php include('sidebar.php');?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
       <?php include('topbar.php');?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
			        <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Import Shareholders Data</h6>
              </div>
              
              <div class="card-body">
                <div id="result"></div>
                <div class="columns">

                <div class="col1">
                <h4>Required Files</h4>
                <ul id="" class="back">
                  <li id="Account_ID" class="li-class">TSD Registration No.</li>
                  <li id="n_title" class="li-class">Title</li>
                  <li id="n_first" class="li-class">First Name</li>
                  <li id="n_last" class="li-class">Last Name</li>
                  <li id="a_holder" class="li-class">Address</li>
                  <li id="i_zip" class="li-class">Zip code</li>
                  <li id="h_phone" class="li-class">Phone No.</li>
                  <li id="q_share" class="li-class">No. of Shares Held</li>
                  <li id="i_ref" class="li-class">ID Card No.</li>
                </ul>

                <div class="upload-btn-wrapper">
                  <form action="agm/import.php" enctype="multipart/form-data" id="import_form" method="post">
                      <input type="hidden" name="action" value="save_data">
                      <input type="hidden" name="shorting_field" value="" id="after_shorting">
                      <button class="btn btn-primary btn-sm">Select Excel File</button>
                  <input type="file" name="uploadFile" onchange="handleFile()" id='file' accept=".xlsx, .xls, .csv"/>
                    </form>
                    
                </div>
              </div>

              <div class="col2">
                <h4>Fields in Excel Files</h4>
                  <ul id="sortable" class="back b1">
              <!--      <li id="result" class="ui-state-default"></li> -->
                  </ul>
              <button onclick="sortFields()" class="btn btn-primary btn-sm">Sort</button>
              <button id="import_btn" type="button" class="btn-primary btn-sm" style="display: none;">Import</button>
                  
              </div>

              </div>  

              
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php include('footerbar.php');?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script src="js/pnotify.js"></script>
  <script src="js/pnotify.nonblock.js"></script>
  <script src="js/custom-agenda.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="agm/js/xlsx.full.min.js"></script>

  <script>
          function deleteAllData(){
              $.ajax({
                type:"POST",
                url:"agm/ajax.php",
                data: { db_field: shorting_list, action : 'delete_record'},
                success:function(data){
                    if(data == "true"){
                        $("#import_form").submit();
                    }else{
                        alert(data);
                        alert("Opps something went wrong");
                    }
                }
            })
          }
          
          
          $("#import_btn").on("click",function(){
              sortFieldsSecond();
              //alert(shorting_list);
              
              $.ajax({
                type:"POST",
                url:"agm/import.php",
                data: { action : 'check_record'},
                success:function(data){
                    if(data != "empty"){
                        var r = confirm("Record already exist. You want to delete??");
                        if (r == true) {
                            deleteAllData();
                        }else {
                            txt = "you click Cancel!";
                        }
                    }else{
                        alert("New Record");
                    }
                }
            })
          })
      </script>

    <script>
    $( function() {
      $( "#sortable" ).sortable({
        revert: true
      });
      $( "#draggable" ).draggable({
        connectToSortable: "#sortable",
        helper: "clone",
        revert: "invalid"
      });
      $( "ul, li" ).disableSelection();
    } );
    </script>


    <script>
 $( function() {
   var progressbar = $( "#progressbar" ),
     progressLabel = $( ".progress-label" );

   progressbar.progressbar({
     value: false,
     change: function() {
       progressLabel.text( progressbar.progressbar( "value" ) + "%" );
     },
     complete: function() {
       progressLabel.text( "Complete!" );
     }
   });

   function progress() {
     var val = progressbar.progressbar( "value" ) || 0;

     progressbar.progressbar( "value", val + 2 );

     if ( val < 99 ) {
       setTimeout( progress, 80 );
     }
   }

   setTimeout( progress, 2000 );
 } );
 </script>



<script>
  function extractHeader(ws) {
    const header = []
    const columnCount = XLSX.utils.decode_range(ws['!ref']).e.c + 1
    for (let i = 0; i < columnCount; ++i) {
      header[i] = ws[`${XLSX.utils.encode_col(i)}1`].v
    }
    return header
  }

  function handleFile() {
    const input = document.getElementById("file")
    const file = input.files[0]

    if (file.type !== 'application/vnd.ms-excel')  { 
    
     // renderError() 
    }

    const reader = new FileReader()
    const rABS = !!reader.readAsBinaryString
    reader.onload = e => {
      /* Parse data */
      const bstr = e.target.result

      const wb = XLSX.read(bstr, { type: rABS ? 'binary' : 'array' })
      /* Get first worksheet */
      const wsname = wb.SheetNames[0]
      const ws = wb.Sheets[wsname]

      const header = extractHeader(ws)
    //console.log(sheet_to_json(ws));
  //  JSON.stringify(rowObject,undefined,4)
    //console.log(JSON.stringify(ws));
      //alert(XLSX.utils.sheet_to_json(ws, {header:1}))
    console.log(XLSX.utils.sheet_to_json(ws, {header:1}));
      AddListItem(header)
    }

    if (rABS) reader.readAsBinaryString(file)
      else reader.readAsArrayBuffer(file)
  }

  function AddListItem(header) {
 
document.getElementById("sortable").innerHTML = "";
     for (let i in header) {
  //     console.log (header[i]);
       var ul = document.getElementById("sortable");
        var li = document.createElement("li");
        li.setAttribute("id","l"+i);
   li.appendChild(document.createTextNode(header[i]));
   ul.appendChild(li);

    }

 
  }

  function renderError() {
    const errorMsg = 'Unexpected file type'
    const error = document.createElement('p')
    error.setAttribute('class', 'error')
    const txt = document.createTextNode(errorMsg)
    error.appendChild(txt)
    document.getElementById('result').appendChild(error)
    throw new Error(errorMsg)
  }
</script>
<script>
    
    var shorting_list = '';
    
function sortFields() {
var requiredFields =['Account_ID','n_title','n_first','n_last','a_holder','i_zip','h_phone','q_share','i_ref'  ];
var presentFields = [];
let lis = document.getElementById('sortable').childNodes;
for(var i=0;i < lis.length; i++) {
    var arrValue = lis[i].innerHTML;
    presentFields.push(arrValue);
}
    
console.log(presentFields);
    shorting_list = presentFields;
    $("#after_shorting").val(shorting_list);
    //alert();
    
    
    
let checker = (arr, target) => target.every(v => arr.includes(v));

if (checker( presentFields,requiredFields)){
$(sortable).empty();
    
AddListItem(requiredFields);
    $("#import_btn").show();   
}
else{
    $("#import_btn").show();
    alert("Fields do not match, please arrange manually");}
}
    
    
    
function sortFieldsSecond() {
var requiredFields =['Account_ID','n_title','n_first','n_last','a_holder','i_zip','h_phone','q_share','i_ref'  ];
var presentFields = [];
let lis = document.getElementById('sortable').childNodes;
for(var i=0;i < lis.length; i++) {
    var arrValue = lis[i].innerHTML;
    presentFields.push(arrValue);
}
    
console.log(presentFields);
    shorting_list = presentFields;
    $("#after_shorting").val(shorting_list);
    //alert();
    
let checker = (arr, target) => target.every(v => arr.includes(v));

if (checker( presentFields,requiredFields)){
$(sortable).empty();
    
AddListItem(requiredFields);
    $("#import_btn").show();   
}
else{
    $("#import_btn").show();
}
}
    
    
</script>

</body>
</html>
<?php 
}
else{
	?>
	<script>
		window.location.href="logout.php"; 
	</script>
	<?php
}
?>