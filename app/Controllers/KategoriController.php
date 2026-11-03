<?php
require_once __DIR__.'/../Models/Kategori.php';
class KategoriController {
 private Kategori $model;
 public function __construct(PDO $db){$this->model=new Kategori($db);}
 public function index():void{$items=$this->model->semua();require __DIR__.'/../Views/kategori/index.php';}
 public function form():void{$id=(int)($_GET['id']??0);$item=$id?$this->model->cari($id):null;if($id&&!$item){http_response_code(404);exit('Kategori tidak ditemukan');}$error='';require __DIR__.'/../Views/kategori/form.php';}
 public function save():void{$id=(int)($_POST['id']??0);$nama=trim($_POST['nama']??'');$error='';if($nama===''||mb_strlen($nama)>100)$error='Nama kategori wajib diisi (maksimal 100 karakter).';if($error){$item=['id'=>$id,'nama'=>$nama];require __DIR__.'/../Views/kategori/form.php';return;}try{$this->model->simpan($nama,$id?:null);}catch(PDOException $e){$item=['id'=>$id,'nama'=>$nama];$error='Nama kategori sudah digunakan.';require __DIR__.'/../Views/kategori/form.php';return;}header('Location: index.php?module=kategori');exit;}
 public function delete():void{$id=(int)($_POST['id']??0);try{$this->model->hapus($id);}catch(PDOException $e){http_response_code(409);exit('Kategori masih dipakai barang. Pindahkan/hapus barang terlebih dahulu.');}header('Location: index.php?module=kategori');exit;}
}
