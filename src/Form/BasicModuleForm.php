<?php

namespace Drupal\basic_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\file\Entity\File;

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

    //Image Field
    $form['image'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Add an image'),
      '#required' => TRUE,
      '#description' => $this->t('Please upload a JPG, PNG, or GIF image. Maximum size: 2 MB.'),
      '#upload_location' => "public://documents",
      '#upload_validators' => [
        'FileExtension' => ['extensions' => 'png jpg jpeg gif'],
        'FileSizeLimit' => ['fileLimit' => 2 * 1024 * 1024],
      ],

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
    // Get uploaded file ID
    $image_id = $form_state->getValue('image')[0];
    if($image_id){
      //Load file entity
      $file = File::load($image_id);

      //Make file Permanent
      $file->setPermanent();
      $file->save();
      // Get database connection
      $connection = Database::getConnection();

      // Insert data into database
      $connection->insert('basic_module_data')
          ->fields([
            'title' => $form_state->getValue('title'),
            'description' => $form_state->getValue('description'),
            'image' => $image_id
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
    
}