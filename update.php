<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$nama = $deskripsi =  $jenis =$stock =$uas ="";
$nama_err = $deskripsi_err  =$jenis_err =$stock_err =$uas_err ="";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    
      // Validate nama
      $input_nama = trim($_POST["nama"]);
      if(empty($input_nama)){
        $nama_err = "Please enter a nama.";
    } elseif(!filter_var($input_nama, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nama_err = "Please enter a valid nama.";
    } else{
        $nama = $input_nama;
    }

      // Validate deskripsi
    $input_deskripsi = trim($_POST["deskripsi"]);
    if(empty($input_deskripsi)){
        $deskripsi_err = "Please enter a deskripsi.";
    } elseif(!filter_var($input_deskripsi, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $deskripsi_err = "Please enter a valid deskripsi.";
    } else{
        $deskripsi = $input_deskripsi;
    }

    
    // Validate jenis
    $input_jenis = trim($_POST["jenis"]);
    if(empty($input_jenis)){
        $jenis_err = "Please enter a jenis.";
    } elseif(!filter_var($input_jenis, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $jenis_err = "Please enter a valid jenis.";
    } else{
        $jenis = $input_jenis;
    }

    // Validate stock
    $input_stock = trim($_POST["stock"]);
    if(empty($input_stock)){
        $stock_err = "Please enter the stock value.";
    } elseif(!ctype_digit($input_stock)){
        $stock_err = "Please enter a positive integer value.";
    } else{
        $stock = $input_stock;
    }


    // Check input errors before inserting in database
    if(empty($nama_err) && empty($deskripsi_err) && empty($jenis_err)  && empty($stock_err) ){
        // Prepare an insert statement
        $sql = "UPDATE mahasiswa SET name=?, deskripsi=?, jenis=?, stock=? WHERE id=?";


        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss",$param_nama, $param_deskripsi,  $param_jenis,  $param_stock  );

            // Set parameters
            $param_nama = $nama;
            $param_deskripsi = $deskripsi;
            $param_jenis =  $jenis;
            $param_stock = $stock;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Tambah Record</h2>
                    </div>
                    <p>Silahkan isi form di bawah ini kemudian submit untuk menambahkan data mahasiswa ke dalam database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    
                            
                            <div class="form-group <?php echo (!empty($nama_err)) ? 'has-error' : ''; ?>">
                                <label>nama</label>
                                <input type="text" name="nama" class="form-control" value="<?php echo $nama; ?>">
                                <span class="help-block"><?php echo $nama_err;?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($deskripsi_err)) ? 'has-error' : ''; ?>">
                                <label>deskripsi</label>
                                <input type="text" name="deskripsi" class="form-control" value="<?php echo $deskripsi; ?>">
                                <span class="help-block"><?php echo $deskripsi_err;?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($jenis_err)) ? 'has-error' : ''; ?>">
                                <label>jenis</label>
                                <input type="text" name="jenis" class="form-control" value="<?php echo $jenis; ?>">
                                <span class="help-block"><?php echo $jenis_err;?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($stock_err)) ? 'has-error' : ''; ?>">
                                <label>stock</label>
                                <input type="text" name="stock" class="form-control" value="<?php echo $stock; ?>">
                                <span class="help-block"><?php echo $stock_err;?></span>
                            </div>
                    
                            <div>
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <a href="index.php" class="btn btn-default">Cancel</a>                            
                            </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>