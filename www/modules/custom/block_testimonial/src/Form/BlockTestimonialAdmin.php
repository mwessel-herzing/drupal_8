<?php

namespace Drupal\block_testimonial\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class BlockTestimonialAdmin.
 */
class BlockTestimonialAdmin extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'block_testimonial.blocktestimonialadmin',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'block_testimonial_admin';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('block_testimonial.blocktestimonialadmin');
    $form['endpoint_path'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Endpoint path'),
      '#description' => $this->t('Enter the URL of the endpoint'),
      '#maxlength' => 255,
      '#size' => 64,
      '#default_value' => $config->get('endpoint_path'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('block_testimonial.blocktestimonialadmin')
      ->set('endpoint_path', $form_state->getValue('endpoint_path'))
      ->save();
  }

}
