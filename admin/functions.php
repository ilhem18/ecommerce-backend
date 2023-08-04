<?php
require '../controllers/config.php';

if(isset($_POST['addproduct'])){
    $pname = $_POST['pname'];
    $pprice = $_POST['pprice'];
    $pdescription = $_POST['productDescription'];
    $pstock = $_POST['pstock'];

    $insertArticle = "INSERT INTO article(name, price, Instock, description) VALUES (:name, :price, :instock, :description)";
    $stmtArticle = $con->prepare($insertArticle);
    $stmtArticle->bindParam(':name', $pname);
    $stmtArticle->bindParam(':price', $pprice);
    $stmtArticle->bindParam(':instock', $pstock);
    $stmtArticle->bindParam(':description', $pdescription);
    $stmtArticle->execute();
    //get the id of the last inserted article
    $idArticle = $con->lastInsertId();

    //add multiple categories in one row
    $categories = implode(',', $_POST['categorie']);
    $insertCat = "INSERT INTO categorie (name) VALUES (:name)";
    $stmtCat = $con->prepare($insertCat);
    $stmtCat->bindParam(':name', $categories);
    $stmtCat->execute();
    //get the id of the categories selected
    $idCategorie = $con->lastInsertId();

    //bind the categories with product 
    $categorieProduct = "INSERT INTO categoriearticle (articleID, categorieID) VALUES (:articleID, :categorieID)";
    $stmtcatArt = $con->prepare($categorieProduct);
    $stmtcatArt->bindParam(':articleID', $idArticle);
    $stmtcatArt->bindParam(':categorieID', $idCategorie);
    $stmtcatArt->execute();
    

    //sizes
    $sizeXS = $_POST['sizeXS'];
    $sizeS = $_POST['sizeS'];
    $sizeM = $_POST['sizeM'];
    $sizeL = $_POST['sizeL'];
    $sizeXL = $_POST['sizeXL'];
    $sizeXXL = $_POST['sizeXXL'];
    $sizeXXXL = $_POST['sizeXXXL'];
    //validate the sizes inserted
    if(!is_numeric($sizeXS) || $sizeXS < 0){
        echo "re-check the value of XS sizes please!";
    }
    if(!is_numeric($sizeS) || $sizeS < 0){
        echo "re-check the value of S sizes please!";
    }
    if(!is_numeric($sizeM) || $sizeM < 0){
        echo "re-check the value of M sizes please!";
    }
    if(!is_numeric($sizeL) || $sizeL < 0){
        echo "re-check the value of L sizes please!";
    }
    if(!is_numeric($sizeXL) || $sizeXL < 0){
        echo "re-check the value of XL sizes please!";
    }
    if(!is_numeric($sizeXXL) || $sizeXXL < 0){
        echo "re-check the value of 2XL sizes please!";
    }
    if(!is_numeric($sizeXXXL) || $sizeXXXL < 0){
        echo "re-check the value of 3XL sizes please!";
    }

    //sanitize the size qte
    $sizeXS = filter_var($sizeXS, FILTER_SANITIZE_NUMBER_INT);
    $sizeS = filter_var($sizeS, FILTER_SANITIZE_NUMBER_INT);
    $sizeM = filter_var($sizeM, FILTER_SANITIZE_NUMBER_INT);
    $sizeL = filter_var($sizeL, FILTER_SANITIZE_NUMBER_INT);
    $sizeXL = filter_var($sizeXL, FILTER_SANITIZE_NUMBER_INT);
    $sizeXXL = filter_var($sizeXXL, FILTER_SANITIZE_NUMBER_INT);
    $sizeXXXL = filter_var($sizeXXXL, FILTER_SANITIZE_NUMBER_INT);

    $totalSizeQte = $sizeXS + $sizeS + $sizeM + $sizeL + $sizeXL + $sizeXXL + $sizeXXXL;
    if($pstock > $totalSizeQte || $pstock < $totalSizeQte){
        echo "Error : stock quantity shouldn't be greater or less than the total size quatity.";
    }


    $sizes = [
        'XS' => $sizeXS,
        'S' => $sizeS,
        'M' => $sizeM,
        'L' => $sizeL,
        'XL' => $sizeXL,
        'XXL' => $sizeXXL,
        'XXXL' => $sizeXXXL,
    ];

    foreach($sizes as $sizeName => $qte){
       $insertSizes = "INSERT INTO size(name, nbrStock, articleID) VALUES (:name, :nbrstock, :articleID)";
       $stmtSize = $con->prepare($insertSizes);
       $stmtSize->bindParam(':name', $sizeName);
       $stmtSize->bindParam(':nbrstock', $qte);
       $stmtSize->bindParam(':articleID', $idArticle);
       $stmtSize->execute();
    }

    //code to upload product's images
    if(isset($_FILES['pimg'])){
    $targetDir = "../pics/";
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');

    $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
    $fileNames = array_filter($_FILES['pimg']['name']);
    if(!empty($fileNames)){
        foreach($_FILES['pimg']['name'] as $key => $val){
            //file upload path
            $fileName = $basename($_FILES['pimg']['name'][$key]);
            $targetFilePath = $targetDir . $fileName;

            //check wether file type is valid
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            if(in_array($fileType, $allowTypes)){
                if(move_uploaded_file($_FILES["pimg"]["tmp_name"][$key], $targetFilePath)){
                    //img db insert sql 
                    $insertValuesSQL .= "('" .$fileName. "'),";
                } else {
                    $errorUpload .= $_FILES['pimg']['name'][$key]. '|';
                }
            } else {
                $errorUploadType .= $_FILES['pimg']['name'][$key]. '|';
            }
        }
        //error message 
        $errorUpload = !empty($errorUpload)?'Upload Error:' .trim($errorUpload, ' | '): '';
        $errorUploadType = !empty($errorUploadType)?'File Type Error:' .trim($errorUploadType, ' | '): '';
        $errorMsg = !empty($errorUpload)?'<br/>' .$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType;

        if(!empty($insertValuesSQL)){
            $insertValuesSQL = trim($insertValuesSQL, ',');
            //insert image file name into database
            $inserImg = "INSERT INTO image(ImageURL, articleID) VALUES (:img, :articleID)";
            $stmtIMG = $con->prepare($inserImg);
            $stmtIMG->bindValue(':img', $insertValuesSQL, PDO::PARAM_LOB);
            $stmtIMG->bindParam(':articleID', $idArticle);
            $stmtIMG->execute();
            $result = $stmtIMG->fetch(PDO::FETCH_ASSOC);
            if($result){
                $statusMsg = "Files are uploaded successfully." .$errorMsg;
            } else {
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        } else {
            $statusMsg = "Upload failed!" .$errorMsg;
        }
    } 
} else {
        $statusMsg = "please select a file to upload.";
    }
}
?>