<?php

namespace Drupal\my_bo\Plugin\Action;

use Drupal\Core\Action\ActionBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Push term in front.
 *
 * @Action(
 *   id = "term_push_front",
 *   label = @Translation("Push term in front"),
 *   type = "taxonomy_term"
 * )
 */
class TermPushFront extends ActionBase {

  /**
   * {@inheritdoc}
   */
  public function execute($entity = NULL) {
    /** @var \Drupal\taxonomy\TermInterface $entity */
    if ($entity->hasField('field_push')) {
      $entity->field_push->value = 1;
      $entity->save();
    }

  }

  /**
   * {@inheritdoc}
   */
  public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    /** @var \Drupal\taxonomy\TermInterface $object */
    $result = $object->access('update', $account, TRUE)
      ->andIf($object->field_push->access('edit', $account, TRUE));

    return $return_as_object ? $result : $result->isAllowed();
  }

}
