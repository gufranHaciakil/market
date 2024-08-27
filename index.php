<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <!--  -->
    <title>Market</title>
</head>

<body>
</body>
<script type="text/javascript">
    function odemetur() {
        //console.log("object")
        var odemee = document.getElementById('odeme_tur').value;
        if (odemee == 'borc') {
            document.getElementById('tarih').style.display = 'block';
        } else {
            document.getElementById('tarih').style.display = 'none';
        }
    }

    function deletee(id, value2) {
        if (confirm('emin misiniz??') == true) {
            window.location = "?value=mainPage&value2=" + value2 + "&id=" + id
        }

    }

    function handleChange1() {
        var value = document.getElementById('barkod').value;
        window.location = "?value=mainPage&value2=barkodOku&barkod=" + value;
    }


</script>

</html>


<?php

use Dompdf\Dompdf;

session_start();
$connect = mysqli_connect('localhost', 'root', '', 'market');

function yoneticiEkel()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        if (isset($_POST['addYonetici'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $password = md5(md5($_POST['password']));
            $query = "INSERT INTO yonetici (name,email,password,role) VALUES ('$name','$email','$password','$role')";
            $result = mysqli_query($connect, $query);
            if ($result) {
                echo '<script>alert("Yonetici eklendi")</script>';
                echo '<script>window.location="?value=mainPage&value2=yoneticiEkel"</script>';
            }

        }
        echo "
          <h3 style='margin-top:10px'>Yönetici Ekle</h3>
            <form style='margin-top:10px;' action='?value=mainPage&value2=yoneticiEkel' method='POST'>
             <input type='text' name='name' placeholder='Name' required>
             <input type='email' name='email' placeholder='Email' required>
              <input type='password' name='password' placeholder='Password' required>
              <select name='role' id='role' required >
              <option value='' disabled selected>select role</option>
                <option value='yonetici'>Yonetici</option>
                <option value='depo yonetici'>Depo yonetici</option>
              </select>
              <button type='submit' name='addYonetici'>Add</button>
            </form>
            <p id='errorr' style='color:red;'></p>
            ";
    }
}

function musteriEkle()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        if (isset($_POST['addMusteri'])) {
            $ad = $_POST['ad'];
            $soyad = $_POST['soyad'];
            $telefon = $_POST['telefon'];
            $query = "INSERT INTO musteri (musteri_ad,musteri_soyad,telefon) VALUES ('$ad','$soyad','$telefon')";
            $result = mysqli_query($connect, $query);
            if ($result) {
                echo '<script>alert("Musteri eklendi")</script>';
                echo '<script>window.location="?value=mainPage&value2=musteriEkle"</script>';
            }
        } else {
            echo "
            <h3 style='margin:10px 0 15px 0'>Müşteri Ekle</h3>
            <form style='margin-top:10px;' action='?value=mainPage&value2=musteriEkle' method='POST'>
             <input type='text' name='ad' placeholder='Ad' required>
             <input type='text' name='soyad' placeholder='Soyad' required>
              <input type='text' name='telefon' placeholder='Telefon' required>
              <button type='submit' name='addMusteri'>Add</button>
            </form
            ";
        }
    }
}

function musteriler()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        $query = "SELECT * FROM musteri";
        $result = mysqli_query($connect, $query);
        echo "
           <div style='display:flex;gap:48rem;align-items:center;margin:-25px 0 -15px 25px'>
             <h3 style=''>Müşteriler</h3>
             <a href='?value=mainPage&value2=musteriEkle'>Müşteri ekle</a>
          </div>
        <div class='products' style='display:flex'>
            <table>
                <tr>
                    <th>Ad</th>
                    <th>Soyad</th>
                    <th>Telefon</th>
                    <th>Action</th>
                </tr>";
        while ($data = mysqli_fetch_assoc($result)) {
            echo "
            <tr>
                <td>" . $data['musteri_ad'] . "</td>
                <td>" . $data['musteri_soyad'] . "</td>
                <td>" . $data['telefon'] . "</td>
                <td onclick='deletee(" . $data['musteri_id'] . ",`deletemusteri`)'>&#9940;</td>
            </tr>
        ";
        }
        echo "
        </table>
        </div>
        ";
    }
}
function yoneticiler()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        $query = "SELECT * FROM yonetici";
        $result = mysqli_query($connect, $query);
        echo "
           <div style='display:flex;gap:48rem;align-items:center;margin:-25px 0 -15px 25px'>
             <h3 style=''>Yöneticiler</h3>
             <a href='?value=mainPage&value2=yoneticiEkel'>Yönetici ekle</a>
          </div>
        <div class='products' style='display:flex'>
            <table>
                <tr>
                    <th>Ad</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>";
        while ($data = mysqli_fetch_assoc($result)) {
            echo "
            <tr>
                <td>" . $data['name'] . "</td>
                <td>" . $data['email'] . "</td>
                <td>" . $data['role'] . "</td>
                <td onclick='deletee(" . $data['id'] . ",`deleteyonetici`)'>&#9940;</td>
            </tr>
        ";
        }
        echo "
        </table>
        </div>
        ";
    }
}
function deleteyonetici()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        $id = $_GET['id'];
        $query = "DELETE FROM yonetici WHERE id = $id";
        $result = mysqli_query($connect, $query);
        if ($result) {
            echo '<script>window.location="?value=mainPage&value2=yoneticiler"</script>';
        } else {
            echo '<script>alert("Yonetici silinemedi")</script>';
            echo '<script>window.location="?value=mainPage&value2=yoneticiler"</script>';
        }
    }
}

function deletemusteri()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        $id = $_GET['id'];
        $query = "DELETE FROM musteri WHERE musteri_id = $id";
        $result = mysqli_query($connect, $query);
        if ($result) {
            echo '<script>window.location="?value=mainPage&value2=musteriler"</script>';
        } else {
            echo '<script>alert("Musteri silinemedi")</script>';
            echo '<script>window.location="?value=mainPage&value2=musteriler"</script>';
        }
    }
}

function login()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        echo '<script>window.location="?value=mainPage"</script>';
    } else {
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = md5(md5($_POST['password']));
            $query = "SELECT * FROM yonetici WHERE email = '$email' AND password = '$password'";
            $result = mysqli_query($connect, $query);
            $data = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) > 0) {
                $_SESSION['name'] = strtoupper($data['name']);
                $_SESSION['email'] = $email;
                $_SESSION['id'] = $data['id'];
                $_SESSION['role'] = $data['role'];
                echo '<script>window.location="?value=mainPage"</script>';
            } else {
                echo '<script>alert("Invalid email or password")</script>';
                echo '<script>window.location="?value=login"</script>';
            }
        } else {
            echo '
             <div class="container">
            <div class="">
                <h1>Market</h1>
            </div>
            <div class="content">
                <form action="?value=login" method="POST">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="login">Login</button>
                </form>
            </div>
        </div>
            ';
        }
    }
}
function products()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        $query = "SELECT * FROM product";
        $result = mysqli_query($connect, $query);
        echo '
              <div style="display:flex;gap:50rem;width:90%;margin: 0 auto">
                 <h3 style="margin:0 0 0 0">Ürünler</h3>
                  <a href="?value=mainPage&value2=addproduct">Ürün ekle</a>
              </div>       
          <div class="products" style="display:flex">             
        <table>
                <tr>
                    <th>Barkod</th>
                    <th>Isim</th>
                    <th>Fiyat</th>
                    <th>Adet</th>
                    <th>Action</th>
                </tr>';

        while ($data = mysqli_fetch_assoc($result)) {
            echo '
            <tr>
                <td>' . $data['barkod'] . '</td>
                <td>' . $data['name'] . '</td>
                <td>' . $data['price'] . '</td>
              ';
            if ($data['adet'] <= 0) {
                echo '<td style="color:red;">Stokta Yok</td>';
            } else {
                echo '<td>' . $data["adet"] . '</td>';
            }
            echo '
                <td><a href="?value=mainPage&value2=editProduct&id=' . $data['id'] . '">&#x270E;</a></td>
            </tr>
        ';
        }
        echo '
        </table>

    </div>
    ';
    }
}

function addproduct()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        if (isset($_POST['addProduct'])) {
            $barkod = rand();
            $name = $_POST['name'];
            $price = $_POST['price'];
            $adet = $_POST['adet'];
            $query = "INSERT INTO product (barkod, name, price,adet) VALUES ($barkod, '$name', $price, $adet)";
            $result = mysqli_query($connect, $query);
            if ($result) {
                echo '<script>alert("Product added successfully")</script>';
                echo '<script>window.location="?value=mainPage&value2=products"</script>';
            }
        } else {
            echo '
                <h3 style="margin-top:10px">Ürün Ekle</h3>
            <form style="margin-top:10px;" action="?value=mainPage&value2=addproduct" method="POST">
              <input type="text" name="name" placeholder="Product Name" required>
              <input type="text" name="price" placeholder="Product Price" required>
              <input type="text" name="adet" placeholder="Adet" required>
              <button type="submit" name="addProduct">Add</button>
            </form>';
        }
    }
}

function editProduct()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        if (isset($_POST['editProduct'])) {
            $id = $_GET['id'];
            $barkod = $_POST['barkod'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $adet = $_POST['adet'];
            $query = "UPDATE product SET barkod = '$barkod', name = '$name', price = '$price', adet = '$adet' WHERE id = $id";
            $result = mysqli_query($connect, $query);
            if ($result) {
                echo '<script>alert("Product updated successfully")</script>';
                echo '<script>window.location="?value=mainPage&value2=products"</script>';
            } else {
                echo '<script>alert("Product not updated")</script>';
                echo '<script>window.location="?value=mainPage&value2=editProduct&id=' . $id . '"</script>';
            }
        } else {
            $id = $_GET['id'];
            $query = "SELECT * FROM product WHERE id = $id";
            $result = mysqli_query($connect, $query);
            $data = mysqli_fetch_assoc($result);
            echo '
                <h3 style="margin-top:10px">Ürün Göncelle</h3>
              <form style="" action="?value=mainPage&value2=editProduct&id=' . $id . '" method="POST">
                <input type="text" name="barkod" value="' . $data['barkod'] . '" required>
                <input type="text" name="name" value="' . $data['name'] . '" required>
                <input type="text" name="price" value="' . $data['price'] . '" required>
                <input type="text" name="adet" value="' . $data['adet'] . '" required>
                <button type="submit" name="editProduct">Edit</button>
                <a style="   padding: 9px 10px;
                 border-radius: 5px;
                 border: none;
                 font-size: 16px;
                 text-decoration: none;
                    background-color: #ff000082;
                    color: white;
                 cursor: pointer;" href="?value=mainPage&value2=delete&id=' . $id . '">Delete</a>
              </form>
            ';
        }
    } else {
        header('location: ?value=login');
    }
}

function delete()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        $id = $_GET['id'];
        $query = "DELETE FROM product WHERE id = $id";
        $result = mysqli_query($connect, $query);
        if ($result) {
            echo '<script>alert("Product deleted successfully")</script>';
            echo '<script>window.location="?value=mainPage&value2=products"</script>';
        } else {
            echo '<script>alert("Product not deleted")</script>';
            echo '<script>window.location="?value=mainPage&value2=editProduct&id=' . $id . '"</script>';
        }
    } else {
        header('location: ?value=login');
    }
}

function borclar()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        $query = "SELECT satislar.* , musteri.musteri_ad , musteri.musteri_soyad FROM `satislar`,musteri WHERE odeme_tur = 'borc'
         and musteri.musteri_id=satislar.musteri_id;";
        $query2 = "SELECT sum(fiyat) as borcum FROM satislar WHERE odeme_tur = 'borc'";
        $result = mysqli_query($connect, $query);
        $result2 = mysqli_query($connect, $query2);
        $borc = mysqli_fetch_assoc($result2);
        echo "
              <div style='display:flex;gap:48rem;align-items:center;'>
            <p style='color:green;margin:2px 0px 10px 20px;font-weight:bold;'>Toplam Borc: " . round($borc['borcum'], 3) . "</p>
             <a href='?value=mainPage&value2=borcAra'> Borc ara</a>
             </div>
         <div class='products' style=''>
           <table>
                <thead>
                    <tr>
                        <th>Muşteri</th>
                        <th>Ürün Barkodu</th>
                        <th>Adet</th>
                        <th>Fiyat</th>
                        <th>Tarih</th>
                        <th>Yöneten</th>
                        <th>Ödeme Tür</th>
                        <th>Ödeme Tarih</th>
                        <th>Action</th>
                    </tr>
                </thead>";

        while ($data = mysqli_fetch_assoc($result)) {
            echo "
            <tr>
               <td>" . $data["musteri_ad"] . " " . $data["musteri_soyad"] . "</td>
                <td>" . $data["barkod_no"] . "</td>
                <td>" . $data["adet"] . "</td>
                <td>" . $data["fiyat"] . "</td>
                <td>" . $data["tarih"] . "</td>
                <td>" . $data["yoneten"] . "</td>
                <td>" . $data["odeme_tur"] . "</td>
                <td>" . $data["odenecek_tarih"] . "</td>
                <td onclick='deletee(" . $data['id'] . ",`deleteborc`)'>&#9940;</td>
            </tr>";
        }
        echo "
        <tr>
          <td style='color:#80808061;' colspan='9'> - 2024 -</td>
        </tr>
        </table>
    </div>
    ";
    }
}

function borcAra()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        if (isset($_POST['borcara'])) {
            $musteri_ad = strtolower($_POST['musteri_ad']);
            $musteri_soyad = strTolower($_POST['musteri_soyad']);
            $query = "SELECT musteri.musteri_ad,musteri.musteri_soyad,satislar.*
             FROM musteri,satislar where musteri.musteri_id = satislar.musteri_id and 
             musteri.musteri_ad = '$musteri_ad' and musteri.musteri_soyad = '$musteri_soyad' and odeme_tur = 'borc'";
            $query2 = "SELECT * FROM musteri WHERE musteri_ad = '$musteri_ad' AND musteri_soyad = '$musteri_soyad'";
            $query3 = "SELECT sum(fiyat) as toplam FROM musteri,satislar where 
            musteri.musteri_id = satislar.musteri_id and musteri.musteri_ad = '$musteri_ad'
             and musteri.musteri_soyad = '$musteri_soyad' and odeme_tur = 'borc'";
            $result = mysqli_query($connect, $query);
            $result2 = mysqli_query($connect, $query2);
            $result3 = mysqli_query($connect, $query3);
            $data2 = mysqli_fetch_assoc($result2);
            $data3 = mysqli_fetch_assoc($result3);
            $rows = mysqli_num_rows($result);
            if ($rows > 0) {
                echo "
                  <p style='color:green;margin:2px 0px 10px 20px;font-weight:bold;text-transform:uppercase'>" . $data2['musteri_ad'] . " " . $data2['musteri_soyad'] . " <span style='color:black;text-transform:none;'>adlı kişinin borçları</span></p>
                  <div class='products' style='display:flex'>
                  <table>
                  <tr>
                <th>Musteri Ad</th>
                <th>Urun Barkodu</th>
                <th>Adet</th>
                <th>Borc</th>
                <th>Tarih</th>
                </tr>";
                while ($data = mysqli_fetch_assoc($result)) {
                    echo "
                        <tr>
                            <td>" . $data['musteri_ad'] . " " . $data['musteri_soyad'] . "</td>
                            <td>" . $data['barkod_no'] . "</td>
                            <td>" . $data['adet'] . "</td>
                            <td>" . $data['fiyat'] . "</td>
                            <td>" . $data['tarih'] . "</td>
                        </tr> ";
                }
                echo "
                <tr><td colspan='5'>toplam borc: <b>" . $data3["toplam"] . "</b></td></tr>
                </table>
                </div>";
            } else {
                echo "<script>alert('Borc bulunamadi')</script>";
                echo "<script>window.location='?value=mainPage&value2=borclar'</script>";
            }
        } else {
            echo "
            <h3 style='margin-top:10px'>Borç Ara</h3>
            <form style='margin-top:10px;' action='?value=mainPage&value2=borcAra' method='POST'>
             <input type='text' name='musteri_ad' placeholder='Musteri ad' required>
             <input type='text' name='musteri_soyad' placeholder='Musteri soyad' required>
             <button type='submit' name='borcara'>Ara</button>
            </form>";
        }
    }
}

function getbarkod()
{
    if (isset($_SESSION['name'])) {
        global $connect;
        $barkod = $_GET['barkod'];
        $query = "SELECT * FROM product WHERE barkod = '$barkod'";
        $result = mysqli_query($connect, $query);
        $row = mysqli_num_rows($result);
        if ($row <= 0) {
            echo '<script>alert("Stokta urun yok")</script>';
            echo '<script>window.location="?value=mainPage&value2=products"</script>';
        } else {
            while ($data = mysqli_fetch_assoc($result)) {
                echo '
                <div class="products" style="display:flex">
                    <table>
                            <tr>
                                <th>Barkod</th>
                                <th>Isim</th>
                                <th>Fiyat</th>
                                <th>Adet</th>
                            </tr>
                            <tr>
                                <td>' . $data['barkod'] . '</td>
                                <td>' . $data['name'] . '</td>
                                <td>' . $data['price'] . '</td>';
                if ($data['adet'] <= 0) {
                    echo '<td style="color:red;">Stokta Yok</td>';
                } else {
                    echo '<td>' . $data["adet"] . '</td>';
                }
                echo '
                            </tr>
                    </table>
                </div>
                ';
            }
        }
    }
}

function getmusteriBorc()
{
    if (isset($_SESSION['name'])) {
        global $connect;
        $ad = $_GET['ad'];
        $soyad = $_GET['soyad'];
        $query = "SELECT * FROM borclar WHERE musteri_ad = '$ad' AND musteri_soyad = '$soyad'";
        $result = mysqli_query($connect, $query);
        $row = mysqli_num_rows($result);
        if ($row <= 0) {
            echo '<script>alert("Musteri borcu yok")</script>';
            echo '<script>window.location="?value=mainPage&value2=borclar"</script>';
        } else {
            echo '
            <div class="products" style="display:flex">
                <table>
                        <tr>
                            <th>Musteri Ad</th>
                            <th>Urun Barkodu</th>
                            <th>Borc</th>
                            <th>Tarih</th>
                        </tr>';
            while ($data = mysqli_fetch_assoc($result)) {
                echo '
                <tr>
                    <td>' . $data['musteri_ad'] . ' ' . $data['musteri_soyad'] . '</td>
                    <td>' . $data['urun_barkodu'] . '</td>
                    <td>' . $data['borc'] . '</td>
                    <td>' . $data['tarih'] . '</td>
                </tr>
            ';
            }
            echo '
            <tr ><td colspan="5">toplam borc</td></tr>
            </table>
            </div>
            ';
        }
    }
}

function deleteBorc()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        $id = $_GET['id'];
        $query = "DELETE FROM satislar WHERE id = $id";
        $result = mysqli_query($connect, $query);
        if ($result) {

            echo '<script>window.location="?value=mainPage&value2=borclar"</script>';
        } else {
            echo '<script>alert("Borc not deleted")</script>';
            echo '<script>window.location="?value=mainPage&value2=borclar"</script>';
        }
    } else {
        header('location: ?value=login');
    }
}

function satisyap()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        if (isset($_POST['satisYap'])) {
            $sql = "SELECT price,adet FROM product where 
            barkod = " . $_POST['urun_barkodu'];
            $result = mysqli_query($connect, $sql);
            $data = mysqli_fetch_assoc($result);
            $fiyat = $data['price'];
            $musteri_id = $_POST['musteri'];
            $barkod_no = $_POST['urun_barkodu'];
            $odeme = $_POST['odeme'];
            $adet = $_POST['adet'];
            if ($_POST['odeme_tarih'] != '') {
                $odeme_tarih = $_POST['odeme_tarih'];
            } else {
                $odeme_tarih = " - ";
            }
            $tarih = date('Y-m-d');
            $borc = $fiyat * $adet;
            $query = "INSERT INTO satislar (musteri_id,barkod_no,adet, fiyat,tarih,yoneten,odeme_tur,odenecek_tarih) 
            VALUES ($musteri_id, '$barkod_no', $adet,$borc, '$tarih', '"
             . $_SESSION['name'] . "', '$odeme', '$odeme_tarih')";
            if ($data['adet'] <= 0) {
                echo "<script>alert('Stokta urun yok')</script>";
                echo "<script>window.location='?value=mainPage&value2=satisyap'</script>";
            } else {
                $result = mysqli_query($connect, $query);
            }
            if ($result) {
                $query2 = "SELECT adet FROM product WHERE barkod = $barkod_no";
                $result2 = mysqli_query($connect, $query2);
                $data = mysqli_fetch_assoc($result2);
                $stoktaAdet = $data['adet'] - $adet;
                $query3 = "UPDATE product SET adet = $stoktaAdet WHERE barkod = $barkod_no";
                mysqli_query($connect, $query3);
                echo "<script>alert('Satis yapildi')</script>";
                echo "<script>window.location='?value=mainPage&value2=satisyap'</script>";
            }
        } else {
            $sql = "SELECT * FROM musteri";
            $result = mysqli_query($connect, $sql);
            echo "  
            <h3 style='margin-top:10px'>Satiş Yap</h3>  
            <form style='margin-top:10px;display:flex;flex-direction:column;width:30%;gap:1rem' action='?value=mainPage&value2=satisyap' method='POST'>
                 <select name='musteri'>
                      <option>Müşteri Seç</option>";
            while ($data = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $data['musteri_id'] . "'>" . $data['musteri_ad'] . " " . $data['musteri_soyad'] . "</option>";
            }
            echo "
                  </select>
                 <input type='number' name='urun_barkodu' placeholder='Urun Barkodu' required>
                 <input type='number' name='adet' placeholder='Adet' required>
                 <select name='odeme' id='odeme_tur' onchange='odemetur()'>
                     <option>Ödeme Türü Seç</option>
                     <option value='kart'>Kredi kart</option>
                     <option value='nakit'>Nakit</option>
                     <option value='borc'>Borç</option>
                </select>
                <input style='display:none;' id='tarih' name='odeme_tarih' type='date'/>
               <button class='satBtn' style='background-color:#c0ffc0;' type='submit' name='satisYap'>Sat</button>
         </form>
           ";
        }
    }
}

function satislar()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        $query = "SELECT musteri.musteri_ad,musteri.musteri_soyad ,satislar.* FROM musteri,satislar where musteri.musteri_id = satislar.musteri_id";
        $query2 = "SELECT sum(fiyat) as toplamSatis FROM satislar WHERE odeme_tur = 'nakit' or odeme_tur = 'kart'";
        $query3 = "SELECT sum(fiyat) as toplamBorc FROM satislar WHERE odeme_tur = 'borc'";
        $query4 = "SELECT sum(fiyat) as toplam FROM satislar";
        $result = mysqli_query($connect, $query);
        $result2 = mysqli_query($connect, $query2);
        $result3 = mysqli_query($connect, $query3);
        $result4 = mysqli_query($connect, $query4);
        $nakit = mysqli_fetch_assoc($result2);
        $borc = mysqli_fetch_assoc($result3);
        $toplam = mysqli_fetch_assoc($result4);
        echo "
         <div style='display: flex; gap: 5px'>
             <p style='color: green; margin: 2px 0px 10px 20px; font-weight: bold'>
                  Tahsil Edilen Miktar: " . round($nakit['toplamSatis'], 3) . "
             </p>
             <p style='color: red; margin: 2px 0px 10px 20px; font-weight: bold'>
                 Borç Miktarı: " . round($borc['toplamBorc'], 3) . "
             </p>
         <p style='color: black; margin: 2px 0px 10px 20px; font-weight: bold'>
           Toplam Satis: " . round($toplam['toplam'], 3) . "
         </p>
        </div>
        <div class='products' style='display: flex'>
         <table>
            <tr>
              <th>Muşteri</th>
              <th>Ürün Barkodu</th>
              <th>Adet</th>
              <th>Fiyat</th>
              <th>Tarih</th>
              <th>Yöneten</th>
              <th>Ödeme Tür</th>
            </tr>
        ";
        while ($data = mysqli_fetch_assoc($result)) {
            echo "
            <tr>
                <td>" . $data['musteri_ad'] . " " . $data['musteri_soyad'] . "</td>
                <td>" . $data['barkod_no'] . "</td>
                <td>" . $data['adet'] . "</td>
                <td>" . $data['fiyat'] . "</td>
                <td>" . $data['tarih'] . "</td>
                <td>" . $data['yoneten'] . "</td>
                <td>" . $data['odeme_tur'] . "</td>
            </tr> ";
        }
        echo "
        </table>
         </div>
    ";
    }
}

function satisAra()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        if (isset($_POST['ara'])) {
            $tarih1 = $_POST['tarih1'];
            $tarih2 = $_POST['tarih2'];
            $ad = $_POST['ad'];
            $soyad = $_POST['soyad'];
            $query = "SELECT musteri.musteri_ad,musteri.musteri_soyad,satislar.* 
            FROM musteri,satislar where musteri.musteri_id = satislar.musteri_id 
            and musteri.musteri_ad = '$ad' and musteri.musteri_soyad
             = '$soyad' and tarih BETWEEN '$tarih1' AND '$tarih2'";
            $query2 = "SELECT musteri_ad , musteri_soyad FROM
            musteri WHERE musteri_ad = '$ad' and musteri_soyad = '$soyad'";
            $result = mysqli_query($connect, $query);
            $result2 = mysqli_query($connect, $query2);
            $data2 = mysqli_fetch_assoc($result2);
            $row = mysqli_num_rows($result);
            if ($row <= 0) {
                echo "<script>alert('Satis bulunamadi')</script>";
                echo "<script>window.location='?value=mainPage&value2=satisAra'</script>";
            } else {
                echo "
                 <p style='color:green;margin:2px 0px 10px 20px;font-weight:bold;'>" . $tarih1 . " || " . $tarih2 . " - <span style='color:black;'>Tarihler arasinda <b style='text-transform: uppercase;'>" . $data2["musteri_ad"] . " " . $data2["musteri_soyad"] . "</b> adlı kişinin aldıkları Ürünler</span></p>
                <div class='products' style='display:flex'>
                    <table>
                            <tr>
                                <th>Muşteri</th>
                                <th>Ürün Barkodu</th>
                                <th>Adet</th>
                                <th>Fiyat</th>
                                <th>Tarih</th>
                                <th>Yöneten</th>
                                <th>Ödeme Tür</th>
                            </tr>";
                while ($data = mysqli_fetch_assoc($result)) {
                    echo "
                    <tr>
                        <td>" . $data["musteri_ad"] . " " . $data["musteri_soyad"] . "</td>
                        <td>" . $data["barkod_no"] . "</td>
                        <td>" . $data["adet"] . "</td>
                        <td>" . $data["fiyat"] . "</td>
                        <td>" . $data["tarih"] . "</td>
                        <td>" . $data["yoneten"] . "</td>
                        <td>" . $data["odeme_tur"] . "</td>
                    </tr>
                ";
                }
                echo "
                </table>
            </div>
            ";
            }
        } else {
            echo "
                <h3 style='margin-top:10px'>Satış ara</h3>
            <form style='margin-top:10px;display:flex;flex-direction:column;width:30%;gap:10px' action='?value=mainPage&value2=satisAra' method='POST'>
            <input type='text' name='ad' placeholder='Musteri ad' required> 
            <input type='text' name='soyad' placeholder='Musteri soyad' required>
              <input type='date' name='tarih1' placeholder='Tarih' required>
              <input type='date' name='tarih2' placeholder='Tarih' required>
              <button type='submit' name='ara'>Ara</button>
            </form>";
        }
    }
}

function create_pdf()
{
    require_once('./dompdf/autoload.inc.php');

    $dompdf = new Dompdf();
    $html = "<h1 style='text-align:center;color:blue'>Market</h1>";
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    // $dompdf->stream();
    $pdf = $dompdf->output();
    file_put_contents('market.pdf', $pdf);
}

function istek()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        if (isset($_POST['istek'])) {
            $id = $_GET['id'];
            $query = "SELECT * FROM product WHERE id =$id";
            $result = mysqli_query($connect, $query);
            $data = mysqli_fetch_assoc($result);
            $barkod = $data['barkod'];
            $name = $data['name'];
            $price = $data['price'];
            $Padet = $data['adet'];
            $adet = $_POST['adet'];
            $query = "INSERT INTO azalanlar (barkod, isim,stokta_adet,istenen_adet)
             VALUES ('$barkod', '$name','$Padet', '$adet')";
            $query2 = "SELECT * FROM azalanlar WHERE barkod = $barkod";
            $result2 = mysqli_query($connect, $query2);
            $row = mysqli_num_rows($result2);
            if ($row > 0) {
                echo "<script>alert('Bu urun icin daha once istek gonderildi')</script>";
                echo "<script>window.location='?value=mainPage&value2=anasayfa'</script>";
            } else {
                $result = mysqli_query($connect, $query);
            }
            if ($result) {
                echo '<script>alert("Istek Gonderildi")</script>';
                echo '<script>window.location="?value=mainPage&value2=anasayfa"</script>';
            }
        } else {
            $id = $_GET['id'];
            $query = "SELECT * FROM product WHERE id = $id";
            $result = mysqli_query($connect, $query);
            $data = mysqli_fetch_assoc($result);

            echo "
            <h4 style='margin:0 0 10px 25px'>Stoktan ürün talep et</h4>
            <table>
                <tr>
                    <th>Barkod</th>
                    <th>Isim</th>
                    <th>Fiyat</th>
                    <th>Stokta Adet</th>
                </tr>
                <tr>
                    <td>" . $data['barkod'] . "</td>
                    <td>" . $data['name'] . "</td>
                    <td>" . $data['price'] . "</td>
                    <td>" . $data['adet'] . "</td>
                </tr>
            </table>
            <form style='width:50%;margin: 2rem auto;' action='?value=mainPage&value2=istek&id=" . $id . "' method='POST'>
            <label for='adet'>Istenen miktar: </label>
                <input style='width:13%' type='number' name='adet' placeholder='Or:125' required>
                <button type='submit' name='istek'>Iste</button>
            </form>
            ";
        }
    }
}

function talepler()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        $query = "SELECT * FROM azalanlar";
        $result = mysqli_query($connect, $query);
        $rows = mysqli_num_rows($result);
        echo "
                <h3 style='margin-top:10px'>Talepler</h3>
        <div class='products' style='display:flex'>
            <table>
                <tr>
                    <th>Barkod</th>
                    <th>Isim</th>
                    <th>Stokta adet</th>
                    <th>Talp edilen adet</th>
                    <th>Gonderilen adet</th>
                    <th>Talep durumu</th>
                    <th>Action</th>
                </tr>";
        if ($rows <= 0) {
            echo "<tr><td colspan='7'>Talep bulunamadi</td></tr>";
        } else {
            while ($data = mysqli_fetch_assoc($result)) {
                echo "
            <tr>
                <td>" . $data['barkod'] . "</td>
                <td>" . $data['isim'] . "</td>
                <td>" . $data['stokta_adet'] . "</td>
                <td>" . $data['istenen_adet'] . "</td>";
                if ($data['gonderilen_adet'] == 0) {
                    echo "<td> - </td>";
                } else {
                    echo "<td style='color:blue;font-weight:bold'>" . $data['gonderilen_adet'] . "</td>";
                }
                echo "
                <td>" . $data['istek_durum'] . "</td>";
                if ($data['istek_durum'] == 'Gonderildi') {
                    echo "<td><a href='?value=mainPage&value2=talepOnayla&id=" . $data['id'] . "' >onayla</a></td>";
                } else if ($data['istek_durum'] == 'istek gonderildi') {
                    echo "<td> - </td>";
                } else {
                    echo "<td> &#9940; </td>";
                }
                echo "
            </tr>
        ";
            }
        }
        echo "
        </table>
        </div>
        ";
    }
}

function talepOnayla()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM azalanlar WHERE id = $id";
        $result = mysqli_query($connect, $query);
        $data = mysqli_fetch_assoc($result);
        $stoktaAdet = $data['stokta_adet'] + $data['gonderilen_adet'];
        $query2 = "UPDATE azalanlar SET istek_durum = 'onaylandi' WHERE id = $id";
        mysqli_query($connect, $query2);
        $query3 = "update product set adet = $stoktaAdet where barkod = " . $data['barkod'];
        mysqli_query($connect, $query3);
        $rows = mysqli_affected_rows($connect);
        $query3 = "DELETE FROM azalanlar WHERE id = $id";
        mysqli_query($connect, $query3);

        if ($rows) {
            echo "<script>alert('Talep onaylandi')</script>";
            echo "<script>window.location='?value=mainPage&value2=talepler'</script>";
        } else {
            echo "<script>alert('errorr')</script>";
            echo "<script>window.location='?value=mainPage&value2=talepler'</script>";
        }
    }
}

function isteklerim()
{
    global $connect;
    if (isset($_SESSION['name'])) {
        if (isset($_POST['onayla'])) {
            $miktar = $_POST['miktar'];
            $id = $_GET['id'];
            if ($miktar > 0) {
                $query = "UPDATE azalanlar SET istek_durum = 'Gonderildi' ,gonderilen_adet='" . $miktar . "' where id = $id";
                $result = mysqli_query($connect, $query);
                if ($result) {
                    echo "<script>alert('miktar gonderildi')</script>";
                    echo "<script>window.location='?value=mainPage&value2=isteklerim'</script>";
                }
            } else {
                echo "<script>alert('miktar belirleyin!!')</script>";
                echo "<script>window.location='?value=mainPage&value2=isteklerim'</script>";
            }
        } else {
            $query = "SELECT * FROM azalanlar WHERE istek_durum = 'istek gonderildi'";
            $result = mysqli_query($connect, $query);
            echo "
        <div class='products' style='display:flex'>
            <table>
                <tr>
                    <th>Barkod</th>
                    <th>Isim</th>
                    <th>Stokta adet</th>
                    <th>Istenen miktar</th>
                    <th>Action</th>
                </tr>";
            while ($data = mysqli_fetch_assoc($result)) {
                echo "
            <tr>
                <td>" . $data['barkod'] . "</td>
                <td>" . $data['isim'] . "</td>
                <td>" . $data['stokta_adet'] . "</td>
                <td>" . $data['istenen_adet'] . "</td>
                <td>
              <form action='?value=mainPage&value2=isteklerim&id=" . $data['id'] . "' method='POST'>
                  <input type='number' name='miktar' style='margin-right:6px;padding: 8px 6px;width: 70px;font-size: 18px;' placeholder='Miktar:'/>
                  <button type='submit' name='onayla'>Gonder</button>
              </form>
                </td>
            </tr>
        ";
            }
            echo "
        </table>
        </div>
        ";
        }
    }
}
function anasayfa()
{
    $guneKala = 6;
    $tarihmktime = mktime('00', '00', '00', date('m'), date('d'), date('Y'));
    $birsonrakigun1 = $tarihmktime + ((24 * 60 * 60) * +1);
    $birsonrakigun2 = $tarihmktime + ((24 * 60 * 60) * +$guneKala);
    $tarih1 = date('Y-m-d', $birsonrakigun1);
    $tarih2 = date('Y-m-d', $birsonrakigun2);
    global $connect;
    $query = "SELECT satislar.* , musteri.musteri_ad , musteri.musteri_soyad
     FROM `satislar`,musteri WHERE odeme_tur = 'borc'
         and musteri.musteri_id=satislar.musteri_id and
          satislar.odenecek_tarih BETWEEN '$tarih1' AND '$tarih2'";
    $result = mysqli_query($connect, $query);
    $query2 = "SELECT sum(fiyat) as borcum FROM satislar WHERE odeme_tur = 'borc'";
    $result2 = mysqli_query($connect, $query2);
    $borc = mysqli_fetch_assoc($result2);
    echo "
        <div style='display:flex;gap:48rem;align-items:center;'>
             <p style='color:green;margin:2px 0px 10px 20px;font-weight:bold;'>Ödemeye Yaklaşan Borçlar :</p>
              <a href='?value=mainPage&value2=borcAra'> Borc ara</a>
         </div>
             <div class='products' style=''>
             <table>
                    <thead>
                        <tr>
                            <th>Muşteri</th>
                            <th>Ürün Barkodu</th>
                            <th>Adet</th>
                            <th>Fiyat</th>
                            <th>Tarih</th>
                            <th>Yöneten</th>
                            <th>Ödeme Tür</th>
                            <th>Ödeme Tarihi</th>
                            <th>Action</th>
                        </tr>
                    </thead>";
    while ($data = mysqli_fetch_assoc($result)) {
        echo "
            <tr>
               <td>" . $data["musteri_ad"] . " " . $data["musteri_soyad"] . "</td>
                <td>" . $data["barkod_no"] . "</td>
                <td>" . $data["adet"] . "</td>
                <td>" . $data["fiyat"] . "</td>
                <td>" . $data["tarih"] . "</td>
                <td>" . $data["yoneten"] . "</td>
                <td>" . $data["odeme_tur"] . "</td>
                <td>" . $data["odenecek_tarih"] . "</td>
                <td onclick='deletee(" . $data['id'] . ",`deleteborc`)'>&#9940;</td>
            </tr>";
    }
    echo "
    <tr>
      <td style='color:#80808061;' colspan='9'> - 2024 -</td>
    </tr>
    </table>
</div>

<p style='color:#ff5353;margin:20px 0px 10px 20px;font-weight:bold;'>Stok Azalanlar : </p>
<div class='products' style='margin-bottom:50px;'>
<table>
        <thead>
            <tr>
                <th>Barkod</th>
                <th>Isim</th>
                <th>Fiyat</th>
                <th>Adet</th>
                <th>Action</th>
            </tr>";
    $query3 = "SELECT * FROM product WHERE adet <= 10";
    $result3 = mysqli_query($connect, $query3);
    $x = 0;
    while ($data = mysqli_fetch_assoc($result3)) {
        $x += 1;
        echo "
        <tr>
            <td>" . $data['barkod'] . "</td>
            <td>" . $data['name'] . "</td>
            <td>" . $data['price'] . "</td>
          ";
        if ($data['adet'] <= 0) {
            echo '<td style="color:red;">Stokta Yok</td>';
        } else {
            echo '<td>' . $data["adet"] . '</td>';
        }
        echo "
        <td><a href='?value=mainPage&value2=istek&id=" . $data['id'] . "' style='background-color: #80808047;
                 color: #000000b3;
                 padding: 0px 15px;
                 font-size: 19px;
                border: 2px solid #80808047;
                }'>Talep et</a>
        </td>
    ";
    }
    echo "
            </tr>
    </table>
    </div>
    ";
}


function mainPage()
{
    global $value2;
    if (isset($_SESSION['name'])) {
        global $connect;
        echo '
          <div class="header">
              <div class="item1">
                <h1 style="margin-right:15px">Market</h1>
                 ';
        if ($_SESSION['role'] == 'yonetici') {
            echo "<input type='number' id='barkod' onchange='handleChange1()' placeholder='Barkod oku..'>
                    ";
        }
        echo '
              </div>
             <div class="item2">
                 <h2>Welcome ' . $_SESSION['name'] . '</h2>
                 <a href="?value=logout">Logout</a>
             </div>
          </div>
            <div>
              <div class="dashboard">
                  <div class="item1">';
        $query = "SELECT * FROM yonetici WHERE id = '" . $_SESSION['id'] . "'";
        $result = mysqli_query($connect, $query);
        $data = mysqli_fetch_assoc($result);
        $query2 = "SELECT count(*) as istekler from azalanlar where istek_durum = 'istek gonderildi'";
        $result2 = mysqli_query($connect, $query2);
        $data2 = mysqli_fetch_assoc($result2);
        $query3 = "SELECT count(*) as istekler from azalanlar where istek_durum = 'Gonderildi'";
        $result3 = mysqli_query($connect, $query3);
        $data3 = mysqli_fetch_assoc($result3);

        if ($data['role'] == 'yonetici') {
            echo '
               <a href="?value=mainPage&value2=anasayfa">Ana Sayfa </a> 
                  <a href="?value=mainPage&value2=products">Ürunler</a> 
                  <a href="?value=mainPage&value2=borclar">Borc Defteri</a>
                  <a href="?value=mainPage&value2=satisyap">Satiş Yap </a>
                  <a href="?value=mainPage&value2=satislar">Satişlar </a>
                  <a href="?value=mainPage&value2=satisAra">Satiş Ara </a>
                  <a href="?value=mainPage&value2=talepler">Talepler-(' . $data3['istekler'] . ') </a>
                  <a href="?value=mainPage&value2=musteriler">Müşteriler </a>
                  <a href="?value=mainPage&value2=yoneticiler">Yöneticiler </a>
                  <a href="?value=mainPage&value2=yoneticiEkel">Yönetici ekle </a>
            ';
        } else {
            echo '<a href="?value=mainPage&value2=isteklerim">Isteklerim-(' . $data2['istekler'] . ')</a>';
        }

        echo '
        </div>
        <div class="item2">';
        if ($data['role'] == 'yonetici') {
            switch ($value2) {
                case 'products':
                    products();
                    break;
                case 'editProduct':
                    editProduct();
                    break;
                case 'addproduct':
                    addproduct();
                    break;
                case 'delete':
                    delete();
                    break;
                case 'borclar':
                    borclar();
                    break;
                case 'borcAra':
                    borcAra();
                    break;
                case 'barkodOku':
                    getbarkod();
                    break;
                case 'musteriBorc':
                    getmusteriBorc();
                    break;
                case 'deleteborc':
                    deleteBorc();
                    break;
                case 'satisyap':
                    satisyap();
                    break;
                case 'satislar':
                    satislar();
                    break;
                case 'yoneticiEkel':
                    yoneticiEkel();
                    break;
                case 'yoneticiler':
                    yoneticiler();
                    break;
                case 'deleteyonetici':
                    deleteyonetici();
                    break;

                case 'musteriEkle':
                    musteriEkle();
                    break;
                case 'musteriler':
                    musteriler();
                    break;
                case 'deletemusteri';
                    deletemusteri();
                    break;

                case 'satisAra':
                    satisAra();
                    break;
                case 'istek':
                    istek();
                    break;
                case 'talepler':
                    talepler();
                    break;
                case 'talepOnayla':
                    talepOnayla();
                    break;
                case 'anasayfa':
                    anasayfa();
                    break;
                default:
                    if (isset($_GET['value2'])) {
                        echo '
                            <div class="container">
                            <div class="">
                                <h1>404 Not Found Page</h1>
                            </div>
                           </div>
                        ';
                    } else {
                        header('location: ?value=mainPage&value2=anasayfa');
                    }
                    break;
            }
        } else {
            switch ($value2) {
                case 'isteklerim':
                    isteklerim();
                    break;

                default:
                    echo "<script>window.location='?value=mainPage'</script>";
                    break;
            }
        }
        echo "
            </div>
             </div>
            </div>
            ";
    } else {
        header('location: ?value=login');
    }
}



if (isset($_GET['value2'])) {
    $value2 = $_GET['value2'];
} else {
    $value2 = '';
}
if (isset($_GET['value'])) {
    $value = $_GET['value'];
} else {
    $value = '';
}

switch ($value) {
    case 'login':
        login();
        break;
    case 'mainPage':
        mainPage();
        break;
    case 'logout':
        session_destroy();
        header('location: ?value=login');
        break;
    case "pdf";
        create_pdf();
        break;
    default:
        if (isset($_GET['value'])) {
            echo '
            <div class="container">
            <div class="">
                <h1>404 Not Found Page</h1>
            </div>

           </div>
        }';
        } else {
            header('location: ?value=login');
        }
        break;
}
