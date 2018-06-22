<?php
namespace App\Shop\Roles\Repositories;

use App\Shop\Base\BaseRepository;
use App\Shop\Roles\Exceptions\CreateRoleErrorException;
use App\Shop\Roles\Exceptions\DeleteRoleErrorException;
use App\Shop\Roles\Exceptions\RoleNotFoundErrorException;
use App\Shop\Roles\Exceptions\UpdateRoleErrorException;
use App\Shop\Roles\Role;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    /**
     * @var Role
     */
    protected $model;
    /**
     * RoleRepository constructor.
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        parent::__construct($role);
        $this->model = $role;
    }
    /**
     * List all Roles
     *
     * @param string $order
     * @param string $sort
     * @return Collection
     */
    public function listRoles(string $order = 'id', string $sort = 'desc') : Collection
    {
        return $this->all(['*'], $order, $sort);
    }
    /**
     * @param array $data
     * @return Role
     * @throws CreateRoleErrorException
     */
    public function createRole(array $data) : Role
    {
        try {
            $role = new Role($data);
            $role->save();
            return $role;
        } catch (QueryException $e) {
            throw new CreateRoleErrorException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Role
     * @throws RoleNotFoundErrorException
     */
    public function findRoleById(int $id) : Role
    {
        try {
            return $this->findOneOrFail($id);
        } catch (QueryException $e) {
            throw new RoleNotFoundErrorException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws UpdateRoleErrorException
     */
    public function updateRole(array $data, int $id) : bool
    {
        try {
            return $this->update($data, $id);
        } catch (QueryException $e) {
            throw new UpdateRoleErrorException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return bool
     * @throws DeleteRoleErrorException
     */
    public function deleteRoleById(int $id) : bool
    {
        try {
            return $this->delete($id);
        } catch (QueryException $e) {
            throw new DeleteRoleErrorException($e);
        }
    }
}
