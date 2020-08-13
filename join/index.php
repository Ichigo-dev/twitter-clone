<?php
    require('../dbconnect.php');

    session_start();

    $error=array('name'=>'','email'=>'','password'=>'','image'=>'');

    if(!empty($_POST)){
        // エラー項目の確認
        if($_POST['name']==''){
            $error['name']='blank';
        }
        if($_POST['email']==''){
            $error['email']='blank';
        }
        if(strlen($_POST['password'])<4){
            $error['password']='length';
        }
        if($_POST['password']==''){
            $error['password']='blank';
        }

        $fileName=$_FILES['image']['name'];
        if(!empty($fileName)){
            $ext=substr($fileName,-3);
            if($ext != 'jpg' && $ext!= 'gif'){
                $error['image']='type';
            }
        }

        if($error['name']=='' && $error['email']=='' && $error['password']=='' && $error['image']==''){
            $member=$db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE email=?');
            $member->execute(array($_POST['email']));
            $record=$member->fetch();
            if($record['cnt']>0){
                $error['email']='duplicate';
            }
        }

        if($error['name']=='' && $error['email']=='' && $error['password']=='' && $error['image']==''){
            // 画像をアップロードする
            $image=date('YmdHis').$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],'../member_picture/'.$image);
            $_SESSION['join']=$_POST;
            $_SESSION['join']['image']=$image;
            header('Location: check.php');
            exit();
        }
    }
    if(!empty($_REQUEST['action'])){
        if($_REQUEST['action']=='rewrite'){
            $_POST=$_SESSION['join'];
        }
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録</title>
</head>
<body>
<p>次のフォームに必要事項をご記入ください。</p>
		<form action="" method="post" enctype="multipart/form-data">
            <dl>
                <dt>ニックネーム<span class="required">必須</span></dt>
                <dd>
                    <input type="text" name="name" size="35" maxlength="255" value="<?php empty($_POST) ? print "" : print htmlspecialchars($_POST['name'],ENT_QUOTES); ?>"/>
                    <?php if($error['name']=='blank'): ?>
                    <p>＊ニックネームを入力してください</p>
                    <?php endif; ?>
                </dd>

                <dt>メールアドレス<span class="required">必須</span></dt>
                <dd>
                    <input type="text" name="email" size="35" maxlength="255" value="<?php empty($_POST) ? print "" : print htmlspecialchars($_POST['email'],ENT_QUOTES); ?>"/>


                    <?php if($error['email']=='blank'): ?>
                    <p>＊メールアドレスを入力してください</p>
                    <?php elseif($error['email']=='duplicate'): ?>
                    <p>＊指定されたメールアドレスは既に登録されています</p>
                    <?php endif; ?>
                </dd>

                <dt>パスワード<span class="required">必須</span></dt>
                <dd>
                    <input type="password" name="password" size="10" maxlength="20"/>

                    <?php if($error['password']=='blank'): ?>
                    <p>＊パスワードを入力してください</p>
                    <?php elseif($error['password']=='length'): ?>
                    <p>＊4文字以上入力してください</p>
                    <?php endif; ?>
                </dd>
                <dt>写真など</dt>
                <dd>
                    <input type="file" name="image" size="35" />
                    <?php if($error['image']=='type'): ?>
                    <p>＊写真は.jpgか.gif形式で指定してください</p>
                    <?php endif; ?>


                </dd>
            </dl>
            <div><input type="submit" value="入力内容を確認する" /></div>
		</form>
</body>
</html>