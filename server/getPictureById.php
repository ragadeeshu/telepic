<?php
require("clientCommon.php");
$file = $_POST['file'];
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . basename($file));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
ob_clean();
flush();
if(isset($_POST['h'])){

    /* Resize image based on height */

    $type=image_type_to_mime_type( exif_imagetype ( $file  ) );
    
                            switch( $type ){
                                case 'image/jpeg':
                                    $source_image = imagecreatefromjpeg($file);
                                    $width = imagesx($source_image);
                                    $height = imagesy($source_image);
                                    $desired_width = floor($width * ($_POST['h'] / $height));
                                    $virtual_image = imagecreatetruecolor($desired_width,$_POST['h']);
                                    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $_POST['h'], $width, $height);
                                    imagejpeg($virtual_image);
                                    imagedestroy($virtual_image);
                                break;
                                case 'image/gif':
                                    $source_image = imagecreatefromgif($file);
                                    $width = imagesx($source_image);
                                    $height = imagesy($source_image);
                                    $desired_width = floor($width * ($_POST['h'] / $height));
                                    $virtual_image = imagecreatetruecolor($desired_width,$_POST['h']);
                                    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $_POST['h'], $width, $height);
                                    imagegif($virtual_image);
                                    imagedestroy($virtual_image);
                                break;

                                case 'image/png':
                                    imagealphablending( $image_p, false );
                                    imagesavealpha( $image_p, true );
                                    $source_image = imagecreatefrompng($file);
                                    $width = imagesx($source_image);
                                    $height = imagesy($source_image);
                                    $desired_width = floor($width * ($_POST['h'] / $height));
                                    $virtual_image = imagecreatetruecolor($desired_width,$_POST['h']);
                                    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $_POST['h'], $width, $height);
                                    imagepng($virtual_image);
                                    imagedestroy($virtual_image);
                                break;
                            }
                        }
    if(isset($_POST['w'])){

    /* Resize based on width */
    $type=image_type_to_mime_type( exif_imagetype ( $file  ) );
    
                            switch( $type ){
                                case 'image/jpeg':
                                    $source_image = imagecreatefromjpeg($file);
                                    $width = imagesx($source_image);
                                    $height = imagesy($source_image);
                                    $desired_height = floor($height * ($_POST['w'] / $width));
                                    $virtual_image = imagecreatetruecolor($_POST['w'],$desired_height);
                                    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $_POST['w'],$desired_height, $width, $height);
                                    imagejpeg($virtual_image);
                                    imagedestroy($virtual_image);
                                break;
                                case 'image/gif':
                                    $source_image = imagecreatefromgif($file);
                                    $width = imagesx($source_image);
                                    $height = imagesy($source_image);
                                    $desired_height = floor($height * ($_POST['w'] / $width));
                                    $virtual_image = imagecreatetruecolor($_POST['w'],$desired_height);
                                    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $_POST['w'], $desired_height, $width, $height);
                                    imagegif($virtual_image);
                                    imagedestroy($virtual_image);
                                break;

                                case 'image/png':
                                    imagealphablending( $image_p, false );
                                    imagesavealpha( $image_p, true );
                                    $source_image = imagecreatefrompng($file);
                                    $width = imagesx($source_image);
                                    $height = imagesy($source_image);
                                    $desired_height = floor($height * ($_POST['w'] / $width));
                                    $virtual_image = imagecreatetruecolor($_POST['w'],$desired_height);
                                    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $_POST['w'], $desired_height, $width, $height);
                                    imagepng($virtual_image);
                                    imagedestroy($virtual_image);
                                break;
                            }
                        }

readfile($file);
exit;
