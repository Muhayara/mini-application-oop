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
    // Override
    public function caraAkses(): string {
        return "Baca atau pinjam di perpustakaan";
    }
}

class BukuDigital extends Buku {
    // Override
    public function caraAkses(): string {
        return "Buka melalui aplikasi";
    }
}

$bukuFisik   = new BukuFisik("laskar");
$bukuDigital = new BukuDigital("pelangi");
echo PHP_EOL;
echo "Judul buku  : " . $bukuFisik->getJudul() . PHP_EOL;
echo "Cara akses  : " . $bukuFisik->caraAkses() . PHP_EOL;

echo PHP_EOL;

echo "Judul buku  : " . $bukuDigital->getJudul() . PHP_EOL;
echo "Cara akses  : " . $bukuDigital->caraAkses() . PHP_EOL;
echo PHP_EOL;