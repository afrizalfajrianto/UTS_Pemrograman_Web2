# UTS_Pemrograman_Web2


|             |                                  |
| ----------- | -------------------------------  |
| Nama        | Afrizal Fajrianto Anggara Sakti  |
| NIM         | 312210449                        |
| Kelas       | TI.22.A.4                        |
| Mata Kuliah | Pemrograman Visual (Desktop)     |

## Eksperimen SQL Injection di Aplikasi Web Sederhana: Belajar dari Simulasi Nyata 

- Eksperimen ini bertujuan untuk memahami bagaimana SQL Injection bisa terjadi pada aplikasi web sederhana berbasis PHP dan MySQL.
- Kita akan membuat form login sederhana tanpa pengamanan, lalu menguji apakah input yang dimanipulasi bisa membypass login. <br>

### Teknologi yang Digunakan
- PHP 7.x
- MySQL (Database lokal via XAMPP)
- Web Browser (Chrome, Firefox, dsb.)
- Text Editor (VSCode, Sublime Text, atau Notepad++) 

### Cara Menjalankan
1. Instal XAMPP dan aktifkan Apache + MySQL.
2. Buat database baru di phpMyAdmin dengan nama: demo
3. Import tabel users lewat query ini:
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(50)
);

INSERT INTO users (username, password) VALUES
('admin', 'admin123'),
('user', 'user123');
```

4. Buat file `login.php` di folder `htdocs/` XAMPP kamu:

```php
<form method="post" action="login.php">
  Username: <input type="text" name="username"><br>
  Password: <input type="password" name="password"><br>
  <input type="submit" value="Login">
</form>

<?php
$conn = mysqli_connect("localhost", "root", "", "demo");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    echo "Login berhasil!";
  } else {
    echo "Login gagal.";
  }
}
?>
```
5. Buka browser, akses http://localhost/login.php <br>

![img](gambar/form%20login.png) <br>

### Eksperimen SQL Injection
Langkah:
- Pada form login, masukkan:

    - Username: admin' --
    - Password: (dibiarkan kosong)

Penjelasan:
- Input tersebut membuat query SQL berubah menjadi:
```sql
SELECT * FROM users WHERE username='admin' --' AND password=''
```
- `--` adalah tanda komentar di SQL, sehingga bagian pemeriksaan password diabaikan.
- Akibatnya, login akan berhasil hanya dengan mengetahui username saja!

### Output
Saat eksperimen berhasil, tampilan di browser:

![img](gambar/form%20login%20berhasil.png) <br>

Saat eksperimen gagal, tampilan di browser:

![img](gambar/form%20login%20gagal.png) <br>

### Cara Mencegah SQL Injection
Solusi terbaik adalah menggunakan Prepared Statements atau PDO di PHP.
Contoh pengamanannya:
```php
$stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  echo "Login berhasil!";
} else {
  echo "Login gagal.";
}
```

### Link Artikel Publikasi

Artikel ini telah dipublikasikan di Blogger dan dapat dibaca melalui tautan berikut: <br>
https://sqlinjectionlab.blogspot.com/2025/04/eksperimen-sql-injection-di-aplikasi.html

### Bukti Pengecekan Plagiasi

Berikut adalah hasil pengecekan plagiarisme artikel menggunakan DupliChecker:

![img](gambar/bukti%20plagiat.png)

- Plagiarism Rate: 14%
- Unique Content: 86%








