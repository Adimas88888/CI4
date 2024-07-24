<?php namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'postss';
    protected $primaryKey = 'id';

    protected $allowedFields = ['title', 'body'];

    // Jika Anda ingin menggunakan timestamps, aktifkan opsi berikut
    // protected $useTimestamps = true;
}
