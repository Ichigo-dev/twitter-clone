<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<p>次のフォームに必要事項をご記入ください。</p>
		<form action="" method="post" enctype="multipart/form-data">
		<dl>
		<dt>ニックネーム<span class="required">必須</span></dt>
		<dd><input type="text" name="name" size="35" maxlength="255" /></dd>
		<dt>メールアドレス<span class="required">必須</span></dt>
		<dd><input type="text" name="email" size="35" maxlength="255" /></dd>
		<dt>パスワード<span class="required">必須</span></dt>
		<dd><input type="password" name="password" size="10" maxlength="20"
		/></dd>
		<dt>写真など</dt>
		<dd><input type="file" name="image" size="35" /></dd>
		</dl>
		<div><input type="submit" value="入力内容を確認する" /></div>
		</form>
</body>
</html>