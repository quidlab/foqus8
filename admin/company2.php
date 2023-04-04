<?
$sql= "select * from Co_info where ID=1";
$params=array();
$getStat = $FoQusdatabase ->Select($sql,$params);

?>
          	<!-- Page Heading -->

    			<div class="card shadow mb-4">
    				<div class="card-body">
						<form method="POST" enctype="multipart/form-data" action="manage-company-submit.php" data-parsley-validate class="form-horizontal form-label-left">

						<input type="hidden" name="comp_id" value="1">


                <div class="form-row">
                  

                  <div class="form-group col-md-4">
                    <label for="agendaNoThai"> Show Stake Holder Text </label>
                    <select name="agendaNoThai" id="agendaNoThai" class="form-control form-control-sm">
                      <option value="Y" <?php echo ($getStat[0]['Agenda_No_Thai'] == 'Y') ? 'selected' : '' ?> > Y </option>
                      <option value="N" <?php echo ($getStat[0]['Agenda_No_Thai'] == 'N') ? 'selected' : '' ?> > N </option>
                    </select>
                  </div>
				  
				                    <div class="form-group col-md-4">
                    <label for="treasuryShares"> Treasury Shares </label>
                    <input type="number" name="treasuryShares" class="form-control form-control-sm" id="treasuryShares" placeholder="Treasury Shares" min="0" value="<?php echo $getStat['Treasury_Shares'] ?>">
                  </div>
				                    <div class="form-group col-md-4">
                    <label for="logo"> Logo </label>
                    <input type="file" name="logo" id="logo" class="form-control form-control-sm" placeholder="logo">

                    <small id="error1" style="display:none; color:#FF0000; font-size: 10px;">
                      Invalid Image Format! Image Format Must Be JPG, JPEG or PNG.
                    </small>

                    <small id="error2" style="display:none; color:#FF0000; font-size: 10px;">
                      Maximum File Size Limit is 1MB.
                    </small>

                    <input type="hidden" name="comp_logo" value="<?php echo $getStat[0]['comp_logo'] ?>">
                  </div>

                </div>



                <div class="form-row">

                  <div class="form-group col-md-4">
                    <label for="showHeadCount"> Show Head Count </label>
                    <select name="showHeadCount" id="showHeadCount" class="form-control form-control-sm">
                    	<option value="Y" <?php echo ($getStat[0]['Show_head_count'] == 'Y') ? 'selected' : '' ?> > Y </option>
                    	<option value="N" <?php echo ($getStat[0]['Show_head_count'] == 'N') ? 'selected' : '' ?> > N </option>
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="groupSHasOne"> Group (COUNT) SH as one for quorum </label>
                    <input type="text" name="groupSHasOne" class="form-control form-control-sm" id="groupSHasOne" placeholder="Group (COUNT) SH as one for quorum" value="<?php echo $getStat[0]['Group_SH_as_one'] ?>" readonly>
                    <!-- <select name="groupSHasOne" id="groupSHasOne" class="form-control form-control-sm">
                    	<option value="Y" <?php //echo ($getStat['Group_SH_as_one'] == 'Y') ? 'selected' : '' ?> > Y </option>
                    	<option value="N" <?php //echo ($getStat['Group_SH_as_one'] == 'N') ? 'selected' : '' ?> > N </option>
                    </select> -->
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="showIncreaseSHText"> Show Increase SH Text </label>
                    <select name="showIncreaseSHText" id="showIncreaseSHText" class="form-control form-control-sm">
                    	<option value="Y" <?php echo ($getStat[0]['Show_Increase_SH_text'] == 'Y') ? 'selected' : '' ?> > Y </option>
                    	<option value="N" <?php echo ($getStat[0]['Show_Increase_SH_text'] == 'N') ? 'selected' : '' ?> > N </option>
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="showQuorumSHPercent"> Show Quorum SH Percent </label>
                    <select name="showQuorumSHPercent" id="showQuorumSHPercent" class="form-control form-control-sm">
                    	<option value="Y" <?php echo ($getStat[0]['Show_Quorum_SH_percent'] == 'Y') ? 'selected' : '' ?> > Y </option>
                    	<option value="N" <?php echo ($getStat[0]['Show_Quorum_SH_percent'] == 'N') ? 'selected' : '' ?> > N </option>
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="showPercentSign"> Show Percent Sign </label>
                    <select name="showPercentSign" id="showPercentSign" class="form-control form-control-sm">
                    	<option value="Y" <?php echo ($getStat[0]['Show_percent_sign'] == 'Y') ? 'selected' : '' ?> > Y </option>
                    	<option value="N" <?php echo ($getStat[0]['Show_percent_sign'] == 'N') ? 'selected' : '' ?> > N </option>
                    </select>
                  </div>
                </div>



                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="showVoidOnScreen"> Allow Void </label>
                    <select name="showVoidOnScreen" id="showVoidOnScreen" class="form-control form-control-sm">
                    	<option value="Y" <?php echo ($getStat[0]['Show_Void_On_Screen'] == 'Y') ? 'selected' : '' ?> > Y </option>
                    	<option value="N" <?php echo ($getStat[0]['Show_Void_On_Screen'] == 'N') ? 'selected' : '' ?> > N </option>
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="showLogoOnScreen"> Show Meeting Info and Logo On Screen </label>
                    <select name="showLogoOnScreen" id="showLogoOnScreen" class="form-control form-control-sm">
                    	<option value="Y" <?php echo ($getStat[0]['Show_Logo_On_Screen'] == 'Y') ? 'selected' : '' ?> > Y </option>
                    	<option value="N" <?php echo ($getStat[0]['Show_Logo_On_Screen'] == 'N') ? 'selected' : '' ?> > N </option>
                    </select>
                  </div>

                </div>

                <div class="form-row">


                  <div class="form-group col-md-4">
                    <label for="symbol"> Symbol </label>
                    <input type="text" name="symbol" class="form-control form-control-sm" id="symbol" placeholder="Symbol" value="<?php echo $getStat[0]['SYMBOL'] ?>">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="quorumFreeText"> Quorum Free Text </label>
                    <input type="text" name="quorumFreeText" class="form-control form-control-sm" id="quorumFreeText" placeholder="Quorum Free Text" value="<?php echo $getStat['Quorum_Free_Text'] ?>">
                  </div>
                  <?php
                  	$login_date = $getStat[0]['Login_allowed_time']->format('Y-m-d\Th:i:s');
					echo ($login_date);
                    $l_date = $getStat[0]['Login_allowed_time']->format('Y-m-d');
                    $l_time = $getStat[0]['Login_allowed_time']->format('H:i');
                  ?>
                  <div class="form-group col-md-4">
                    <label for="loginAllowedTime"> Login Allowed Time (UTC) </label>
                    <!-- <input type="datetime-local" name="loginAllowedTime" class="form-control form-control-sm" id="loginAllowedTime" placeholder="Login Allowed Time" value="<?php //echo $loginAllowedTime; ?>"> -->
                    <input type="datetime-local" value="<?php echo $login_date ?>" name="date">
                    <span></span>
                    <input type="time" value="<?php echo $l_time ?>" name="time">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="AGMLink"> AGM Link </label>
                    <input type="url" name="AGMLink" class="form-control form-control-sm" id="AGMLink" placeholder="AGM Link" value="<?php echo $getStat[0]['Agm_Link'] ?>">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="companyPhone"> Company Phone </label>
                    <input type="text" name="companyPhone" class="form-control form-control-sm" id="companyPhone" placeholder="Company Phone" value="<?php echo $getStat[0]['Company_Phone'] ?>">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="companyEmail"> Company Email </label>
                    <input type="email" name="companyEmail" class="form-control form-control-sm" id="companyEmail" placeholder="Company Email" value="<?php echo $getStat[0]['Company_Email'] ?>">
                  </div>

                </div>



                <div class="form-row">

                  <div class="form-group col-md-4">
                    <label for="dacastVcCode"> Dacast vc Code </label>
                    <textarea name="dacastVcCode" class="form-control form-control-sm" id="dacastVcCode" placeholder="Dacast vc Code"> <?php echo $getStat[0]['dacast_vc_code'] ?> </textarea>
                  </div>
				          <div class="form-group col-md-4">
                    <label for="meetingvideotype">Meeting Video Type </label>
                    <select name="meetingvideotype" id="meetingvideotype" class="form-control form-control-sm">
                    	<option value="VideoConference" <?php echo ($getStat[0]['meeting_video_type'] == 'VideoConference') ? 'selected' : '' ?> > VideoConference </option>
						<option value="VideoConferenceT" <?php echo ($getStat[0]['meeting_video_type'] == 'VideoConferenceT') ? 'selected' : '' ?> > VideoConference with Interpreter</option>
                    	<option value="Streaming" <?php echo ($getStat[0]['meeting_video_type'] == 'Streaming') ? 'selected' : '' ?> > Streaming </option>
						          <option value="VotingOnly" <?php echo ($getStat[0]['meeting_video_type'] == 'VotingOnly') ? 'selected' : '' ?> > VotingOnly </option>
						          <option value="DirectorsMeeting" <?php echo ($getStat[0]['meeting_video_type'] == 'DirectorsMeeting') ? 'selected' : '' ?> > Director's Meeting </option>
								  <option value="Mixed" <?php echo ($getStat[0]['meeting_video_type'] == 'Mixed') ? 'selected' : '' ?> > Mixed </option>
                    </select>
                  </div>
                </div>

				        <div class="form-row">
				          <div class="form-group col-md-4">
                    <label for="show_vote_results"> Show Voting Results Button </label>
                    <select name="show_vote_results" id="show_vote_results" class="form-control form-control-sm">
                    	<option value="Y" <?php echo ($getStat[0]['show_vote_results'] == 'Y') ? 'selected' : '' ?> > Y </option>
                    	<option value="N" <?php echo ($getStat[0]['show_vote_results'] == 'N') ? 'selected' : '' ?> > N </option>
                    </select>
                  </div>
				          <div class="form-group col-md-4">
                    <label for="show_download"> Show Download Button </label>
                    <select name="show_download" id="show_download" class="form-control form-control-sm">
                    	<option value="Y" <?php echo ($getStat[0]['show_download'] == 'Y') ? 'selected' : '' ?> > Y </option>
                    	<option value="N" <?php echo ($getStat[0]['show_download'] == 'N') ? 'selected' : '' ?> > N </option>
                    </select>
                  </div>
				          <div class="form-group col-md-4">
                    <label for="show_chat"> Show Ask Question Button </label>
                    <select name="show_chat" id="show_chat" class="form-control form-control-sm">
                    	<option value="Y" <?php echo ($getStat[0]['show_chat'] == 'Y') ? 'selected' : '' ?> > Y </option>
                    	<option value="N" <?php echo ($getStat[0]['show_chat'] == 'N') ? 'selected' : '' ?> > N </option>
                    </select>
                  </div>
				        </div>

				        <div class="form-row">
				          <div class="form-group col-md-4">
                    <label for="show_voice"> Show Voice Record Button </label>
                    <select name="show_voice" id="show_voice" class="form-control form-control-sm">
                    	<option value="Y" <?php echo ($getStat[0]['show_voice'] == 'Y') ? 'selected' : '' ?> > Y </option>
                    	<option value="N" <?php echo ($getStat[0]['show_voice'] == 'N') ? 'selected' : '' ?> > N </option>
                    </select>
                  </div>


				        </div>

				        <div class="form-row">

				          <div class="form-group col-md-4">
                    <label for="JitsiServerURL"> JITSI VC Server URL </label>
                    <input type="text" name="JitsiServerURL" class="form-control form-control-sm" id="JitsiServerURL" placeholder="Jitsi VC Server URL" value="<?php echo $getStat[0]['jitsi_server'] ?>">
                  </div>

				        </div>

                <div class="form-row">
                  <?php
                    $docAllowedTime = $getStat[0]['docreg_allowed_time']->format('d-M-Y h:i:s A');
                    $allowed_date = $getStat[0]['docreg_allowed_time']->format('Y-m-d');
                    $allowed_time = $getStat[0]['docreg_allowed_time']->format('H:i');
                  ?>
                  <div class="form-group col-md-4">
                    <label for="documentAllowedTime"> Document Allowed Time (UTC) </label>
                    <input type="date" value="<?php echo $allowed_date ?>" name="allowedDate">
                    <span></span>
                    <input type="time" value="<?php echo $allowed_time ?>" name="allowedTime">
                  </div>

                  <?php
                    $docFinishTime = $getStat[0]['docreg_finish_time']->format('d-M-Y h:i:s A');
                    $finish_date = $getStat[0]['docreg_finish_time']->format('Y-m-d');
                    $finish_time = $getStat[0]['docreg_finish_time']->format('H:i');
                  ?>
                  <div class="form-group col-md-4">
                    <label for="documentFinishTime"> Document Finish Time (UTC) </label>
                    <input type="date" value="<?php echo $finish_date ?>" name="finishDate">
                    <span></span>
                    <input type="time" value="<?php echo $finish_time ?>" name="finishTime">
                  </div>


                  <div class="form-group col-md-4">
                    <label for="enableDocRegistration"> Enable Document Registration </label>
                    <select name="enableDocRegistration" id="enableDocRegistration" class="form-control form-control-sm">
                      <option value="Y" <?php echo ($getStat[0]['enable_doc_reg'] == 'Y') ? 'selected' : '' ?> > Y </option>
                      <option value="N" <?php echo ($getStat[0]['enable_doc_reg'] == 'N') ? 'selected' : '' ?> > N </option>
                    </select>
                  </div>
                </div>

				        <div class="form-row">
				          <div class="form-group col-md-4">
                    <label for="dacastVcCode1"> &nbsp; </label><br>
                    <button class="btn btn-primary btn-sm" type="reset">Reset</button>
                    <input type="submit" name="submit-com-data" class="show btn btn-success btn-sm" value="Submit" id="submit" />
                  </div>
				        </div>
              </form>
    				</div>
    			</div>
