<?php
class Kategori {
 private PDO $db;
 public function __construct(PDO $db) { $this->db=$db; }
 public function semua(): array { return $this->db->query('SELECT * FROM kategori ORDER BY id DESC')->fetchAll(); }
 public function cari(int $id): ?array { $q=$this->db->prepare('SELECT * FROM kategori WHERE id=?');$q->execute([$id]);return $q->fetch()?:null; }
 public function simpan(string $nama, ?int $id=null): void {
  if($id){$q=$this->db->prepare('UPDATE kategori SET nama=? WHERE id=?');$q->execute([$nama,$id]);}
  else{$q=$this->db->prepare('INSERT INTO kategori(nama) VALUES(?)');$q->execute([$nama]);}
 }
 public function hapus(int $id): void {$q=$this->db->prepare('DELETE FROM kategori WHERE id=?');$q->execute([$id]);}
}
