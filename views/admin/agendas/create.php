    <?
        foreach (errors() as $error) {
            echo '<section class="ml-4 text-xl text-bold">'.$error.'</section>';// TODO add script and use toastr
        }
    ?>
<div class="card card-primary mx-4">
    <div class="card-header">
        <h3 class="card-title">Create New Agenda</h3>
    </div>

    <form method="POST" action="/admin/agendas">
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
                        <option value="Y">Yes</option>
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
                    <label>Directors To Select</label>
                    <input type="number" class="form-control" name="NumberOfDirectorsToEleect" id="NumberOfDirectorsToEleect">
                </div>
                <div class="form-group col-md-6">
                    <label>Voting Started</label>
                    <select class="form-control" name="Voting_Started" id="Voting_Started">
                        <option value="Y">Yes</option>
                        <option value="N">No</option>
                    </select>
                </div>
            </div>

            <div class="row">
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
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>














<?php include __DIR__ . "/../../layouts/footer.php"; ?>
<?php include __DIR__ . "/../../layouts/scripts.php"; ?>