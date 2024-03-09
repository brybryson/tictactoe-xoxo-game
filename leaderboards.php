<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

require_once "database.php";

// Retrieve user data and calculate win rate
$query = "SELECT p.FirstName, p.LastName, COUNT(s.id) AS matches_played, SUM(s.score) AS total_wins 
          FROM personal_info p
          LEFT JOIN scores s ON p.id = s.user_id
          GROUP BY p.id";
$result = mysqli_query($conn, $query);

$leaderboardData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $winRate = ($row['matches_played'] > 0) ? round(($row['total_wins'] / $row['matches_played']) * 100, 2) : 0;
    $leaderboardData[] = [
        'FirstName' => $row['FirstName'],
        'LastName' => $row['LastName'],
        'MatchesPlayed' => $row['matches_played'],
        'Wins' => $row['total_wins'],
        'WinRate' => $winRate
    ];
}

// Sort users by win rate (descending order)
usort($leaderboardData, function ($a, $b) {
    return $b['WinRate'] - $a['WinRate'];
});
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Leaderboards.css">
    <title>Tic-Tac-Toe Game</title>
    <link rel="icon" href="new-logo-icon.PNG">
</head>

<body>
    <div class="main-container">
        <!-- LOGO -->
        <div class="logo-container">
            <div class="header">
                <div class="button">
                    <a href="login.php"><button id="login" onclick="playButtonClickAndSound()">HOME</button></a>
                </div>
            </div>
            <div class="container">
                <div class="content-container">
                    <div class="content-1">
                        <div class="textmo">Leaderboard</div>
                    </div>
                    <div class="content-2">
                        <div class="boxcontent">
                            <div class="content">
                                <table id="leaderboards">
                                    <tr>
                                        <th>Ranking</th>
                                        <th>Name</th>
                                        <th>Matches</th>
                                        <th>Wins</th>
                                        <th>Win Rate (%)</th>
                                    </tr>
                                    <?php
                                    // Loop through the leaderboard data retrieved from the database
                                    // and populate the table rows dynamically
                                    foreach ($leaderboardData as $rank => $user) {
                                        echo "<tr>";
                                        echo "<td>" . ($rank + 1) . "</td>";
                                        echo "<td>" . $user['FirstName'] . " " . $user['LastName'] . "</td>";
                                        echo "<td>" . $user['MatchesPlayed'] . "</td>";
                                        echo "<td>" . $user['Wins'] . "</td>";
                                        echo "<td>" . $user['WinRate'] . "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- AUDIO - BUTTON CLICKING SOUNDS -->
    <audio id="clickSound">
        <source src="alert-sound.mp3" type="audio/mpeg">
    </audio>
    <div class="footer">
        <p>© Copyright 2024 | All rights reserved.<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Created by <span>Angcot · Fesariton · Melliza · Quintos · Sosas</span>
        </p>
        <div class="right-side-footer">
            <p class="hi">Connect with us &nbsp; </p>
            <a href="https://www.facebook.com/inytwjo"><img class="icon" src="envelope.svg" alt="Envelope"></a>
            <a href="https://www.facebook.com/inytwjo"><img class="icon" src="facebook.svg" alt="Facebook"></a>
        </div>
    </div>
    <script src="landing-2.js"></script>
</body>

</html>
