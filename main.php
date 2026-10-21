<?php
// Tugas Pertemuan 5: Advanced OOP (Mini Application OOP)


// 1. KONTRAK INTERFACE (Capability: "Can-Do")

/**
 * Interface DapatDiskon mendefinisikan kontrak bahwa objek yang mengimplementasikannya
 * memiliki kemampuan untuk menerima potongan harga promosi.
 */
interface DapatDiskon {
    public function terapkanDiskon(float $persen): void;
    public function getBesarDiskon(): float;
}


// 2. ABSTRACT PARENT CLASS (Generalization / Inheritance: "Is-A")

/**
 * Abstract Class Laptop bertindak sebagai blueprint dasar bagi semua jenis laptop.
 * Menggabungkan encapsulation (property protected/private) dan abstraction.
 */
abstract class Laptop implements DapatDiskon {
    protected string $kodeProduk;
    protected string $merk;
    protected string $spesifikasi;
    protected float $hargaDasar;
    protected int $stok;
    protected float $persenDiskon = 0.0;

    public function __construct(
        string $kodeProduk,
        string $merk,
        string $spesifikasi,
        float $hargaDasar,
        int $stok
    ) {
        if ($hargaDasar <= 0) {
            throw new InvalidArgumentException("Harga dasar laptop harus lebih besar dari 0.");
        }
        if ($stok < 0) {
            throw new InvalidArgumentException("Stok awal laptop tidak boleh bernilai negatif.");
        }

        $this->kodeProduk  = $kodeProduk;
        $this->merk        = $merk;
        $this->spesifikasi = $spesifikasi;
        $this->hargaDasar  = $hargaDasar;
        $this->stok        = $stok;
    }

    // Getter methods
    public function getKodeProduk(): string {
        return $this->kodeProduk;
    }

    public function getMerk(): string {
        return $this->merk;
    }

    public function getSpesifikasi(): string {
        return $this->spesifikasi;
    }

    public function getHargaDasar(): float {
        return $this->hargaDasar;
    }

    public function getStok(): int {
        return $this->stok;
    }

    // Implementasi Interface DapatDiskon
    public function terapkanDiskon(float $persen): void {
        if ($persen < 0 || $persen > 100) {
            throw new InvalidArgumentException("Persentase diskon harus berada di rentang 0 sampai 100 persen.");
        }
        $this->persenDiskon = $persen;
    }

    public function getBesarDiskon(): float {
        return ($this->hargaDasar * $this->persenDiskon) / 100;
    }

    // Operasi Stok
    public function kurangiStok(int $jumlah): bool {
        if ($jumlah <= 0) {
            echo "[Peringatan] Jumlah pengurangan stok harus lebih dari 0.\n";
            return false;
        }
        if ($this->stok < $jumlah) {
            echo "[Gagal] Stok {$this->merk} tidak mencukupi (Tersedia: {$this->stok}, Diminta: {$jumlah}).\n";
            return false;
        }
        $this->stok -= $jumlah;
        return true;
    }

    public function tambahStok(int $jumlah): void {
        if ($jumlah <= 0) {
            echo "[Peringatan] Jumlah penambahan stok harus lebih dari 0.\n";
            return;
        }
        $this->stok += $jumlah;
        echo "[Restok Berhasil] Menambahkan {$jumlah} unit ke stok {$this->merk}. Total stok sekarang: {$this->stok} unit.\n";
    }

    // Abstract Methods yang wajib diwujudkan (override) oleh setiap subclass
    abstract public function getKategori(): string;
    abstract public function hitungHargaJual(): float;
    abstract public function cetakSpesifikasiKhusus(): void;
}


// 3. SUBCLASSES (Specialization & Overriding)

/**
 * Subclass LaptopGaming: Spesialisasi untuk komputasi grafis berat dan gaming.
 * Memiliki biaya tambahan untuk sistem pendingin liquid cooling & garansi hardware VIP.
 */
class LaptopGaming extends Laptop {
    private string $gpu;
    private int $refreshRate; // Hertz (Hz)
    private float $biayaGaransiGaming = 500000; // Biaya garansi khusus performa gaming

    public function __construct(
        string $kodeProduk,
        string $merk,
        string $spesifikasi,
        float $hargaDasar,
        int $stok,
        string $gpu,
        int $refreshRate
    ) {
        parent::__construct($kodeProduk, $merk, $spesifikasi, $hargaDasar, $stok);
        $this->gpu         = $gpu;
        $this->refreshRate = $refreshRate;
    }

    public function getKategori(): string {
        return "Laptop Gaming High-Performance";
    }

    // Overriding: Perhitungan harga jual khusus Laptop Gaming
    public function hitungHargaJual(): float {
        $hargaSetelahDiskon = $this->hargaDasar - $this->getBesarDiskon();
        // Gaming laptop dikenakan biaya garansi sistem pendingin VIP
        return $hargaSetelahDiskon + $this->biayaGaransiGaming;
    }

    // Overriding: Menampilkan spesifikasi khusus GPU & Layar
    public function cetakSpesifikasiKhusus(): void {
        echo "  [Khusus Gaming] GPU: {$this->gpu} | Refresh Rate: {$this->refreshRate}Hz\n";
        echo "  [Biaya Proteksi Cooling & Garansi VIP]: Rp " . number_format($this->biayaGaransiGaming, 0, ',', '.') . "\n";
    }
}

/**
 * Subclass LaptopUltrabook: Spesialisasi untuk produktivitas, portabilitas, dan bisnis.
 * Dilengkapi bundel lisensi software bisnis dan proteksi baterai.
 */
class LaptopUltrabook extends Laptop {
    private float $beratKg;
    private int $dayaTahanBateraiJam;
    private float $biayaLisensiBisnis = 300000; // Bundel Office & Cloud Backup 1 Tahun

    public function __construct(
        string $kodeProduk,
        string $merk,
        string $spesifikasi,
        float $hargaDasar,
        int $stok,
        float $beratKg,
        int $dayaTahanBateraiJam
    ) {
        parent::__construct($kodeProduk, $merk, $spesifikasi, $hargaDasar, $stok);
        $this->beratKg             = $beratKg;
        $this->dayaTahanBateraiJam = $dayaTahanBateraiJam;
    }

    public function getKategori(): string {
        return "Laptop Ultrabook Bisnis & Portabel";
    }

    // Overriding: Perhitungan harga jual khusus Laptop Ultrabook
    public function hitungHargaJual(): float {
        $hargaSetelahDiskon = $this->hargaDasar - $this->getBesarDiskon();
        // Ultrabook dilengkapi paket lisensi produktivitas bisnis resmi
        return $hargaSetelahDiskon + $this->biayaLisensiBisnis;
    }

    // Overriding: Menampilkan spesifikasi khusus bobot & baterai
    public function cetakSpesifikasiKhusus(): void {
        echo "  [Khusus Bisnis] Bobot: {$this->beratKg} kg | Ketahanan Baterai: Hingga {$this->dayaTahanBateraiJam} Jam\n";
        echo "  [Bundel Software Bisnis Resmi]: Rp " . number_format($this->biayaLisensiBisnis, 0, ',', '.') . "\n";
    }
}


// 4. COMPOSITION ("Has-A" Relationship)

/**
 * Class Transaksi mewakili kejadian transaksi penjualan.
 * Menggunakan relasi Komposisi: Sebuah Transaksi MEMILIKI kumpulan (array) objek Laptop.
 */
class Transaksi {
    private string $idTransaksi;
    private string $namaPelanggan;
    private string $tanggal;
    private array $daftarItem = []; // Menyimpan array of associative array [laptop => object, jumlah => int]

    public function __construct(string $idTransaksi, string $namaPelanggan) {
        $this->idTransaksi   = $idTransaksi;
        $this->namaPelanggan = $namaPelanggan;
        $this->tanggal       = date("d-m-Y H:i:s");
    }

    public function tambahItem(Laptop $laptop, int $jumlah): bool {
        if ($jumlah <= 0) {
            echo "[Gagal] Jumlah pembelian minimal 1 unit.\n";
            return false;
        }

        // Cek ketersediaan stok laptop sebelum dimasukkan ke keranjang transaksi
        if ($laptop->getStok() < $jumlah) {
            echo "[Gagal Transaksi] Stok untuk {$laptop->getMerk()} tidak mencukupi!\n";
            return false;
        }

        // Kurangi stok barang secara otomatis saat masuk transaksi
        $laptop->kurangiStok($jumlah);

        $this->daftarItem[] = [
            'laptop' => $laptop,
            'jumlah' => $jumlah
        ];

        echo "[Ditambahkan] {$jumlah} unit {$laptop->getMerk()} berhasil dimasukkan ke Transaksi {$this->idTransaksi}.\n";
        return true;
    }

    // Menghitung total keseluruhan dengan menerapkan Polymorphism
    public function hitungTotal(): float {
        $total = 0;
        foreach ($this->daftarItem as $item) {
            /** @var Laptop $laptop */
            $laptop = $item['laptop'];
            // Polymorphism: memanggil hitungHargaJual() secara dinamis tanpa if/else jenis laptop
            $total += $laptop->hitungHargaJual() * $item['jumlah'];
        }
        return $total;
    }

    public function cetakStruk(): void {
        echo "\n----------------------------------------------------------------------\n";
        echo "                     STRUK TRANSAKSI TOKO LAPTOP                      \n";
        echo "----------------------------------------------------------------------\n";
        echo "No. Transaksi : {$this->idTransaksi}\n";
        echo "Pelanggan     : {$this->namaPelanggan}\n";
        echo "Waktu         : {$this->tanggal}\n";
        echo "----------------------------------------------------------------------\n";
        echo sprintf("%-4s %-22s %-12s %-8s %-16s\n", "No", "Produk", "Kategori", "Qty", "Subtotal");
        echo "----------------------------------------------------------------------\n";

        $no = 1;
        foreach ($this->daftarItem as $item) {
            /** @var Laptop $laptop */
            $laptop   = $item['laptop'];
            $jumlah   = $item['jumlah'];
            $hargaSat = $laptop->hitungHargaJual();
            $subtotal = $hargaSat * $jumlah;

            echo sprintf(
                "%-4d %-22s %-12s %-8d Rp %-13s\n",
                $no++,
                substr($laptop->getMerk(), 0, 21),
                substr($laptop->getKategori(), 0, 11),
                $jumlah,
                number_format($subtotal, 0, ',', '.')
            );
        }

        echo "----------------------------------------------------------------------\n";
        echo "TOTAL PEMBAYARAN : Rp " . number_format($this->hitungTotal(), 0, ',', '.') . "\n";
        echo "----------------------------------------------------------------------\n\n";
    }
}


// 5. DEMONSTRASI POLYMORPHISM


/**
 * Fungsi seragam untuk menampilkan informasi produk apa pun yang berjenis Laptop.
 * Menggunakan type-hinting superclass (Laptop) sehingga dapat menerima LaptopGaming,
 * LaptopUltrabook, maupun jenis turunan lainnya tanpa percabangan if/else.
 */
function tampilkanKatalogPolymorphic(Laptop $laptop): void {
    echo "----------------------------------------------------------------------\n";
    echo "Kode Produk : " . $laptop->getKodeProduk() . "\n";
    echo "Merk        : " . $laptop->getMerk() . "\n";
    echo "Kategori    : " . $laptop->getKategori() . "\n";
    echo "Spesifikasi : " . $laptop->getSpesifikasi() . "\n";
    echo "Harga Dasar : Rp " . number_format($laptop->getHargaDasar(), 0, ',', '.') . "\n";
    if ($laptop->getBesarDiskon() > 0) {
        echo "Diskon Promo: Rp " . number_format($laptop->getBesarDiskon(), 0, ',', '.') . "\n";
    }
    $laptop->cetakSpesifikasiKhusus();
    echo "Harga Akhir : Rp " . number_format($laptop->hitungHargaJual(), 0, ',', '.') . "\n";
    echo "Stok Ready  : " . $laptop->getStok() . " unit\n";
}


// 6. PROGRAM UTAMA / SKENARIO PENGUJIAN

echo "\n----------------------------------------------------------------------\n";
echo "    SISTEM JUAL BELI LAPTOP BERBASIS ADVANCED OOP (PERTEMUAN 5)        \n";
echo "----------------------------------------------------------------------\n\n";

// SKENARIO 1: Instansiasi Objek Subclass
echo "> [SKENARIO 1] Inisialisasi Objek Subclass (Inheritance & Spesialisasi)\n";
$rog = new LaptopGaming(
    "LPT-G01",
    "ASUS ROG Strix G16",
    "Intel Core i9-13980HX, 32GB RAM DDR5, 1TB NVMe SSD",
    32000000,
    5,
    "NVIDIA GeForce RTX 4080 12GB",
    240
);

$thinkpad = new LaptopUltrabook(
    "LPT-U01",
    "Lenovo ThinkPad X1 Carbon",
    "Intel Core i7-1365U, 16GB RAM LPDDR5, 512GB SSD",
    24000000,
    3,
    1.12,
    14
);

// SKENARIO 2: Penerapan Diskon melalui Interface
echo "\n> [SKENARIO 2] Penerapan Interface 'DapatDiskon'\n";
echo "Memberikan diskon promosi 10% untuk ASUS ROG dan 5% untuk Lenovo ThinkPad...\n";
$rog->terapkanDiskon(10.0);       // Diskon 10% dari 32.000.000 = 3.200.000
$thinkpad->terapkanDiskon(5.0);   // Diskon 5% dari 24.000.000 = 1.200.000

// SKENARIO 3: Demonstrasi Polymorphism pada Katalog Produk
echo "\n> [SKENARIO 3] Demonstrasi Polymorphism Melalui Koleksi Array\n";
$katalogToko = [$rog, $thinkpad];

foreach ($katalogToko as $itemLaptop) {
    // Satu fungsi pemanggil yang sama, menghasilkan output berbeda sesuai wujud objek konkret
    tampilkanKatalogPolymorphic($itemLaptop);
}

// SKENARIO 4: Demonstrasi Composition (Transaksi Penjualan)
echo "\n> [SKENARIO 4] Demonstrasi Composition (Pembuatan Transaksi)\n";
$transaksi = new Transaksi("TRX-202610-001", "John");
$transaksi->tambahItem($rog, 1);       // Membeli 1 unit ASUS ROG
$transaksi->tambahItem($thinkpad, 2);  // Membeli 2 unit Lenovo ThinkPad

// Cetak Struk Hasil Transaksi
$transaksi->cetakStruk();

// SKENARIO 5: Uji Validasi Bisnis (Stok Tidak Cukup & Input Diskon Salah)
echo "> [SKENARIO 5] Pengujian Batas Validasi (Guard Clause & Exception Handling)\n";

echo "1. Mencoba membeli melebihi sisa stok yang ada:\n";
$transaksiGagal = new Transaksi("TRX-GAGAL-002", "Budi Santoso");
$transaksiGagal->tambahItem($thinkpad, 5); // Stok ThinkPad tersisa 1 setelah transaksi pertama

echo "\n2. Mencoba memasukkan persentase diskon tidak valid (150%):\n";
try {
    $rog->terapkanDiskon(150.0);
} catch (InvalidArgumentException $e) {
    echo "[Exception Tertangkap] " . $e->getMessage() . "\n";
}

echo "\n3. Mencoba membuat laptop dengan harga dasar negatif:\n";
try {
    $laptopError = new LaptopGaming("ERR-01", "Laptop Rusak", "Spec", -1000000, 1, "GPU", 60);
} catch (InvalidArgumentException $e) {
    echo "[Exception Tertangkap] " . $e->getMessage() . "\n";
}
