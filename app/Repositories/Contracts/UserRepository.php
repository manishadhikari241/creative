<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/29/2020
 * Time: 8:43 AM
 */

namespace App\Repositories\Contracts;


interface UserRepository
{

    public function get($id);

    /**
     * Get's all records.
     *
     * @return mixed
     */
    public function all();

    /**
     * Deletes a record.
     *
     * @param int
     */
    public function delete($id);

    /**
     * Updates a record.
     *
     * @param int
     * @param array
     */
    public function update($id, array $data);

}