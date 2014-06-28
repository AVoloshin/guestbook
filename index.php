<?php
include_once('inc/functions.php');

$msg="";
$form=getTemplate('form');
$formData=getData();
$message = getTemplate('message');

if(ifFormSubmitted()){
    $rezult=validateForm($formData);

    if($rezult==true){
        writeDataToFile($formData);
        header('Location: '.$_SERVER['REQUEST_URI']);
    }
    else {
        $form = processTemplateErrorOutput($form, $rezult);
    }
}

$data=getMessageFromData();
$numStr=countData($data);
$pageNum=isset($_GET['page']) ? (int)$_GET['page']: 1;
$pageSize=isset($_GET['pageSize']) ? (int)$_GET['pageSize']: 10;
$pageCount=countPages($numStr,$pageSize);
$pageContent=getNumPage($data, $pageNum, $pageSize);



$form=processTemplace($form, $formData);
$page=processTemplace(getTemplate('page'), array(
    'FORM'=>$form,
    'captcha'=>genCaptcha(),
    'MSG'=>$msg,
    'PAGINATOR' => getPaginator($pageCount),
    'MESSAGE' => pageText ($pageContent)

));

echo $page;








