<?php
require_once __DIR__.'/../Models/Barang.php'; require_once __DIR__.'/../Models/Kategori.php';
class BarangController {
 private Barang $barang; private Kategori $kategori;
 public function __construct(PDO $db){$this->barang=new Barang($db);$this->kategori=new Kategori($db);}
 public function index():void{$items=$this->barang->semua();require __DIR__.'/../Views/barang/index.php';}
 public function form():void{$id=isset($_GET['id'])?(int)$_GET['id']:null;$item=$id?$this->barang->cari($id):null;if($id&&!$item){http_response_code(404);exit('Barang tidak ditemukan');}$categories=$this->kategori->semua();$error='';require __DIR__.'/../Views/barang/form.php';}
 public function save():void{
  $id=(int)($_POST['id']??0);$nama=trim($_POST['nama']??'');$kat=(int)($_POST['kategori_id']??0);$harga=$_POST['harga']??'';$stok=$_POST['stok']??'';
  $error='';
  if($nama===''||mb_strlen($nama)>150)$error='Nama barang wajib diisi (maksimal 150 karakter).';
  elseif(!$this->kategori->cari($kat))$error='Silakan pilih kategori yang valid.';
  elseif(!is_numeric($harga)||$harga<0)$error='Harga harus angka dan tidak boleh negatif.';
  elseif(filter_var($stok,FILTER_VALIDATE_INT)===false||$stok<0)$error='Stok harus bilangan bulat dan tidak boleh negatif.';
  if($error){$item=['id'=>$id,'nama'=>$nama,'kategori_id'=>$kat,'harga'=>$harga,'stok'=>$stok];$categories=$this->kategori->semua();require __DIR__.'/../Views/barang/form.php';return;}
  $data=['nama'=>$nama,'kategori_id'=>$kat,'harga'=>(float)$harga,'stok'=>(int)$stok];$this->barang->simpan($data,$id?:null);header('Location: index.php?module=barang');exit;
 }
 public function delete():void{$id=(int)($_POST['id']??0);if($id<1){http_response_code(400);exit('ID tidak valid');}$this->barang->hapus($id);header('Location: index.php?module=barang');exit;}
}
