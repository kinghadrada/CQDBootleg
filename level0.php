<?php
session_start();
//CHANGE THESE WHEN USING ONLINE
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "1234";
$dbname = "cypher73";
date_default_timezone_set("Asia/Calcutta");
$check="nil";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$lvl=0;
    if(!(isset($_SESSION["username"])))
    {
        header("Location: http://localhost/Cypher/level0.php"); 
        exit;
    }
    if($_SESSION['lvl']!=$lvl)
    {
        header("Location: http://localhost/Cypher/level".$_SESSION['lvl'].".php"); 
        exit;    
    }
    if(isset($_POST['submit']))
    {
        if($_POST['answer']=="swift")
        {
            $_SESSION["lvl"] = 1;
            $d = date("Y-m-d G:i:s");
            $answer = mysqli_real_escape_string($conn,$_POST['answer']);
            $ins="INSERT INTO userResponses (`username`, `lvl`, `response`, `time`) VALUES ('{$_SESSION["username"]}', '{$lvl}', '{$answer}', '{$d}')";
            $query="UPDATE users SET lvl='{$_SESSION["lvl"]}', tlc='{$d}' WHERE username='{$_SESSION["username"]}'";
            mysqli_query($conn,$query);
            mysqli_query($conn,$ins);
            header("Location: http://localhost/Cypher/level".$_SESSION['lvl'].".php");
            exit;
        }
        else
        {
            $d = date("Y-m-d G:i:s");
            $ins="INSERT INTO userResponses (`username`, `lvl`, `response`, `time`) VALUES ('{$_SESSION["username"]}', '{$lvl}', '{$_POST['answer']}', '{$d}')";
            mysqli_query($conn,$ins);
            $check="incorrect";    
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Cypher | Level 0</title>
        <link rel="icon" href="favicon.png">
        <link rel="stylesheet" href="css/levels.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $("input[type=text]").removeClass("incorrect");
                }, 1000);
            });
        </script>
    </head>

    <body>
        <nav>
            <ul>
                <li><a href="http://localhost/Cypher/level<?php echo htmlentities($_SESSION['lvl'])?>.php" class="my-nav-text-anchor">Play</a></li>
                <li><a href="http://localhost/Cypher/lead.php" class="my-nav-text-anchor">LeaderBoard</a></li>
                <li><a href="http://localhost/Cypher/rules.html" class="my-nav-text-anchor">Rules</a></li>
                <li><a href="http://localhost/Cypher/logout.php" class="my-nav-text-anchor">Logout</a></li>
            </ul>
        </nav>
        <section class="my-first">
            <div class="my-question">
                <h1 class="my-heading">Level 0</h1>
                <p>
                    <a href="http://localhost/Cypher/files/ME16.xlsx">Clue</a>
                </p>
                <form action="http://localhost/Cypher/level0.php" method="post">
                    <input class="<?php echo htmlentities($check)?>" type="text" autocomplete="off" name="answer" placeholder="answer" />
                    <input name="submit" type="submit" value="Check" />
                </form>
            </div>
        </section>
    </body>
    <?php
mysqli_close($conn);
?>

    </html>
