<?php
session_start();
require_once __DIR__.'/../app/Controllers/BarangController.php';
require_once __DIR__.'/../app/Controllers/KategoriController.php';
try{$db=require __DIR__.'/../config/database.php';}catch(Throwable $e){http_response_code(500);exit('Database belum tersambung. Periksa config/database.php dan import sql/database.sql. Detail: '.htmlspecialchars($e->getMessage()));}
if(!isset($_SESSION['csrf']))$_SESSION['csrf']=bin2hex(random_bytes(32));
$module=$_GET['module']??'barang';$action=$_GET['action']??'index';
$allowed=['barang'=>['index','form','save','delete'],'kategori'=>['index','form','save','delete']];
if(!isset($allowed[$module])||!in_array($action,$allowed[$module],true)){http_response_code(404);exit('Route tidak ditemukan');}
$isPost=in_array($action,['save','delete'],true);
if(($isPost&&$_SERVER['REQUEST_METHOD']!=='POST')||(!$isPost&&$_SERVER['REQUEST_METHOD']!=='GET')){http_response_code(405);exit('Method tidak diizinkan');}
if($isPost&&!hash_equals($_SESSION['csrf'],$_POST['csrf']??'')){http_response_code(403);exit('Token keamanan tidak valid. Muat ulang halaman.');}
$controller=$module==='barang'?new BarangController($db):new KategoriController($db);
$controller->$action();
