<?php
include_once('../inc/functions.php');

$formData=getData();

if(ifFormSubmitted()){
    $rezult=validateForm($formData);
    if($rezult===true){
        writeDataToFile($formData);
    }
    else {
        echo(implode(",", validateForm($formData)));;
    }
}

$captcha=genCaptcha();
$form=<<<EOD
    <div id="form">
        <form method="post" enctype="multipart/form-data>
            <input class="input" type="text" name="name" placeholder="Ваше имя"><br>
            <input class="input" type="email" name="email" placeholder="Ваше имя"><br>
            <textarea class="textarea" name="text" placeholder="Введите сообщение"></textarea><br>
            $captcha[0];
            <input class="input" name="captcha" placeholder="Введите ответ" required><br>
            <input type="hidden" name="max_file_size" value="51200">
            <input type="file" name="myfile">
            <input class="input" name='submit' type="submit" value="Отправить"><br>
        </form>
    </div>
EOD;
echo $form;






