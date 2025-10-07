<?

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{
    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes){

            $created = User::query()->create([
                'name' => data_get($attributes, 'name'),
                'email' => data_get($attributes, 'email'),
                'password' => data_get($attributes, 'password'),
            ]);

            if ($userIds = data_get($attributes, 'user_ids')) {
                $created->users()->sync($userIds);
            }
            return $created;
        });
    }

    public function update($user, array $attributes)
    {
        return DB::transaction(function () use($user, $attributes)
        {
            $updated = $user->update([
                'title' => data_get($attributes, 'title', $user->title),
                'body' => data_get($attributes, 'body', $user->body),
            ]);

            if(!$updated){
                throw new \Exception('Failed to update user');
            }

            if ($userIds = data_get($attributes, 'user_ids')) {
                $user->users()->sync($userIds);
            }

            return $user;
        });
    }

    public function forceDelete($user)
    {
        return DB::transaction(function () use($user){
            $deleted = $user->forceDelete();

            if (!$deleted) {
                throw new \Exception('cannot delete user');
            }

            return $deleted;
        });
    }
}
