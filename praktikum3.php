<?php

// KONTRAK
interface BisaDipinjam {
    public function pinjam(): bool;
}

// Class 1: BukuFisik
class BukuFisik implements BisaDipinjam {
    private bool $tersedia;

    public function __construct(bool $tersedia = true) {
        $this->tersedia = $tersedia;
    }

    public function pinjam(): bool {
        if (!$this->tersedia) {
            return false;           // sedang dipinjam orang lain
        }
        $this->tersedia = false;    // setelah dipinjam, tidak tersedia
        return true;
    }
}

// Class 2: Laptop
class Laptop implements BisaDipinjam {
    private bool $kondisiBaik;

    public function __construct(bool $kondisiBaik = true) {
        $this->kondisiBaik = $kondisiBaik;
    }

    public function pinjam(): bool {
        return $this->kondisiBaik;  // hanya laptop yang layak yang boleh dipinjam
    }
}

// COMPOSITION: keranjang berisi objek BisaDipinjam
class KeranjangPinjaman {
    private array $items = [];

    public function tambah(BisaDipinjam $item): void {
        $this->items[] = $item;
    }

    public function jumlah(): int {
        return count($this->items);
    }

    public function pinjamSemua(): array {
        $hasil = [];
        foreach ($this->items as $item) {
            $hasil[] = $item->pinjam();   // polymorphism: satu pemanggilan
        }
        return $hasil;
    }
}

// PROGRAM UTAMA
$keranjang = new KeranjangPinjaman();

$keranjang->tambah(new BukuFisik(true));    // tersedia
$keranjang->tambah(new Laptop(true));       // kondisi baik
$keranjang->tambah(new BukuFisik(false));   // sedang dipinjam

echo "\n";
echo "Jumlah item di keranjang : " . $keranjang->jumlah() . PHP_EOL;
echo PHP_EOL;
echo "Hasil operasi pinjam: \n";

foreach ($keranjang->pinjamSemua() as $i => $berhasil) {
    $status = $berhasil ? "berhasil dipinjam" : "gagal dipinjam";
    echo "Item " . ($i + 1) . " : " . $status . PHP_EOL;
}