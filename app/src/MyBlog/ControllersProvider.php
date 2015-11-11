<?php
namespace MyBlog;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\ControllerProviderInterface;

class ControllersProvider implements
    ServiceProviderInterface,
    ControllerProviderInterface
{
    /**
     *
     * @param Application $app
     **/
    public function register(Application $app)
    {
        $app['myblog.controllers'] = $app->share(function() use ($app) {
            $controllers = new Controllers('blogdata.entry', 'blogdata.comment');
            return $controllers;
        });
    }
    /**
     *
     * @param Application $app Silex application instance.
     * @return void
     **/
    public function boot(Application $app)
    {
        if (isset($app['assets.fs'])) {
            $app['assets.fs']->register(__DIR__.'/assets/', 'MyBlog');
        }
        if (isset($app['intl.fs'])) {
            $app['intl.fs']->register(__DIR__.'/intl/', 'MyBlog');
        }
        if (isset($app['layout.fs'])) {
            $app['layout.fs']->register(__DIR__.'/templates/', 'MyBlog');
        }
        if (isset($app['modern.fs'])) {
            $app['modern.fs']->register(__DIR__.'/layouts/', 'MyBlog');
        }
        if (isset($app['forms.fs'])) {
            $app['forms.fs']->register(__DIR__.'/forms/', 'MyBlog');
        }
    }

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $blogController = $app['myblog.controllers'];
        /* @var $blogController Controllers */

        $controllers->get( '/',
            $blogController->home())
            ->bind ('home');

        $controllers
            ->get( '/blog/{id}',
                $blogController->detail(
                    $postCommentUrl = 'blog_entry.add_comment',
                    $postCommentUrlParams=['id'] ))
            ->bind ('blog_entry');

        $controllers
            ->get( '/blog/{id}/blog_detail_comments',
                $blogController->detail(
                    $postCommentUrl = 'blog_entry.add_comment',
                    $postCommentUrlParams=['id'] ))
            ->bind ('blog_entry.detail_comments');

        $controllers
            ->post( '/blog/{id}/add_comment',
                $blogController->postComment())
            ->bind ('blog_entry.add_comment');

        $controllers
            ->get( '/formDemo',
                $blogController->formDemo())
            ->bind ('form.demo');

        return $controllers;
    }
}