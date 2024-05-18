<?php

namespace App\Repositories\Eloquents;

use App\Models\Post;
use App\Models\UserType;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Eloquents\BaseRepository; 



class PostRepository extends BaseRepository implements PostRepositoryInterface {
    protected Post  $post;

    public function __construct() {
        $this->model = new \App\Models\Post();
    }

   

}
