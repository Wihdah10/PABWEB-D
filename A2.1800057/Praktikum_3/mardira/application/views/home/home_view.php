<h1>Halaman Utama</h1>
<ul>
    <li>
        <?= anchor('mahasiswa', 'Data Mahasiswa') ?>
    </li>
    <li>
        <?= anchor('Program_studi', 'Data Program Studi') ?>
    </li>
</ul>
<p>
    <?php
    $nama_lengkap = $this->session->userdata('nama_lengkap');
    echo "Selamat Datang $nama_lengkap !";
    ?>
</p>
<p>
    <?= anchor('auth/hapus_session', 'Hapus Session Nama Lengkap') ?>
</p>
<?= anchor('logout', 'Logout') ?>