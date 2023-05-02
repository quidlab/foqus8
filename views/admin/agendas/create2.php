<?
    foreach (errors() as $error) {
        echo '<section class="ml-4 text-xl text-bold">' . $error . '</section>'; // TODO add script and use toastr
    }
    ?>
    <form id="MainForm" method="POST" action="/admin/agendas">

        <div class="">

            <div class="-content">
                <!-- your steps content here -->
                <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                    <div class="card card-primary mx-4">
                        <div class="card-header">
                            <h3 class="card-title"><?= __('create-new-agenda') ?></h3>
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
                                        <option value="Void">Void</option>
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
                                        <option selected value="N">No</option>
                                    </select>
                                </div>
                            </div>


                        </div>

                        <div class="card-footer">

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
                                <table class="w-full">
                                    <thead>
                                        <tr>
                                            <th>Language</th>
                                            <th>Agenda Name</th>
                                            <th>Agenda Info</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                        foreach ($languages as $key => $value) {
                                            echo '<tr>
                                                <td>' .'<i class="flag-icon flag-icon-' . $value['Flag_ID'] . ' mr-2"></i>'  . $value['Language_Name'] . '</td>
                                                <td> <textarea class="w-full" required name="agenda_text-' . $key + 1 . '-name-' . $value['Language_ID'] . '" placeholder="Name in ' . $value['Language_Name'] . '"> </textarea> </td>
                                                <td> <textarea  class="w-full" required name="agenda_text-' . $key + 1 . '-info-' . $value['Language_ID'] . '" placeholder="Info in ' . $value['Language_Name'] . '" > </textarea> </td>
                                                <td style="display:none"> <input type="hidden"  required name="agenda_text-' . $key + 1 . '-lang-' . $value['Language_ID'] . '" value="'.$value['Language_ID'].'" /> </td>
                                                </tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <table style="table-layout: fixed;margin-top:20px "  class="w-full">
                                    <thead>
                                        <tr>
                                            <th>Language</th>
                                            <th>Approved</th>
                                            <th>Disapproved</th>
                                            <th>Abstain</th>
                                            <th>No Vote</th>
                                            <th>Void</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                        foreach ($languages as $key => $value) {
                                            echo '<tr>
                                                <td>' . '<i class="flag-icon flag-icon-' . $value['Flag_ID'] . ' mr-2"></i>' .$value['Language_Name'] . '</td>
                                                <td> <input value="'.$value['Approve'].'" required name="agenda_text-' . $key + 1 . '-approved-' . $value['Language_ID'] . '" placeholder="Approved in ' . $value['Language_Name'] . '" /> </td>
                                                <td> <input value="'.$value['DisApprove'].'" required name="agenda_text-' . $key + 1 . '-disapproved-' . $value['Language_ID'] . '" placeholder="Disapproved in ' . $value['Language_Name'] . '" /> </td>
                                                <td> <input value="'.$value['Abstain'].'" required name="agenda_text-' . $key + 1 . '-abstain-' . $value['Language_ID'] . '" placeholder="Abstain in ' . $value['Language_Name'] . '" /> </td>
                                                <td> <input value="'.$value['NoVote'].'" required name="agenda_text-' . $key + 1 . '-no_vote-' . $value['Language_ID'] . '" placeholder="No Vote in ' . $value['Language_Name'] . '" /> </td>
                                                <td> <input value="'.$value['Void'].'" required name="agenda_text-' . $key + 1 . '-void-' . $value['Language_ID'] . '" placeholder="Void in ' . $value['Language_Name'] . '" /> </td>
                                            </tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer">

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
                                <table class="w-full">
                                    <thead>
                                        <tr>
                                            <th>Index</th>
                                            <th>Director ID</th>
                                            <?
                                            foreach ($languages as $key => $value) {
                                                echo '<th> Name in ' . $value['Language_Name'] . '</th>';
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success mx-4" onclick="addOneMore()">Add one more +</button>
                        <div class="card-footer">
                            <button type="submit" id="submitBtn" class="btn btn-primary">Submit</button>

                        </div>
                    </div>
                </div>
            </div>



    </form>





    <?php include __DIR__ . "/../../layouts/footer.php"; ?>
    <?php include __DIR__ . "/../../layouts/scripts.php"; ?>
    
    <script>
        $("[type='submit']").on("click", function() {
            $('#MainForm').submit();
        })

    </script>


    <script>
        let directorsCount = 0;
        $('#directorsCard').fadeOut(0);

        var langs = <?= json_encode($languages); ?>;
        langs = langs.map(l => l.Language_ID);


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





        $('#NumberOfDirectorsToEleect').on('keypress', function(e) {
            e.preventDefault();
            if (e.keyCode  != 13) return;

            let oldValue = directorsCount;
            directorsCount = Number(e.target.value);
            directorsDrawer(oldValue, directorsCount);
        });

        function directorsDrawer(from, to) {
            for (let index = from; index < to; index++) {
                $('#directorsCardBody table tbody').append(directorHTML(index + 1))
            }
        }

        function directorHTML(index) {
            let r = `
                <tr>
                    <td>${index}</td>
                    <td>
                        <input required type="text" class="form-control" name="director-${index}-id" placeholder="Director ID">
                    </td>
            `;


            langs.forEach(l => {
                r += `
                    <td>
                        <input required type="text" class="form-control" name="director-${index}-name-${l}" placeholder="Director Name ${l}">
                    </td>
                `;
            });


            r += ` </tr>`;
            return r;
        }

        function addOneMore() {
            directorsDrawer(directorsCount, ++directorsCount)
        }
    </script>