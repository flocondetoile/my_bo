<?php

namespace Drupal\my_bo\Plugin\Action;

use Drupal\Core\Action\ActionBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Unpush term from front.
 *
 * @Action(
 *   id = "term_unpush_front",
 *   label = @Translation("Unpush term from front"),
 *   type = "taxonomy_term"
 * )
 */
class TermUnpushFront extends ActionBase {

  /**
   * {@inheritdoc}
   */
  public function execute($entity = NULL) {
    /** @var \Drupal\taxonomy\TermInterface $entity */
    if ($entity->hasField('field_push')) {
      $entity->field_push->value = 0;
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
