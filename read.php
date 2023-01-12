
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Data Akademik</title>
</head>
<body>
    <header>      
	          <div class="menu">
		      <ul>
		      	<li><a href="index.php?page=home">HOME</a></li>
			      <li><a href="read.php?page=data">Data Bahan Bangunan</a></li>
			      <li><a href="create.php?page=create">Create</a></li>
		      </ul>
	</div>
            </div>
        </div>
    </header>
    
<form class="form-inline" >
  <div class="form-group">
    <select class="form-control" id="Kolom" name="Kolom" required="">
      <?php
        $kolom=(isset($_GET['Kolom']))? $_GET['Kolom'] : "";
      ?>
      <option value="nama" <?php if ($kolom=="nama") echo "selected"; ?>>Nama</option>
      <option value="jenis" <?php if ($kolom=="jenis") echo "selected";?>>Jenis</option>
    </select>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" id="KataKunci" name="KataKunci" placeholder="Kata kunci.." required="" value="<?php if (isset($_GET['KataKunci']))  echo $_GET['KataKunci']; ?>">
  </div>
  <button type="submit" class="btn btn-primary">Cari</button>
  <a href="read.php" class="btn btn-danger">Reset</a>
</form> 

<table class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
      <th>No.</th>
      <th>Nama</th>
      <th>Deskripsi</th>
      <th>Jenis</th>
      <th>Stock</th>
    </tr>
  </thead>  
  <tbody>
  <div class="wrapper">
        <div class="row">
            <?php
           
                $batas = 3;
                $halaman = @$_GET['halaman'];
                if(empty($halaman)){
                    $posisi = 0;
                    $halaman = 1;
                }
                else{
                    $posisi = ($halaman-1) * $batas;
                }
                
                if(isset($_GET['search'])){
                    $search = $_GET['search'];
                    $sql="select * from barang WHERE name LIKE '%$search%' order by id Desc limit $posisi,$batas";
                }else{
                    $sql="select * from barang order by id Desc limit $posisi,$batas";
                }
                
                $hasil=mysqli_query($link,$sql);
                
                while ($data = mysqli_fetch_array($hasil)) {
                    ?>
                    <div class="col-md-3 ">
                        <a href="read_detail.php?id=<?= $data['id'] ?>">
                </br>
                            <h3>nama   :<?=$data['nama']?></h3>
                            <h3>Name  :<?=$data['deskripsi']?></h3>
                            <h3>Jenis :<?=$data['jenis']?></h3>
                            <h3>Stock  :<?=$data['stock']?></h3>
                            
                        </a>
                    </div>
                    <?php 
                }
            ?>
        </div>
        <?php
            if(isset($_GET['search'])){
                $search= $_GET['search'];
                $query2="SELECT * from barang WHERE name LIKE '%$search%' order by id Desc";
            }else{
                $query2="SELECT * from barang order by id Desc";
            }
            $result2 = mysqli_query($link,$query2);
            $jmldata = mysqli_num_rows($result2);
            $jmlhalaman = ceil($jmldata/$batas)
        ?>
        <br>
        <ul class="pagination">
            <?php
            for($i=1;$i<=$jmlhalaman;$i++){
                if ($i != $halaman){
                    if(isset($_GET['search'])){
                        $search = $_GET['search'];
                        echo "<li class='page-item'><a class='page-link' href='read.php?halaman=$i&search=$search'>$i</a></li>";
                    } else{
                        echo "<li class='page-item'><a class='page-link' href='read.php?halaman=$i'>$i</a></li>"; 
                    }
                }else {
                    echo "<li class='page-item active'><a class='page-link' href='#'>$i</a></li>";
                }
            }
            ?>
  </tbody>      
</table>


<div align="right">
  <ul class="pagination">
    <?php
      // Jika page = 1, maka LinkPrev disable
      if($page == 1){ 
    ?>        
      <!-- link Previous Page disable --> 
      <li class="disabled"><a href="#">Previous</a></li>
    <?php
      }
      else{ 
        $LinkPrev = ($page > 1)? $page - 1 : 1;  

        if($kolomCari=="" && $kolomKataKunci==""){
        ?>
          <li><a href="read.php?page=<?php echo $LinkPrev; ?>">Previous</a></li>
     <?php     
        }else{
      ?> 
        <li><a href="read.php?Kolom=<?php echo $kolomCari;?>&KataKunci=<?php echo $kolomKataKunci;?>&page=<?php echo $LinkPrev;?>">Previous</a></li>
       <?php
         } 
      }
    ?>

    <?php
      //kondisi jika parameter pencarian kosong
      if($kolomCari=="" && $kolomKataKunci==""){
        $SqlQuery = mysqli_query($link, "SELECT * FROM barang");
      }else{
        //kondisi jika parameter kolom pencarian diisi
        $SqlQuery = mysqli_query($link, "SELECT * FROM barang WHERE $kolomCari LIKE '%$kolomKataKunci%'");
      }     
  
      $JumlahData = mysqli_num_rows($SqlQuery);
      
      // Hitung jumlah halaman yang tersedia
      $jumlahPage = ceil($JumlahData / $limit); 
      
      // Jumlah link number 
      $jumlahNumber = 1; 

      // Untuk awal link number
      $startNumber = ($page > $jumlahNumber)? $page - $jumlahNumber : 1; 
      
      // Untuk akhir link number
      $endNumber = ($page < ($jumlahPage - $jumlahNumber))? $page + $jumlahNumber : $jumlahPage; 
      
      for($i = $startNumber; $i <= $endNumber; $i++){
        $linkActive = ($page == $i)? ' class="active"' : '';

        if($kolomCari=="" && $kolomKataKunci==""){
    ?>
        <li<?php echo $linkActive; ?>><a href="read.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>

    <?php
      }else{
        ?>
        <li<?php echo $linkActive; ?>><a href="read.php?Kolom=<?php echo $kolomCari;?>&KataKunci=<?php echo $kolomKataKunci;?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php
      }
    }
    ?>
    
    <!-- link Next Page -->
    <?php       
     if($page == $jumlahPage){ 
    ?>
      <li class="disabled"><a href="#">Next</a></li>
    <?php
    }
    else{
      $linkNext = ($page < $jumlahPage)? $page + 1 : $jumlahPage;
     if($kolomCari=="" && $kolomKataKunci==""){
        ?>
          <li><a href="index.php?page=<?php echo $linkNext; ?>">Next</a></li>
     <?php     
        }else{
      ?> 
         <li><a href="index.php?Kolom=<?php echo $kolomCari;?>&KataKunci=<?php echo $kolomKataKunci;?>&page=<?php echo $linkNext; ?>">Next</a></li>
    <?php
      }
    }
    ?>
  </ul>
</div>
</body>
</html>