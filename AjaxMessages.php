<?php
$db = new PDO('mysql:host=localhost;dbname=puissance4;charset=utf8', 'root', 'root');

$task = "list";

if(array_key_exists("task", $_GET)){
    $task = $_GET ['task'];
}


if($task == "write"){
    postMessage();
} else {
        getMessages();
        }


function getMessages(){
    global $db;
    $resultat=$db->query("SELECT * FROM `message` WHERE `id_user` = 8  ORDER BY `message`.`date_message` DESC LIMIT 20");
    $messages = $resultat->fetchAll();
    echo json_encode($messages); 
}


function postMessage(){
    global $db;

    if (!array_key_exists('message1', $_POST)){
        echo json_encode(["status" => "error", "message" => "Pas de message entré"]);
        return;
    }
    $id_user = 8;
    $id_game = 1;
    $message1 = htmlspecialchars($_POST['message1']);
    $date_message = date('Y-m-d H:i:s');



$query = $db->prepare("INSERT INTO message (`id`, `id_game`, `id_user` , `message`, `date_message`) 
                        VALUES              (NULL,$id_game,'$id_user','$message1','$date_message')");
$query->execute();
$query = $query->fetchAll();



echo json_encode(["status" => "Envoyé"]);
}

?>

