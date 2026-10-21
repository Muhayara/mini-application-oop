<?php

class Buku {
    private string $judul;

    public function __construct(string $judul) {
        $this->judul = $judul;
    }

    public function getJudul(): string {
        return $this->judul;
    }

    public function caraAkses(): string {
        return "Akses umum";
    }
}

class BukuFisik extends Buku {
    public function caraAkses(): string {
        return "Baca atau pinjam di perpustakaan";
    }
}

class BukuDigital extends Buku {
    public function caraAkses(): string {
        return "Buka melalui aplikasi";
    }
}

// Tambahan Praktikum 2: jenis ketiga
class BukuReferensi extends Buku {
    public function caraAkses(): string {
        return "Baca di tempat, tidak dapat dipinjam";
    }
}

// Fungsi pemanggil: menerima tipe umum Buku
function tampilkanAkses(Buku $buku): void {
    echo "Judul buku  : " . $buku->getJudul() . PHP_EOL;
    echo "Cara akses  : " . $buku->caraAkses() . PHP_EOL;
}

// Daftar berisi tiga jenis objek berbeda
$daftar = [
    new BukuFisik("laskar"),
    new BukuDigital("pelangi"),
    new BukuReferensi("Kamus Besar Bahasa Indonesia"),
];

foreach ($daftar as $buku) {
    tampilkanAkses($buku);
    echo "\n";
}