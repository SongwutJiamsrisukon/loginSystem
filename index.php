<?php include_once 'header.php'?>

    <section class = "main-container">
        <div class="main-wrapper">
            <h2> Home </h2>
        </div>
    </section>

    <div class="main-wrapper">
        <?php
            if(isset($_SESSION['u_id'])){
                echo "You are log in with session:".$_SESSION['u_first'];
            }
        ?>
    </div>

<?php include_once 'footer.php'?>