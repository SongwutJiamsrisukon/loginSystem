<?php

    if(isset($_POST['submit'])){

        include_once 'dbh.php';

        $first = mysqli_real_escape_string($conn,$_POST['first']);// mysqli_real_escape_string use to protect sqlinjection
        $last = mysqli_real_escape_string($conn,$_POST['last']);
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $uid = mysqli_real_escape_string($conn,$_POST['uid']);
        $pwd = mysqli_real_escape_string($conn,$_POST['pwd']);

        //Error handlers
        if(empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd)){//is not vlid
            header("Location: ../signup.php?signup=empty");
            exit();
        }else{//valid input
                if(!preg_match("/^[a-zA-Z]*$/", $first ) || !preg_match("/^[a-zA-Z]*$/", $last)){//check firstname, lastname
                    header("Location: ../signup.php?signup=invalid");
                    exit();
                }else{
                    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){//ceck email
                        header("Location: ../signup.php?signup=invalidEmail");
                        exit();
                    }
                    else{//check uid
                        $sql = "select * from users where user_id ='$uid';";
                        $result = mysqli_query($conn, $sql);
                        $resultCheck = mysqli_num_rows($result);

                        if($resultCheck > 0){//มีคนใช้ id นี้แล้ว
                            header("Location: ../signup.php?signup=usertaken");
                            exit();
                        }else{//hashing the password and insert to DB
                                $hashedPwd = password_hash($pwd,PASSWORD_DEFAULT);
                                //inset user into DB
                                $sql = "insert into users (user_first, user_last, user_email, user_uid, user_pwd) values ('$first','$last','$email','$uid','$hashedPwd');";
                                mysqli_query($conn, $sql);
                                header("Location: ../signup.php?signup=success");
                                exit();
                        }

                    }
                }
        }

    }else{
        header("Location: ../signup.php");
        exit();
    }
?>