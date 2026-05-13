<<<<<<< Updated upstream
<?php

namespace Drupal\basic_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class BasicModuleForm extends FormBase {

  public function getFormId() {
    return 'basic_module_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#required' => TRUE,
    ];

    $form['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('title')) < 3) {
      $form_state->setErrorByName('title', $this->t('The title must be at least 3 characters.'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addMessage($this->t('Saved: @title', ['@title' => $form_state->getValue('title')]));
  }

}
=======
>>>>>>> Stashed changes
