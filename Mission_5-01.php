<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
    <div class ="main">
        <div class ="contact-form">
            <div class ="form-title">掲示板</div>
            <form method ="post" action="">
                <div class="form-item">名前</div>
                <input type="text" name="name" placeholder="名前を入力してください">
                <div class="form-item">内容</div>
                <textarea name ="body" placeholder="内容を入力してください"></textarea>
                <br>
                <input type="submit" name="submit" value="送信">
                <div class="form-item">削除項目</div>
                <input type="number" name="del" placeholder="削除する番号を入力してください"></textarea>
                <br>
                <input type="submit" name="delete" value="削除">
                <div class="form-item">編集番号</div>
                <input type="number" name="edit" placeholder="編集したい番号を入力してください">
                <br>
                <input type="submit" name="ed" value="編集">
            </form>
        </div>
    </div>
    <?php
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, 
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        $sql = "CREATE TABLE test"
	    ." ("
	    . "id INT AUTO_INCREMENT PRIMARY KEY,"
	    . "name char(32),"
	    . "comment TEXT"
	    .");";
	    $stmt = $pdo->query($sql);
        $sql ='SHOW TABLES';
	    $result = $pdo -> query($sql);
	    foreach ($result as $row){
		    echo $row[0];
		    echo '<br>';
	    }
	    echo "<hr>";
	    $sql = $pdo -> prepare("INSERT INTO test (name, comment) VALUES (:name, :comment)");
	    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
	    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	    $name = $_POST["name"];
	    $comment = $_POST["body"];
	    $del = $_POST["del"];
	    $edit = $_POST["edit"];
	    if(empty($name)==false && empty($comment)==false 
                && empty($del)==true && empty($edit)==true){
	        $sql -> execute();
	        $sql = 'SELECT * FROM test';
	        $stmt = $pdo->query($sql);
	        $results = $stmt->fetchAll();
	        foreach ($results as $row){
		        //$rowの中にはテーブルのカラム名が入る
		        echo $row['id'].',';
		        echo $row['name'].',';
		        echo $row['comment'].'<br>';
	            echo "<hr>";
	        }
        }
        if(empty($del)==false){
            $id = $del;
	        $sql = 'delete from test where id=:id';
	        $stmt = $pdo->prepare($sql);
	        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	        $stmt->execute();
	        $sql = 'SELECT * FROM test';
	        $stmt = $pdo->query($sql);
	        $results = $stmt->fetchAll();
	        foreach ($results as $row){
		        //$rowの中にはテーブルのカラム名が入る
		        echo $row['id'].',';
		        echo $row['name'].',';
		        echo $row['comment'].'<br>';
	            echo "<hr>";
	        }
        }
        if(empty($edit)==false && empty($name)==false && 
        empty($comment)==false){
            $id = $edit; //変更する投稿番号
	        $name = $name;
	        $comment = $comment; 
	        $sql = 'UPDATE test SET name=:name,comment=:comment WHERE id=:id';
	        $stmt = $pdo->prepare($sql);
	        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
	        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	        $stmt->execute();
	        $sql = 'SELECT * FROM test';
	        $stmt = $pdo->query($sql);
	        $results = $stmt->fetchAll();
	        foreach ($results as $row){
		        //$rowの中にはテーブルのカラム名が入る
		        echo $row['id'].',';
		        echo $row['name'].',';
		        echo $row['comment'].'<br>';
	            echo "<hr>";
	        }
        }
        
        
    ?>
</body>
</html>