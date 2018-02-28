<?php
if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])) {
    $variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}else{
    $infoFlag=false;
    $variables=include_once __DIR__ . '/../templates/arrays/documents.php';
    $updir=dirname(__FILE__).'/../../file_uploaded/documents/';
    $fileToDisplay=array();
      /*===============  Display file stored in the system  ============*/
      $storedFile=setAllFile($updir);
      foreach ($storedFile as $value){
          $newValue='';
          if ($value=='.'||$value=='..'){
              continue;
          }
          $id=explode('_',$value);
          foreach ($id as $key=> $item){
              if ($key==0){
                  continue;
              }
              $newValue.=$item;
          }
          $fileToDisplay['fileArray'][$id[0]]=htmlentities($newValue);
      }
      $variables=array_merge($variables,$fileToDisplay);

      /*===============FILE UPLOAD SECTION================*/
        if(isset($_FILES['userfile'])){
            if (is_uploaded_file($_FILES['userfile']['tmp_name'])){
                if($_FILES['userfile']['error']==0){
                    $file= new SplFileInfo($_FILES['userfile']['name']);
                    $upfilename=$file->getFilename();
                    $tmpName=$_FILES['userfile']['tmp_name'];
                    $query="INSERT INTO `file_uploaded` (`file_name`";
                    if(isset($_POST['info'])){
                        if ($_POST['info']!==''){
                            $infoFlag=true;
                            $info=trim($_POST['info']);
                            if(strlen($info)<150){
                                $info=strtolower($info);
                                $info=ucfirst($info);
                                $query.=",`file_info`";
                            }else{
                                $variables['infoError']='Info are too long 150 characters allowed';
                            }
                        }
                        $query.=") ";
                    }
                    $query.="VALUES  ('$upfilename'";
                    if($infoFlag){
                        $query.=",'$info')";
                    }else{
                        $query.=")";
                    }
                    $mysqli->real_escape_string($query);
                    if ($mysqli->query($query)){
                        $id=$mysqli->insert_id;
                        $upfilename=$id.'_'.$upfilename;
                        $upfilename=$updir.$upfilename;
                        if(is_dir($updir)){
                            if (move_uploaded_file($tmpName,$upfilename)){
                                $variables['uploadStatus']='File correctly upload';
                                echo $twig->render('loader.html.twig',$variables);
                                header( 'refresh:1;url=index.php?page=documents' );
                            }else{
                                $variables['uploadStatus']='Failed to upload please try again';
                            }
                        }else{
                            die('upload directory missing');
                        }

                    }else{
                        die($mysqli->error);
                    }
                }else{
                    switch ($_FILES['userfile']['error']){
                        case 1:
                            $error='Max file size exceeded';
                        case 2:
                            $error='Max file sized exceeded';
                        case 3:
                            $error='File uploaded only partially';
                        case 4:
                            $error='No file was uploaded';
                        default:
                            $error='File not uploaded';
                    }
                    $variables['error']=$error;
                }
            }
        }

    echo $twig->render($template->getTemplate(),$variables);
}