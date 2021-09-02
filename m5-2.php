<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>

<?php
    // DB接続設定
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
      
    //テーブルを制作
    $sql = "CREATE TABLE IF NOT EXISTS techtech"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date char(32),"
    . "pass char(32)"
    .");";
    $stmt = $pdo->query($sql);
    
    //投稿機能
     if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass"]) && empty($_POST["karabako"])){
        $name=$_POST["name"];
        $comment=$_POST["comment"];
        $pass=$_POST["pass"];
        $date=date("Y/m/d H:i:s");
        $sql = $pdo -> prepare("INSERT INTO techtech (name, comment, pass, date) VALUES (:name, :comment, :pass, :date)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
    $sql -> execute();//実行
     }
    
    
    
    //編集機能　フォームに表示
    if(!empty($_POST["edit"])&& !empty($_POST["editpass"])){
        $id=$_POST["edit"];
        $editpass=$_POST["editpass"];
        
    $sql = 'SELECT * FROM techtech';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        if(($row['id']==$id)&&($row['pass']==$editpass)){
        $editnumber=$row['id'];
        $editname=$row['name'];
        $editcoment=$row['comment'];
    
    }
    }
    }
     
     //編集機能
    if(!empty($_POST["name"])&&!empty($_POST["comment"])&&!empty($_POST["pass"])&&!empty($_POST["karabako"])){
        $id=$_POST["karabako"];
        $editpass1=$_POST["pass"];
        $name = $_POST["name"];
        $comment = $_POST["comment"]; 
        $date=date("Y/m/d H:i:s");
        
    $sql = 'UPDATE techtech SET name=:name,comment=:comment,pass=:pass,date=:date WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $editpass1, PDO::PARAM_STR);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
        
        
    }
     
     
     //削除機能
    if(!empty($_POST["num"]) && !empty($_POST["delpass"])){
        $id =$_POST["num"];
        $delpass=$_POST["delpass"];
        
    $sql = 'SELECT * FROM techtech';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        if(($row['id']==$id)&&($row['pass']==$delpass)){
        $name="削除しました";
        $comment=" ";
        $date=" ";
        $pass=" ";
        $sql = 'UPDATE techtech SET name=:name,comment=:comment,pass=:pass,date=:date WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $editpass1, PDO::PARAM_STR);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    }
    }
    }
    
    
    
         ?>
  <h1 class="midashi_1" style="color:saddlebrown"> 
        <div style="background-color:lightblue">簡易掲示板</div></h1>

    　<span style="color:saddlebrown"> <strong>コメントの投稿</strong>
    <form action="" method="post">
        <input type="text" name="name" placeholder="名前を入力" value="<?php if(isset($editname)) {echo $editname;} ?>">
        <input type="text" name="pass" placeholder="パスワードを入力"><br>
        <input type="text" name="comment" placeholder="コメント" value="<?php if(isset($editcoment)) {echo $editcoment;} ?>"
        style="width:330px;height:80px;">
        <input type="hidden" name="karabako" value="<?php if(isset($editnumber)) {echo $editnumber;} ?>">
        <input type="submit" name="submit" value="送信">
    </form>
    　<strong>コメントの削除</strong>
    <form action="" method="post">
        <input type="number" name="num" placeholder="削除対象番号入力">
        <input type="text" name="delpass" placeholder="パスワードを入力">
        <input type="submit" name="delete" value="削除">
    </form>
    　<strong>コメントの編集</strong></span>
    <form action="" method="post">
        <input type="number" name="edit" placeholder="編集対象番号入力">
        <input type="text" name="editpass" placeholder="パスワードを入力">
        <input type="submit" name="editor" value="編集">
    </form>
    <span style="color:saddlebrown">
    <h2><div style="background-color:lightblue">コメント一覧</div></h2></span>
</body>
</html>

<?php
    $sql = 'SELECT * FROM techtech';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].' ';
        echo $row['name'].' ';
        echo $row['comment'].' ';
        echo $row['date'].'<br>';
    echo "<hr>";
    }
    
    ?>
