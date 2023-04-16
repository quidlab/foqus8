    <?
    foreach (errors() as $error) {
        echo '<section class="ml-4 text-xl text-bold">' . $error . '</section>'; // TODO add script and use toastr
    }
    ?>
    <form id="MainForm" method="POST" action="/admin/agendas">

        <div class="bs-stepper">
            <div class="bs-stepper-header" role="tablist">
                <!-- your steps here -->
                <div class="step" data-target="#logins-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger">

                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#information-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">

                    </button>
                </div>
                <div class="step" data-target="#oo-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="oo-part" id="oo-part-trigger">

                    </button>
                </div>
            </div>
            <div class="bs-stepper-content">
                <!-- your steps content here -->
                <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                    <div class="card card-primary mx-4">
                        <div class="card-header">
                            <h3 class="card-title">Create New Agenda</h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Sort_ID</label>
                                    <input type="number" name="Sort_ID" class="form-control" id="Sort_ID" placeholder="Sort_ID">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>AGENDA_ID</label>
                                    <input type="text" class="form-control" name="AGENDA_ID" id="AGENDA_ID" placeholder="AGENDA_ID">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Formula</label>
                                    <select class="form-control" name="Special_Formula" id="Special_Formula">
                                        <option value="NORMAL">NORMAL</option>
                                        <option value="EXCLUDE_ABSTAIN">EXCLUDE_ABSTAIN</option>
                                        <option value="EXCLUDE_VOID">EXCLUDE_VOID</option>
                                        <option value="EXCLUDE_ABSTAIN_AND_VOID">EXCLUDE_ABSTAIN_AND_VOID</option>
                                        <option value="EXCLUDE_NO_VOTE">EXCLUDE_NO_VOTE</option>
                                        <option value="EXCLUDE_NO_VOTE_AND_VOID">EXCLUDE_NO_VOTE_AND_VOID</option>
                                        <option value="EXCLUDE_ABSTAIN_AND_VOID_AND_NOVOTE">EXCLUDE_ABSTAIN_AND_VOID_AND_NOVOTE</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Voting_Required</label>
                                    <select class="form-control" name="Voting_Required" id="Voting_Required">
                                        <option selected value="Y">Yes</option>
                                        <option value="N">No</option>
                                        <option value="C">CUMULATIVE</option>
                                        <option value="S">SELECTION</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>INITIAL VOTE</label>
                                    <select class="form-control" name="Reverse_Vote" id="Reverse_Vote">
                                        <option value="Approve">Approve</option>
                                        <option value="DisApprove">DisApprove</option>
                                        <option value="Abstain">Abstain</option>
                                        <option value="NoVote">NoVote</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Approval</label>
                                    <select class="form-control" name="Approval_Percent" id="Approval_Percent">
                                        <option value="Majorty">Majorty</option>
                                        <option value="OneThird">OneThird</option>
                                        <option value="TwoThird">TwoThird</option>
                                        <option value="OneHalh">OneHalh</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label>Voting Started</label>
                                    <select class="form-control" name="Voting_Started" id="Voting_Started">
                                        <option value="Y">Yes</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>% on full shares</label>
                                    <select class="form-control" name="Percent_Based_On_FullShares" id="Percent_Based_On_FullShares">
                                        <option value="Y">Yes</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>
                            </div>


                        </div>

                        <div class="card-footer">
                            <button type="button" class="btn btn-success" onclick="next()">Next</button>

                        </div>
                    </div>
                </div>
                <!-- Step 2 -->
                <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                    <div class="card card-primary mx-4">
                        <div class="card-header">
                            <h3 class="card-title">Agenda Text</h3>
                        </div>
                        <div class="card-body">
                            <div id="agendaTextBody">

                            </div>
                        </div>
                        <button type="button" class="btn btn-success mx-4" onclick="addAgendaText()">Add one more +</button>

                        <div class="card-footer">
                            <button type="button" class="btn btn-success" onclick="previous()">Previous</button>

                            <button type="button" id="nextBtn" class="btn btn-success" onclick="next()">Next</button>
                            <button type="submit" id="submitBtn" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
                <!-- Step 3 -->
                <div id="oo-part" class="content" role="tabpanel" aria-labelledby="oo-part-trigger">
                    <div class="card card-primary mx-4" id="directorsCard">
                        <div class="card-header">
                            <h3 class="card-title">Add Directors</h3>
                        </div>
                        <div class="card-body">
                            <div id="NumberOfDirectorsToEleectContainer" class="form-group col-md-6">
                                <label>Directors To Select</label>
                                <input type="number" class="form-control" name="NumberOfDirectorsToEleect" id="NumberOfDirectorsToEleect">
                            </div>
                            <div id="directorsCardBody">

                            </div>
                        </div>
                        <button type="button" class="btn btn-success mx-4" onclick="addOneMore()">Add one more +</button>
                        <div class="card-footer">
                            <button type="button" class="btn btn-success" onclick="previous()">Previous</button>
                            <button type="submit" id="submitBtn" class="btn btn-primary">Submit</button>

                        </div>
                    </div>
                </div>
            </div>



    </form>





    <?php include __DIR__ . "/../../layouts/footer.php"; ?>
    <?php include __DIR__ . "/../../layouts/scripts.php"; ?>
    <script src="<?= assets("/assets/plugins/bs-stepper/js/bs-stepper.min.js") ?>"></script>
    <script>
        $("[type='submit']").on("click", function() {
            $('#MainForm').submit();
        })

        var stepper;
        document.addEventListener('DOMContentLoaded', function() {
            stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        function next() {
            stepper.next();
            if (validator()) {} else {

            }
        }

        function previous() {
            stepper.previous();
        }

        function validator() {
            return true;
        }
    </script>


    <script>
        let directorsCount = 0;
        $("#nextBtn").fadeOut(0);



        $('#Voting_Required').on("input", function(e) {
            if (['C', 'S'].includes(e.target.value)) {
                $("#nextBtn").fadeIn(0);
                $("#submitBtn").fadeOut(0);


                $('#directorsCard').fadeIn(0);
            } else {
                $("#submitBtn").fadeIn(0);
                $("#nextBtn").fadeOut(0);

                $('#directorsCard').fadeOut(0);
            }
        });





        $('#NumberOfDirectorsToEleect').on('input', function(e) {
            let oldValue = directorsCount;
            directorsCount = Number(e.target.value);
            directorsDrawer(oldValue, directorsCount);
        });

        function directorsDrawer(from, to) {
            for (let index = from; index < to; index++) {
                $('#directorsCardBody').append(directorHTML(index + 1))
            }
        }

        function directorHTML(index) {
            return `
            <h2>Director ${index}</h2>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>name en </label>
                    <input required type="text" name="director-${index}-name" class="form-control" placeholder="name">
                </div>
                <div class="form-group col-md-6">
                    <label>name th</label>
                    <input required type="text" class="form-control" name="director-${index}-name-thai" placeholder="AGENDA_ID">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Director ID</label>
                    <input required type="text" class="form-control" name="director-${index}-id" placeholder="Director ID">
                </div>
                <div class="form-group col-md-6">
                    <label>Language</label>
                    <select required class="form-control" name="director-${index}-lang">
                        <option value="en">en</option>
                        <option value="th">th</option>
                    </select>
                </div>
            </div>
            `;
        }

        function addOneMore() {
            directorsDrawer(directorsCount, ++directorsCount)
        }
    </script>
    <!-- Agenda Text -->
    <script>
        let agendaTextCount = 0;
        addAgendaText();

        function agendaTextDrawer(from, to) {
            for (let index = from; index < to; index++) {
                $('#agendaTextBody').append(agendaTextHTML(index + 1))
            }
        }


        function agendaTextHTML(index) {
            return `
            <h2>Agenda Text ${index}</h2>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Name </label>
                    <input required type="text" name="agenda_text-${index}-name" class="form-control" placeholder="Agenda name">
                </div>
                <div class="form-group col-md-6">
                    <label>Approve </label>
                    <input required type="text" name="agenda_text-${index}-approve" class="form-control" placeholder="name">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Dis Approve</label>
                    <input required type="text" class="form-control" name="agenda_text-${index}-disapprove" placeholder="AGENDA_ID">
                </div>
                <div class="form-group col-md-6">
                    <label>Abstain</label>
                    <input required type="text" class="form-control" name="agenda_text-${index}-abstain" placeholder="AGENDA_ID">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>No Vote</label>
                    <input required type="text" class="form-control" name="agenda_text-${index}-novote" placeholder="No Vote">
                </div>
                <div class="form-group col-md-6">
                    <label>Language</label>
                    <select required class="form-control" name="agenda_text-${index}-lang">
                        <option value="en">en</option>
                        <option value="th">th</option>
                    </select>
                </div>
            </div>
            <div class="row">
            <div class="form-group col-md-6">
                    <label>Agenda Info</label>
                    <textarea type="text" class="form-control" name="agenda_text-${index}-info" placeholder="Agenda Info">
                    </textarea>
                </div>
            </div>

            `;
        }

        function addAgendaText() {
            agendaTextDrawer(agendaTextCount, ++agendaTextCount)
        }
    </script>