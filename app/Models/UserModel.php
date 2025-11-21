<?php 

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $allowedFields  = ['user', 'pass', 'name', 'email', 'avatar', 'created', 'last_login'];

    /**
     * Realiza a autenticação de um usuário.
     *
     * @param array $data Dados de acesso: ['user' => username, 'pass' => password]
     * @return bool Retorna true se autenticado com sucesso, false caso contrário.
     */
    function login(array $data): bool
    {
        $userRow = $this->select('status, pass, id, avatar')
            ->where('user', $data['user'])
            ->get(1)
            ->getRowArray();

        if (!$userRow || !password_verify($data['pass'], $userRow['pass'])) {
            swal_error(lang('Site.Email_ou_nome_de_usuário_incorretos.'));
            return false;
        }

        session()->regenerate(true);

        $up_sess = [
            'logged_in' => true,
            'user_id' => (int) $userRow['id'],
            'csrf_secure' => '',
            'acc_status' => (int) $userRow['status'],
            'user_avatar' => $userRow['avatar'],
        ];

        session()->set($up_sess);
        $this->update($userRow['id'], ['last_login' => time()]);
        return true;
    }
}