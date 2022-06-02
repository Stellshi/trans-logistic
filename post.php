<?php
    $msg_box = ""; // в этой переменной будем хранить сообщения формы
    $errors = array(); // контейнер для ошибок
    // проверяем корректность полей
	if($_POST['form_email'] == "")   $errors[] = "Поле <span style='color: #666;'>Ваш e-mail</span> не заполнено";
    if($_POST['form_name'] == "")    $errors[] = "Поле <span style='color: #666;'>Ваше имя</span> не заполнено";
    if($_POST['form_message'] == "") $errors[] = "Поле <span style='color: #666;'>Текст сообщения</span> не заполнено";
 
    // если форма без ошибок
    if(empty($errors)){     
        // собираем данные из формы
        $message  = "Имя пользователя: " . $_POST['form_name'] . "<br/>";
        $message .= "E-mail пользователя: " . $_POST['form_email'] . "<br/><br/>";
        $message .= "Текст письма: " . $_POST['form_message'];      
        send_mail($message); // отправим письмо
        // выведем сообщение об успехе
        $msg_box = "<span style='color: green;font-size: 1.4em;'>Спасибо за обращение, сообщение успешно отправлено! <br/> В течении 24 часов я Вам отвечу!<br/></span><br/>";

    }else{
        // если были ошибки, то выводим их
        $msg_box = "";
        foreach($errors as $one_error){
            $msg_box .= "<style>.messages{margin-bottom: 20px;}</style><span style='color: red;font-size: 1.2em;'>$one_error</span><br/>";
        }
    }
 
    // делаем ответ на клиентскую часть в формате JSON
    echo json_encode(array(
        'result' => $msg_box
    ));
     
     
    // функция отправки письма
    function send_mail($message){
        // почта, на которую придет письмо
        $mail_to = "artemt-95@yandex.ru"; 
        // тема письма
        $subject = "Письмо с обратной связи";
         
        // заголовок письма
        $headers= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма
        $headers .= "From: Название сайта <no-reply@test.com>\r\n"; // от кого письмо
         
        // отправляем письмо 
        mail($mail_to, $subject, $message, $headers);
    }
     
?>