<?php
	$path = 'i/';
	$files = scandir($path);

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
			}
		}
	}
?>