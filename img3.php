<?php
	$path = 'i/';
	$files = scandir($path);
	$tmp_path = 'tmp/';
	$types = array('image/gif', 'image/png', 'image/jpeg');
	$size = 1024000;

	if (isset($_POST['save'])) {
		if (!in_array($_FILES['picture']['type'], $types))
			die('Запрещённый тип файла. <a href="?">Попробовать другой файл?</a>');
		if ($_FILES['picture']['size'] > $size)
			die('Слишком большой размер файла. <a href="?">Попробовать другой файл?</a>');
		if (!@copy($_FILES['picture']['tmp_name'], $path . $_FILES['picture']['name']))
			echo 'Что-то пошло не так';
		else
			echo 'Загрузка удачна <a href="' . $path . $_FILES['picture']['name'] . '">Посмотреть</a> ' ;
	};

	function delete_bg() {
		global $path, $files;

		for ($i = 0; $i < count($files); $i++) { 
    		if (($files[$i] != ".") && ($files[$i] != "..")) { 

				$im = imagecreatefromjpeg($path.$files[$i]);
				imagetruecolortopalette($im, false, 255);

				$colors = array(
				    array(255, 255, 255)
				);

				foreach($colors as $id => $rgb)	{
				    $result = imagecolorclosest($im, $rgb[0], $rgb[1], $rgb[2]);

				    $bg = imagecolorat($im, 0, 0);
				    imagecolorset($im, $bg, 0, 0, 255);


				    imagealphablending($im, false);
					imagesavealpha($im, true);
				    $blue = imagecolorexact($im, 0, 0, 255);
					imagecolortransparent($im, $blue);

				    $save = "i/". $files[$i] .".png";
					imagepng($im, $save);
					imagedestroy($im);
				}
			}
		}
	};

	if (isset($_POST['create'])) {
	    echo delete_bg();
	    return;
	};
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Загрузка изображения</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body>
		<form method="post" enctype="multipart/form-data">
			<input type="file" name="picture">
			<input type="submit" name="save" value="Загрузить">
		</form>
		<form method="post" action="">
		    <input type="submit" name="create" value="Удалить фон">
		</form>
	</body>
</html>