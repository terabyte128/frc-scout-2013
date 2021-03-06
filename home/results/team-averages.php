<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/setup-session.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Team Averages</title>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/headers.php'; ?>
        <!-- choose a theme file -->
        <link rel="stylesheet" href="/css/theme.default.css">
        <!-- load jQuery and tablesorter scripts -->
        <script type="text/javascript" src="/includes/jquery.tablesorter.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/messages.php'; ?>
                <h2><img id="loading" src="/images/loading.gif" style="height: 24px; vertical-align: initial; display: none;"> Team Averages</h2>
                <button class="btn btn-default" onclick="window.location = '/'" style="margin-bottom: 10px;">Return Home</button>
                <p><i>This displays <strong>potential scores</strong> based on assists being worth 10 points apiece. For more detailed statistics, click a team number.</i></p>
                <a href="#" onclick="$('#filterOptions').slideToggle(200);
                        return false;">Filter these results</a>
                <div id="filterOptions" style="display:none;">
                    <label>View data collected by:</label><br />
                    <div class="btn-group" data-toggle="buttons" id="matchOutcome">
                        <label class="btn btn-default active" style="width: 130px;" id="all" onclick="setFilterHash('only', 'all');">
                            <input type="radio">All Teams
                        </label>
                        <label class="btn btn-default" style="width: 130px;" id="only" onclick="setFilterHash('all', 'only');">
                            <input type="radio">Only <?php echo $teamNumber; ?>
                        </label>
                    </div><br /><br />
                    <div class="btn-group" data-toggle="buttons" id="matchOutcome">
                        <label>View data from:</label><br />
                        <label class="btn btn-default active" style="width: 130px;" id="global" onclick="setFilterHash('here', 'global');">
                            <input type="radio">Everywhere
                        </label>
                        <label class="btn btn-default" style="width: 130px;" id="here" onclick="setFilterHash('global', 'here');">
                            <input type="radio">Here<!--<?php echo $location; ?>-->
                        </label>
                    </div>
                    <br />
                    <br />
                </div>
                <div class="table-wrapper table-responsive">
                    <table id="averagesTable" class="table table-striped table-bordered table-hover tablesorter">
                        <thead>
                            <tr>
                                <th style="width: 20px;">#</th>
                                <th>Team Number</th>
                                <th>Total Points</th>
                                <th>Autonomous Points</th>
                                <th>Teleop Points</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">

                        </tbody>
                    </table>
                </div>
                <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>
            </div>
        </div>
        <script type="text/javascript">
                    $(function() {
                        if (window.location.hash.indexOf("only") !== -1) {
                            onlyUs = true;
                            $("#only").addClass("active");
                            $("#all").removeClass("active");
                        } else {
                            onlyUs = false;
                        }
                        if (window.location.hash.indexOf("here") !== -1) {
                            onlyHere = true;
                            $("#global").removeClass("active");
                            $("#here").addClass("active");
                        } else {
                            onlyHere = false;
                        }
                        loadTable(onlyUs, onlyHere);
                        $("#averagesTable").tablesorter({
                            sortList: [[2, 1]]
                        });
                    });

                    var setFilterHash = function(thingToChange, thingToChangeTo) {
                        if (window.location.hash.indexOf(thingToChange) !== -1) {
                            window.location.hash = window.location.hash.replace(thingToChange, thingToChangeTo);
                        } else if (window.location.hash.indexOf(thingToChangeTo) === -1) {
                            if (window.location.hash === "") {
                                window.location.hash = thingToChangeTo;
                            } else {
                                window.location.hash = window.location.hash + "," + thingToChangeTo;
                            }
                        }
                    };

                    window.onhashchange = function() {
                        if (window.location.hash.indexOf("only") !== -1) {
                            onlyUs = true;
                        } else {
                            onlyUs = false;
                        }
                        if (window.location.hash.indexOf("global") !== -1) {
                            onlyHere = false;
                        } else {
                            onlyHere = true;
                        }
                        loadTable(onlyUs, onlyHere);
                    };


                    function loadTable(onlyLoggedInTeam, onlyThisLocation) {
                        $("#loading").show();
                        $.ajax({
                            url: '/ajax-handlers/load-frc-team-averages.php',
                            data: {
                                'onlyLoggedInTeam': onlyLoggedInTeam,
                                'onlyThisLocation': onlyThisLocation
                            },
                            success: function(response) {
                                $("#loading").hide();
                                $("#tableBody").html(response);
                                $("#averagesTable").trigger("update");
                                var sorting = [[2, 1]];
                                $("#averagesTable").trigger("sorton", [sorting]);
                            }
                        });
                    }
        </script>
    </body>
</html>
