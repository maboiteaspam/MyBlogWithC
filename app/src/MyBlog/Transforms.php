<?php
namespace MyBlog;

use C\Layout\Transforms\Transforms as BaseTransforms;
use Silex\Application;
use Symfony\Component\Routing\Generator\UrlGenerator;

/**
 * Class Transforms
 *
 * @package MyBlog
 */
class Transforms extends BaseTransforms{

  /**
   * @return Transforms
   */
  public static function transform(){
    return new self();
  }

  /**
   * @var UrlGenerator
   */
  protected $generator;

  /**
   * @param UrlGenerator $generator
   * @return $this
   */
  public function setGenerator (UrlGenerator $generator) {
    $this->generator = $generator;
    return $this;
  }

  public function updateFormRoute ($blockId, $formName, $route, $params=[]) {
    $block = $this->getLayout()->get($blockId);
    $form = $block->getRawData($formName);
    /* @var $form \C\Form\FormBuilder */
    if ($form) {
      $form->getForm()->setAction(
        $this->generator->generate($route, $params)
      );
    }
    return $this;
  }

  public function updateFormAction ($blockId, $formActions) {
    $block = $this->getLayout()->get($blockId);
    foreach ($formActions as $formName => $action) {
      $form = $block->getRawData($formName);
      /* @var $form \C\Form\FormBuilder */
      if ($form) {
        $form->getForm()->setAction($action);
      }
    }
    return $this;
  }

}
