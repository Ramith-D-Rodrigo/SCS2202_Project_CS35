
    $sendCodeFlag = false; //flag to check if we want to send email verification code
    $prevEmail = '';    //store the previous email of the user
    //check if user wants to change the email
    if(isset($_POST['email'])){ //has set an email
        $emailCheck = Security::checkEmailAvailability($_POST['email']);
        if($emailCheck === false){
            $returnMsg['errMsg'] = 'Email already in use';
            echo json_encode($returnMsg);
            exit();
        }
        else{
            $sendCodeFlag = true;
        }
    }

    //check if user wants to change the password
    if(isset($_POST['newPassword']) && isset($_POST['newPasswordConfirm'])){
        if($_POST['newPassword'] != $_POST['newPasswordConfirm']){
            $returnMsg['errMsg'] = 'Passwords do not match';
            echo json_encode($returnMsg);
            exit();
        }
        else{
            $sendCodeFlag = true;
        }
    }