<?php require "config.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="Style.css">
    <title>Data Akademik</title>
</head>
<body >
    <header>
        <div class="wrapper">
            <div class="row">
                <div class="col-0"></div>
                <div class="col-5">
                    <ul>
                     <center>   <font face="Sans-serif" color="black" size="4">
                        <ul><ul><center><li> <a href="index.php">Home</a></li></center>
                        <center><li> <a href="read.php">Data</a> </li></center>
                        <center><li><a href="create.php">Menambahkan</a> </li></font></center>
                    </ul>
                </div>
                </div>
            </div>
        </div>
    </header>
    <br><br><br><br>
                        <center><h3 class="pull-left">WELCOME</h3></center>
                        <center><a href="read.php" type="submit" class="btn btn-primary">Data With Pagination And Search</a></center>
                        <center><h3 class="pull-left">Data Akademik PNJ</h3></center>
    <?php
                    // Attempt select query execution
                    $sql = 'SELECT id,nim, name, tugas, uts, uas, (tugas+uts+uas)/3 AS nilai_akhir
        FROM mahasiswa';
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>No</th>";
                                        echo "<th>NIM</th>";
                                        echo "<th>Nama</th>";
                                        echo "<th>Tugas</th>";
                                        echo "<th>UTS</th>";
                                        echo "<th>UAS</th>";
                                        echo "<th>Nilai Akhir</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['nim'] . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>*********</td>";
                                    echo "<td>*********</td>";
                                    echo "<td>*********</td>";
                                    echo "<td>" . $row['nilai_akhir'] . "</td>";

                                    echo "<td>";
                                        echo "<a href='read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                        echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                        echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                    echo "</td>";
                                echo "</tr>";
                            }
                                // Page Load event
                                echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                    }

                    // Close connection
                    mysqli_close($conn);
                    ?>
            
        </div>
    </div>
</body>
<html>

