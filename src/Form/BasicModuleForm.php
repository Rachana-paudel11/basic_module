<?php

namespace Drupal\basic_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class BasicModuleForm extends FormBase {

  public function getFormId() {
    return 'basic_module_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    // Title field
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#required' => TRUE,
    ];

    // Description field
    $form['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#required' => TRUE,
    ];

    // Submit button
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {

    if (strlen($form_state->getValue('title')) < 3) {
      $form_state->setErrorByName('title', $this->t('Title must be at least 3 characters.'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    // Get database connection
    $connection = Database::getConnection();

    // Insert data into database
    $connection->insert('basic_module_data')
      ->fields([
        'title' => $form_state->getValue('title'),
        'description' => $form_state->getValue('description'),
      ])
      ->execute();

    // Success message
    $this->messenger()->addMessage(
      $this->t('Data saved successfully for: @title', [
        '@title' => $form_state->getValue('title')
      ])
    );
  }
}