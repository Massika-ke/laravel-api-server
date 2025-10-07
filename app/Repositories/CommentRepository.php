<?

namespace App\Repositories;

use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class CommentRepository extends BaseRepository
{
    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes){

            $created = Comment::query()->create([
                'body' => data_get($attributes, 'body'),
            ]);

            if ($userIds = data_get($attributes, 'user_ids')) {
                $created->users()->sync($userIds);
            }
            return $created;
        });
    }

    public function update($comment, array $attributes)
    {
        return DB::transaction(function () use($comment, $attributes)
        {
            $updated = $comment->update([
                'body' => data_get($attributes, 'body', $comment->body),
            ]);

            if(!$updated){
                throw new \Exception('Failed to update comment');
            }

            if ($userIds = data_get($attributes, 'user_ids')) {
                $comment->users()->sync($userIds);
            }

            return $comment;
        });
    }

    public function forceDelete($comment)
    {
        return DB::transaction(function () use($comment){
            $deleted = $comment->forceDelete();

            if (!$deleted) {
                throw new \Exception('cannot delete comment');
            }

            return $deleted;
        });
    }
}
