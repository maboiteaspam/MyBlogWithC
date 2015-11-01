<?php
namespace MyBlog;

use C\Form\FormErrorHelper;
use C\HTTP\RequestProxy;
use C\Repository\RepositoryGhoster;
use Silex\Application;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use C\ModernApp\File\Transforms as FileLayout;
use \C\Blog\CommentForm as MyCommentForm;

class Controllers{

    /**
     * name of the repo
     * @var string
     */
    public $entryRepo;

    /**
     * name of the repo
     * @var string
     */
    public $commentRepo;

    public function __construct($entryRepo, $commentRepo) {
        $this->entryRepo = $entryRepo;
        $this->commentRepo = $commentRepo;
    }

    public function home() {
        return function (Application $app, Request $request) {

            $entriesTag
                = new RepositoryGhoster ($app[$this->entryRepo]);
            /* @var $entriesTag     \C\BlogData\Eloquent\EntryRepository */

            $entries
                = new RepositoryGhoster ($app[$this->entryRepo],
                $entriesTag->lastUpdateDate()->first() );
            /* @var $entries        \C\BlogData\Eloquent\EntryRepository */

            $entryCount
                = new RepositoryGhoster ($app[$this->entryRepo]);
            /* @var $entryCount     \C\BlogData\Eloquent\EntryRepository */



            $commentsTag
                = new RepositoryGhoster ($app[$this->commentRepo]);
            /* @var $commentsTag    \C\BlogData\Eloquent\CommentRepository */

            $comments
                = new RepositoryGhoster ($app[$this->commentRepo],
                $commentsTag->lastUpdateDate()->first() );
            /* @var $comments       \C\BlogData\Eloquent\CommentRepository */


            $requestData    = new RequestProxy($app['request']);
            $listEntryBy    = 5;

            $response       = new Response();

            $fileTransform  = $app['layout.file.transform']($app);
            /* @var $fileTransform  \C\ModernApp\File\Transforms */

            $fileTransform
                ->importFile("MyBlog:/home.yml")
                ->updateData('body_content',[
                    'entries'   => $entries->mostRecent ($requestData->get('page'), $listEntryBy)->get()
                ])
                ->updateData('rb_latest_comments',[
                    'comments'  => $comments->mostRecent()->get()
                ])
                ->updateData('blog-entries-pagination', [
                    'count'     => $entryCount->countAll(),
                    'by'        => $listEntryBy,
                ]);;

            return $app['layout.responder']->respond($app['layout'], $request, $response);
        };
    }

    public function detail($postCommentUrl) {
        return function (Application $app, Request $request, $id) use($postCommentUrl) {

            $entry
                = new RepositoryGhoster($app[$this->entryRepo]);
            /* @var $entry                  \C\BlogData\Eloquent\EntryRepository */


            $commentsByEntryTag
                = new RepositoryGhoster($app[$this->commentRepo]);
            /* @var $commentsByEntryTag     \C\BlogData\Eloquent\CommentRepository */

            $commentsByEntry
                = new RepositoryGhoster($app[$this->commentRepo],
                $commentsByEntryTag->lastUpdatedByEntryId($id)->first());
            /* @var $commentsByEntry        \C\BlogData\Eloquent\CommentRepository */


            $mostRecentCommentsTag
                = new RepositoryGhoster($app[$this->commentRepo]);
            /* @var $mostRecentCommentsTag  \C\BlogData\Eloquent\CommentRepository */

            $mostRecentComments
                = new RepositoryGhoster($app[$this->commentRepo],
                $mostRecentCommentsTag->lastUpdatedByEntryId($id)->first());
            /* @var $mostRecentComments     \C\BlogData\Eloquent\CommentRepository */


            $response       = new Response();

            $fileTransform  = $app['layout.file.transform']($app);
            /* @var $fileTransform          \C\ModernApp\File\Transforms */

            $fileTransform
                ->importFile("MyBlog:/detail.yml")

                ->forDevice('desktop')
                ->updateData('body_content',[
                    'entry' => $entry->byId($id)->first()
                ])
                //@todo update form action attr
                ->updateData('blog_detail_comments',[
                    'comments'  => $commentsByEntry->byEntryId($id)->get()
                ])
                ->updateData('rb_latest_comments', [
                    'comments'  => $mostRecentComments->mostRecent([$id])->get()
                ]);

            return $app['layout.responder']->respond($app['layout'], $request, $response);
        };
    }

    public function postComment() {
        return function (Application $app, Request $request, $id) {
            $comment = new MyCommentForm();
            $form = $app['form.factory']
                ->createBuilder($comment)
                ->getForm();

            /* @var $form               \Symfony\Component\Form\Form*/
            $form->handleRequest($request);

            if ($form->isValid()) {
                $data = $form->getData();
                $data['blog_entry_id'] = $id;
                $app[$this->commentRepo]->insert($data);
                return $app->json($data);
            }

            $helper = new FormErrorHelper();
            return json_encode($helper->getFormErrors($form));
        };
    }

    public function formDemo() {
        return function (Application $app, Request $request) {
            $response = new Response();

            FileLayout::transform()
                ->setHelpers($app['modern.layout.helpers'])
                ->setStore($app['modern.layout.store'])
                ->setLayout($app['layout'])
                ->importFile("MyBlog:/formDemo.yml")
            ;

            return $app['layout.responder']->respond($app['layout'], $request, $response);
        };
    }
}
