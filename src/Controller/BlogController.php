<?php

declare(strict_types=1);

namespace TBoileau\FatFreeFramework\Controller;

use DB\SQL;
use DB\SQL\Mapper;

class BlogController
{
    public function home($f3)
    {
        /** @var SQL $db */
        $db = $f3->get('DB');
        $f3->set('posts', $db->exec('SELECT * FROM post'));
        echo \Template::instance()->render('../templates/home.htm');
    }

    public function create($f3)
    {
        /** @var array{title: string, content: string} $post */
        $post = $f3->get('POST.post');

        /** @var SQL $db */
        $db = $f3->get('DB');

        $db->exec('INSERT INTO post(title, content, published_at) VALUES(:title, :content, datetime())', $post);

        $f3->reroute('@blog_home');
    }

    public function update($f3)
    {
        /** @var SQL $db */
        $db = $f3->get('DB');
        $f3->set('post_mapper', new Mapper($db,'post'));
        $f3->get('post_mapper')->load(['id=?', $f3->get('PARAMS.id')]);
        $f3->get('post_mapper')->copyTo('post');

        if ($f3->get('SERVER.REQUEST_METHOD') === 'POST') {
            $f3->get('post_mapper')->copyFrom('POST.post');
            $f3->get('post_mapper')->save();
            $f3->reroute('@blog_home');
            return;
        }

        echo \Template::instance()->render('../templates/update.htm');
    }

    public function delete($f3)
    {
        /** @var SQL $db */
        $db = $f3->get('DB');
        $f3->set('post_mapper', new Mapper($db,'post'));
        $f3->get('post_mapper')->load(['id=?', $f3->get('PARAMS.id')]);
        $f3->get('post_mapper')->erase();
        $f3->reroute('@blog_home');
    }



}
