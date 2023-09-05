<?php

    
    $idruta = $_POST["idRuta"];



    if(!empty($_FILES['file']['name'])){
        
        $uploadedFile = '';
        if(!empty($_FILES["file"]["type"])){
            
            // $fileName = time().'_'.$_FILES['file1']['name'];
            $fileName = $idruta .".png";
            $valid_extensions = array("png");
            $temporary = explode(".", $_FILES["file"]["name"]);
            
            $file_extension = end($temporary);
            
            if($_FILES["file"]["type"] == "image/png" && in_array($file_extension, $valid_extensions))
            {
                
                $sourcePath = $_FILES['file']['tmp_name'];
                $targetPath = "img/rutas/".$fileName;
                
                if(move_uploaded_file($sourcePath,$targetPath))
                {
                    $uploadedFile = $fileName;
                }
                // else
                // {
                //     echo "nosecopio"; return;    

                // }
            }
        }
        
                
        echo $uploadedFile != "" ?'ok':'err';
    }

