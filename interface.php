<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="lol.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
    integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">
  <script src="https://cdn.freecodecamp.org/testable-projects-fcc/v1/bundle.js"></script>
</head>

<body>

  <nav id="navbar">
    <a href="#welcome-section" class="item">Home</a>
    <a href="#about" class="item">About</a>
    <a href="#cek_kodam" class="item">Cek Kodam</a>
    <a href="#projects" class="item">Projects</a>
    <a href="#contact" class="item">Contact</a>
  </nav>
  <!--Welcome-->
  <div id="welcome-section">
    <div id="main-page-text">
      <h1>Zaki Ramadhan</h1>
      <p>2301082020</p>
    </div>
  </div>
  <!--About Section-->
  <div id="about">
    <h2>About me</h2>
    <table>
      <tr>
        <td>
          <p style="text-align:center; font-size:1.1em;color:whitesmoke;">Hi,My name is Zaki ramadhan<br> im a stundent
            of Politeknik Negeri Padang</p>
        </td>
        <td><img src="https://imgur.com/RzbiUcH.jpg" id="my-image"></td>
      </tr>
    </table>
    <br><br>
    <p>
      <span class="about-span">I live in Padang,I like to play games and watch anime.playing games is my
        favourite</span>
      hobby</span><br><br>

    </p>
  </div>
  <!--End about section-->
  <br><br><br>
  <!--Skills section-->
  <div id="cek_kodam" class="container mt-5">
    <div id="skills-box">
      <h2>Check Khodam</h2>
      <div id="khodam-container" class="row">
        <?php
        include 'connect.php'; // Menggunakan file connect.php untuk koneksi database
        
        // Query untuk mengambil semua khodam
        $sql = "SELECT id, name, khodam FROM khodam_table ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          // Output data dari setiap baris
          while ($row = $result->fetch_assoc()) {
            echo '<div class="col-md-4 mb-3">
                    <div class="card border-danger" style="max-width: 18rem;">
                      <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($row["name"]) . '</h5>
                        <p class="card-text">"' . htmlspecialchars($row["khodam"]) . '"</p>
                        <button class="btn btn-danger mt-auto" onclick="deleteKhodam(' . $row["id"] . ')">Hapus</button>
                      </div>
                    </div>
                  </div>';
          }
        } else {
          echo '<div id="no-khodam-card" class="col-md-4 mb-3">
                  <div class="card border-danger" style="max-width: 18rem;">
                    <div class="card-body">
                      <h5 class="card-title">Tidak ada khodam</h5>
                      <p class="card-text">Belum ada khodam yang ditambahkan.</p>
                    </div>
                  </div>
                </div>';
        }

        $conn->close();
        ?>
      </div>
      <div style="text-align: center; margin-top: 20px;">
        <button class="btn btn-primary" onclick="showForm()">Check Khodam</button>
      </div>
    </div>
  </div>

  <!-- Form untuk check khodam -->
  <div id="khodam-form" style="display: none; text-align: center; margin-top: 20px;">
    <form id="khodamForm">
      <input type="text" name="name" placeholder="Nama" required><br><br>
      <button type="submit" class="btn btn-success">Submit</button>
      <button type="button" class="btn btn-secondary" onclick="hideForm()">Cancel</button>
    </form>
  </div>

  <script>
    function showForm() {
      document.getElementById('khodam-form').style.display = 'block';
    }

    function hideForm() {
      document.getElementById('khodam-form').style.display = 'none';
    }

    document.getElementById('khodamForm').addEventListener('submit', function(event) {
      event.preventDefault();
      var formData = new FormData(this);

      fetch('add_khodam.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            var khodamContainer = document.getElementById('khodam-container');
            var noKhodamCard = document.getElementById('no-khodam-card');
            if (noKhodamCard) {
              noKhodamCard.remove();
            }
            var newCard = document.createElement('div');
            newCard.className = 'col-md-4 mb-3';
            newCard.innerHTML = '<div class="card border-danger" style="max-width: 18rem;">' +
                                '<div class="card-body">' +
                                '<h5 class="card-title">' + data.name + '</h5>' +
                                '<p class="card-text">"' + data.khodam + '"</p>' +
                                '<button class="btn btn-danger mt-auto" onclick="deleteKhodam(' + data.id + ')">Hapus</button>' +
                                '</div>' +
                                '</div>';
            khodamContainer.insertBefore(newCard, khodamContainer.firstChild);
            hideForm();
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => console.error('Error:', error));
    });

    function deleteKhodam(id) {
      if (confirm('Apakah Anda yakin ingin menghapus khodam ini?')) {
        fetch('delete_khodam.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ id: id })
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              document.querySelector('button[onclick="deleteKhodam(' + id + ')"]').closest('.col-md-4').remove();
              if (document.getElementById('khodam-container').children.length === 0) {
                var khodamContainer = document.getElementById('khodam-container');
                var noKhodamCard = document.createElement('div');
                noKhodamCard.id = 'no-khodam-card';
                noKhodamCard.className = 'col-md-4 mb-3';
                noKhodamCard.innerHTML = '<div class="card border-danger" style="max-width: 18rem;">' +
                                           '<div class="card-body">' +
                                           '<h5 class="card-title">Tidak ada khodam</h5>' +
                                           '<p class="card-text">Belum ada khodam yang ditambahkan.</p>' +
                                           '</div>' +
                                           '</div>';
                khodamContainer.appendChild(noKhodamCard);
              }
            } else {
              alert('Error: ' + data.message);
            }
          })
          .catch(error => console.error('Error:', error));
      }
    }
  </script>
  <!--End skills section-->
  <div>&nbsp;</div>
  <div id="contact">
    <br>
    <h1>Let's work together</h1>
    <p>How do you take your coffee?</p><br>
    <div id="others">
      <a href="https://www.facebook.com/zaki.ramadan.1238"><i class="fab fa-facebook-square"></i>Facebook</a>
      <a href="https://github.com/wSkidX"><i class="fab fa-github"></i>Github</a>
      <a href="https://www.instagram.com/ja4ki/"><i class="fab fa-instagram"></i>Instagram</a>
      <a href="#"><i class="fas fa-at"></i>Send a mail</a>
      <a href="#"><i class="fas fa-mobile-alt"></i>Call me</a>
    </div>
    <br>
  </div>
  <div id="notifications-container"></div>
  <script src="script.js"></script>
</body>

</html>