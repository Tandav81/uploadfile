<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Upload</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<h1>Upload de fichiers!</h1>
<div class="container-fluid">

    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
            <input type="file" name="fichier[]" multiple="multiple"/>
            <button class="btn-success" type="submit" name="submit" value="Send">Send</button>
        </div>
    </form>
    <hr>
    <div class="row">
        <?php

        $mimeAccepted = [
                'image/jpeg' => 'jpg',
                'image/gif' => 'gif',
                'image/png' => 'png',
        ];

        if(isset($_POST['delete'])){
            unlink($_POST['path']);

        }

        if (isset($_POST['submit'])) {

            if (count($_FILES['fichier']['name']) > 0) {
                //Loop through each file
                for ($i = 0; $i < count($_FILES['fichier']['name']); $i++) {
                    //Get the temp file path
                    $tmpFilePath = $_FILES['fichier']['tmp_name'][$i];

                    //Make sure we have a filepath
                    if ($tmpFilePath != "") {

                        //save the filename
                        $shortname = $_FILES['fichier']['name'][$i];

                        // extension
                        $ext = $mimeAccepted[$_FILES['fichier']['type'][$i]];

                        //save the url and the file
                        $filePath = "/home/wilder5/PhpstormProjects/upload/img/" . 'image'.uniqid() .'.'.$ext ;


                        //Upload the file into the temp dir
                        if (move_uploaded_file($tmpFilePath, $filePath)) {

                            $files[] = $shortname;
                            //insert into db
                            //use $shortname for the filename
                            //use $filePath for the relative url to the file

                        }
                    }
                }
            }
            //show success message
            echo "<h1>Uploaded:</h1>";
            if (is_array($files)) {
                echo "<ul>";
                foreach ($files as $file) {
                    echo "<li>$file</li>";
                }
                echo "</ul>";
            }

        }

        $dir = '/home/wilder5/PhpstormProjects/upload/img';
        $files1 = scandir($dir);


        unset($files1[0]);
        unset($files1[1]);

        foreach ($files1 as $file) {
            echo '<div class="col-xs-6 col-md-3">
                 <a href="#" class="thumbnail">
                    <img  src="img/' . $file . '" alt="">
                    <span>'.$file.'</span>
                    <form method="post">
                    <input type="hidden" value="'.$dir.'/'.$file.'" name="path">
                    <input type="submit" name="delete" class="btn btn-danger" value="delete">
                    </form>
                 </a>
              </div>';

        }



        ?>
    </div>
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">

    </script>
</body>
</html>