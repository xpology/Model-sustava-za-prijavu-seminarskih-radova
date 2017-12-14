<?php
  if(!empty($_FILES['uploaded_file']))
  {
    $path = "uploads/";
    $target_file = $path . basename( $_FILES['uploaded_file']['name']);
    if (file_exists($target_file)) {
        echo "Nažalost, datoteka već postoji.";
    }
    elseif(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $target_file)) {
      echo "Datoteka ".  basename( $_FILES['uploaded_file']['name']). 
      " uspješno prenesena.";
    } 
    else{
        echo "Greška prilikom prijenosa, pokušajte ponovo!";
    }
  }
?>