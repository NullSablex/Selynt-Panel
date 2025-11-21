<?php 

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    /**
     * Carrega a lista de IDs de avatares a partir do arquivo de configuração.
     *
     * @return string[]
     */
    function getAvatarIds(): array
    {
        $file = APPPATH . 'Views/assets/avatars.php';

        if (!is_file($file)) {
            return [];
        }

        $ids = include $file;

        return is_array($ids) ? $ids : [];
    }

    /**
     * Retorna a lista de avatares disponíveis (id + URL).
     *
     * Cada item do array contém:
     * - id   => identificador do avatar (string)
     * - file => URL completa da imagem do avatar (string)
     *
     * @return array<int, array{id:string,file:string}>
     */
    function getAvatars(): array
    {
        $base_path = 'assets/img/avatars/';
        $avatars = [];

        foreach ($this->getAvatarIds() as $id) {
            $avatars[] = [
                'id' => $id,
                'file' => base_url($base_path . $id . '.png'),
            ];
        }

        return $avatars;
    }

    /**
     * Retorna a lista de IDs de avatares permitidos.
     *
     * @return string[]
     */
    function getAllowedAvatars(): array
    {
        return $this->getAvatarIds();
    }
}