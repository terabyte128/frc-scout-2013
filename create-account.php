<?php require_once 'includes/redirect-if-session-exists.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Create An Account</title>
        <?php include 'includes/headers.php'; ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include 'includes/messages.php'; ?>
                <div class="title">
                    <h2>Create An Account</h2>
                    <p style='max-width: 500px; margin: 5px auto 5px auto'>
                        <a href='#' id='learnHow' style='margin-bottom: 16px;' onclick='$("#step1").show();$("#step2").hide();$("#step3").hide();'><span class="glyphicon glyphicon-question-sign"></span> How does FIRST Scout work?</a>
                    </p>
                    <p style='max-width: 500px; margin: 5px auto 5px auto'>
                        <span style="display: none;" id="step1">FIRST Scout accounts are shared, team-wide. When you create an account here, your team's entire army of scouts will use it. <a href='#' onclick='$("#step1").hide();
                                $("#step2").show();$("step3").hide();'>Learn more.</a></span>
                        <span style="display: none;" id="step2">When logging in, a scout will enter their name in addition to their team number, to help track who scouted what teams. <a href='#' onclick='$("#step2").hide();
                                ;
                                $("#step3").show();'>Learn even more!</a></span>
                        <span style="display: none;" id='step3'>The team's admin email is just the email of whoever makes the account, in case they need a password reset or other support. 
                            The admin password will need to be entered to change the team password or edit scouting data or team profiles. <br> <a href='#' onclick='$("#step3").hide();
                                $("#learnHow").hide();'>Let's get started!</a> <a href="https://github.com/terabyte128/frc-scout-2013/blob/master/create-account.php" target="_blank">Learn even more!</a></span>
                    </p>
                </div>
                <div class='login-form align-center' style='width: 250px;'>
                    <form role="form" onsubmit="createAccount();
                                return false;">
                        <div class="form-group">
                            <label for="teamNumber">Team Number</label>
                            <input type="number" class="form-control" id="teamNumber" name="teamNumber" placeholder="FRC Team Number" required>
                        </div>
                        <div class="form-group">
                            <label for="adminEmail">Administrator Email</label>
                            <input type="email" class="form-control" id="adminEmail" name="adminEmail" placeholder="Admin Email" required>
                        </div>
                        <div class="form-group">
                            <label for="teamPassword">Team Password</label>
                            <input type="password" class="form-control" id="teamPassword" name="teamPassword" placeholder="Team Password" required>
                        </div>
                        <div class="form-group">
                            <label for="checkPassword">Re-enter Password</label>
                            <input type="password" class="form-control" id="checkTeamPassword" name="checkPassword" placeholder="Re-enter Password" required>
                        </div>
                        <div class="form-group">
                            <label for="adminPassword">Admin Password</label>
                            <input type="password" class="form-control" id="adminPassword" name="adminPassword" placeholder="Admin Password" required>
                        </div>
                        <div class="form-group">
                            <label for="checkAdminPassword">Re-enter Admin Password</label>
                            <input type="password" class="form-control" id="checkAdminPassword" name="checkAdminPassword" placeholder="Re-enter Admin Password" required>
                        </div>
                        <div class="form-group">
                            <label for="teamType">Team Type</label>
                            <select class="form-control" id="teamType">
                                <option selected id="frc">FRC (big robots)</option>
                                <option id="ftc">FTC (small robots)</option>                           
                            </select>
                        </div>
                        <button type="submit" id="submitCreateRequest" class="btn btn-default btn-success">Create Account</button>
			<button type="button" onClick="location.href='/'" class="btn btn-default">Go Back</button>
                    </form>
                    <br />
                </div>
            </div>
        </div>
        <script type="text/javascript">
                            function createAccount() {
                                hideMessage();
                                $("#submitCreateRequest").button('loading');
                                var teamNumber = $("#teamNumber").val();
                                var adminEmail = $("#adminEmail").val();
                                var teamPassword = $("#teamPassword").val();
                                var checkTeamPassword = $("#checkTeamPassword").val();
                                var adminPassword = $("#adminPassword").val();
                                var checkAdminPassword = $("#checkAdminPassword").val();
                                var teamType = $('#teamType').find('option:selected').attr('id');

                                var errors = "";

                                if (teamPassword !== checkTeamPassword) {
                                    errors += "<br />&bull;Your team passwords did not match.";
                                }
                                if (adminPassword !== checkAdminPassword) {
                                    errors += "<br />&bull;Your admin passwords did not match.";
                                }

                                if (errors !== "") {
                                    errors = "Errors occured while creating account:" + errors;
                                    showMessage(errors, 'danger');
                                    return;
                                }

                                $.ajax({
                                    url: 'ajax-handlers/create-account-ajax-submit.php',
                                    type: "POST",
                                    data: {
                                        'teamNumber': teamNumber,
                                        'adminEmail': adminEmail,
                                        'teamPassword': teamPassword,
                                        'adminPassword': adminPassword,
                                        'teamType' : teamType
                                    },
                                    success: function(response, textStatus, jqXHR) {
                                        if (response.indexOf("successfully") === -1) {
                                            $("#submitCreateRequest").button('reset');
                                            showMessage(response, 'danger');
                                        } else {
                                            localStorage.newAccount = true;
                                            loadPageWithMessage("/", response, "success");
                                        }
                                    }
                                });
                            }
        </script>
    </body>
</html>
