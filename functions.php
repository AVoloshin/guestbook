<?php
session_start();
/**
 * проверяет, отправку формы
 * @return bool
 *
 */
function ifFormSubmitted(){
    return(isset($_POST)and !empty($_POST));
}

/**
 * Собирает данные в массив
 * @return array
 */
function getData(){
    $formData=array();

    if(isset($_SERVER['REQUEST_TIME'])){
        $formData['time']=$_SERVER['REQUEST_TIME'];
    }
    else {
        $formData['time']='';
    }
    if(isset($_SERVER['REMOTE_ADDR'])){
        $formData['ip']=$_SERVER['REMOTE_ADDR'];
    }
    else{
        $formData['ip']='';
    }
    if(isset($_SERVER['HTTP_USER_AGENT'])){
        $formData['browser']=$_SERVER['HTTP_USER_AGENT'];
    }
    else{
        $formData['browser']='';
    }
    if(isset($_POST['name'])){
        $formData['name']=$_POST['name'];
    }
    else{
        $formData['name']='';
    }
    if(isset($_POST['email'])){
        $formData['email']=$_POST['email'];
    }
    else{
        $formData['email']='';
    }
    if(isset($_POST['text'])){
        $formData['text']=$_POST['text'];
    }
    else{
        $formData['text']='';
    }
    if(isset($_POST['captcha'])){
        $formData['captcha']=$_POST['captcha'];
    }
    else{
        $formData['captcha']='';
    }
    return $formData;
}
/**
 * генерирует капчу, на выходе массив с выражением для вывода и правильным ответом
 * вносит ответ в сессию
 * @return array
 *
 */
function genCaptcha(){
    $a=rand(1,50);
    $c=rand(50,100);
    $b=$c-$a;
    $tmp=array(0,1);
    $operator=array_rand($tmp);
    if($operator==0 && $a>$b){
        $captcha[]="$a-$b";
        $captcha[]=$a-$b;
    }
    else{
        $captcha[]="$a+$b";
        $captcha[]=$a+$b;
    }
    $_SESSION['captcha']=$captcha[1];
    return $captcha;
}


/**
 * Сверяет капчу из сессии с ответом пользователя
 * @param $captcha
 * @return bool
 *
 */
function validateCaptcha($captcha){
    if(isset($_SESSION['captcha'])){
        $check=$_SESSION['captcha'];
    }
    else{
        $check='';
    }
    return $check==$captcha;
}

/**
 * Проверяет валидность формы, если не валидна - выводит массив ошибок
 * @param array $formArray
 * @return array|bool
 */
function validateForm(array $formArray){
    $flag=true;
    if(strlen($formArray['name'])<0){
        $errors[]='Введите имя';
        $flag=false;
    }
    if(strlen ($formArray['email'])<5){
        $errors[]='Введите email';
        $flag=false;
    }
    if(strlen ($formArray['text'])<50){
        $errors[]='Введите сообщение не менее 50 символов';
        $flag=false;
    }
    if(!validateCaptcha($formArray['captcha'])){
        $errors[]='Неправильный ответ';
        $flag=false;
    }
    if(!$flag){
        return $errors;
    }
    else{
        return $flag;
    }
}

/**
 * @param $formData
 */
function writeDataToFile($formData){
    $file=fopen("..\\data\\data.txt","r+");
    fwrite($file,implode('|',$formData));
    fclose($file);
    return ("data.txt");

}
