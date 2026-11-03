<?php
class Barang {
 private PDO $db;
 public function __construct(PDO $db) { $this->db = $db; }
 public function semua(): array {
  return $this->db->query('SELECT b.*, k.nama AS kategori FROM barang b JOIN kategori k ON k.id=b.kategori_id ORDER BY b.id DESC')->fetchAll();
 }
 public function cari(int $id): ?array {
  $q=$this->db->prepare('SELECT * FROM barang WHERE id=?'); $q->execute([$id]); return $q->fetch() ?: null;
 }
 public function simpan(array $d, ?int $id=null): void {
  if ($id) { $q=$this->db->prepare('UPDATE barang SET nama=?,kategori_id=?,harga=?,stok=? WHERE id=?'); $q->execute([$d['nama'],$d['kategori_id'],$d['harga'],$d['stok'],$id]); }
  else { $q=$this->db->prepare('INSERT INTO barang(nama,kategori_id,harga,stok) VALUES(?,?,?,?)'); $q->execute([$d['nama'],$d['kategori_id'],$d['harga'],$d['stok']]); }
 }
 public function hapus(int $id): void { $q=$this->db->prepare('DELETE FROM barang WHERE id=?'); $q->execute([$id]); }
}
