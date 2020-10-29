<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/29/2020
 * Time: 8:43 AM
 */

namespace App\Repositories\Eloquent;


use App\Models\Form;
use App\Models\PostCounts;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository implements \App\Repositories\Contracts\UserRepository
{
    /**
     * Get's a record by it's ID
     *
     * @param int
     * @return collection
     */
    public function get($id)
    {
        return Form::find($id);
    }

    /**
     * Get's all records.
     *
     * @return mixed
     */
    public function all()
    {
//        $distinct = Form::join('users', 'users.id', '=', 'forms.user_id')->groupBy('users.name')->get();
        $distinct = Form::latest()->get();
        return $distinct;
    }


    public function store($request)
    {
        $userCheck = User::where('name', $request['name'])->first();
        if ($userCheck) {
//            dd($userCheck->post_counts->post_count);
            $store = Form::create([
                'user_id' => $userCheck->id,
                'title' => $request['title'],
                'content' => $request['content'],
                'color' => $request['color'],
            ]);
            $last_number = PostCounts::max('post_count');
            $increment_post = PostCounts::create(['form_id' => $store->id, 'post_count' => $last_number + 1]);

//            $number_of_post = PostCounts::create(['user_id' => $userCheck->id], ['post_count' => $userCheck->post_counts->post_count + 1]);

        } else {
            $new_user = User::create(['name' => $request['name']]);
            $store = Form::create([
                'user_id' => $new_user->id,
                'title' => $request['title'],
                'content' => $request['content'],
                'color' => $request['color'],
            ]);
            $number_of_post = PostCounts::create(['form_id' => $store->id, 'post_count' => 1]);

        }


        return true;
    }

    /**
     * Deletes a record.
     *
     * @param int
     */
    public function delete($id)
    {
        Form::destroy($id);
        return true;
    }

    /**
     * Updates a post.
     *
     * @param int
     * @param array
     */
    public function update($id, array $data)
    {
        $save['title'] = $data['title'];
        $save['content'] = $data['color'];
        $save['color'] = $data['color'];
        $user['name'] = $data['name'];
        $find = Form::find($id);
        $form_update = $find->update($save);
        $find->users->update($user);
    }

}