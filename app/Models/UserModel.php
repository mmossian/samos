<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $table = 'users';
	protected $primaryKey = 'id';
	protected $allowedFields = ['parent_id', 'address_id', 'company_id', 'email', 'password', 'fullname', 'ugroup', 'lang', 'active', 'first_time', 'social_provider', 'email_verified_at', 'password_verified_at', 'last_ip'];
	protected $useSoftDeletes = false;
	protected $useTimestamps = true;
	protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    // protected $returnType = 'App\Entities\User';
    protected $returnType = 'object';
}
