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

    $form['vertical_tabs'] = [
      '#type'  => 'vertical_tabs',
    ];

    $form[ 'access_fields' ] = array(
      '#type'        => 'details',
      '#title'       => t( 'API Access' ),
      '#description' => '<p>' . t( 'Determine how the block will access the Testimonial API endpoints' ) . '</p>',
      '#group'       => 'vertical_tabs',
    );

      $form[ 'access_fields' ][ 'site_url' ] = array(
        '#type'          => 'textfield',
        '#title'         => t( 'Testimonial API site URL' ),
        '#description'   => t( 'Enter the URL of the site hosting the Testimonial API' ),
        '#default_value' => $config->get( 'site_url') ?? "https://www.herzing.edu",
        '#size'          => 200,
        '#maxlength'     => 200,
        '#required'      => TRUE,
      );

      $form[ 'access_fields' ][ 'site_path' ] = array(
        '#type'          => 'textfield',
        '#title'         => t( 'Testimonial API site path' ),
        '#description'   => t( 'The path to the Testimonial endpoint root' ),
        '#default_value' => $config->get( 'site_path') ?? "api/get/testimonials",
        '#size'          => 200,
        '#maxlength'     => 200,
        '#required'      => TRUE,
      );

    $form[ 'filter_fields' ] = array(
      '#type'        => 'details',
      '#title'       => t( 'Filter Fields' ),
      '#description' => '<p>' . t( 'Map node fields to campus filters' ) . '</p>',
      '#group'       => 'vertical_tabs',
    );

      $form[ 'filter_fields' ][ 'campus_filter' ] = array(
        '#type'          => 'textfield',
        '#title'         => t( 'Campus filter' ),
        '#description'   => t( 'The machine name of the field that will be used to filter testimonials by campus' ),
        '#default_value' => $config->get( 'campus_filter') ?? "",
        '#size'          => 64,
        '#maxlength'     => 200,
        '#required'      => false,
      );

      $form[ 'filter_fields' ][ 'campus_filter' ] = array(
        '#type'          => 'textfield',
        '#title'         => t( 'Campus filter' ),
        '#description'   => t( 'The machine name of the field that will be used to filter testimonials by campus' ),
        '#default_value' => $config->get( 'campus_filter') ?? "",
        '#size'          => 64,
        '#maxlength'     => 200,
        '#required'      => false,
      );

      $form[ 'filter_fields' ][ 'area_filter' ] = array(
        '#type'          => 'textfield',
        '#title'         => t( 'Area filter' ),
        '#description'   => t( 'The machine name of the field that will be used to filter testimonials by area' ),
        '#default_value' => $config->get( 'area_filter') ?? "",
        '#size'          => 64,
        '#maxlength'     => 200,
        '#required'      => false,
      );

      $form[ 'filter_fields' ][ 'program_filter' ] = array(
        '#type'          => 'textfield',
        '#title'         => t( 'Program filter' ),
        '#description'   => t( 'The machine name of the field that will be used to filter testimonials by program or degree' ),
        '#default_value' => $config->get( 'program_filter') ?? "",
        '#size'          => 64,
        '#maxlength'     => 200,
        '#required'      => false,
      );

    $form[ 'admin_fields' ] = array(
      '#type'        => 'details',
      '#title'       => t( 'Administration' ),
      '#description' => '<p>' . t( 'Determine how Block Testimonial will interact with the rest of Drupal' ) . '</p>',
      '#group'       => 'vertical_tabs',
    );

      $form[ 'admin_fields' ][ 'log_calls' ] = array(
        '#type'          => 'checkbox',
        '#title'         => t( 'Log calls to API endpoints' ),
        '#description'   => t( 'Writes an entry into the Drupal Log whenever the Testimonial API is accessed using this module.<br>Note that this could result in a large number of log entries and should only be used for diagnostics' ),
        '#default_value' => $config->get( 'log_calls') ?? 0,
        '#return_value'  => 1,
        '#required'      => false,
      );

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

    $trim_mask = " \t\n\r\0\x0B\\/";

    $this->config('block_testimonial.blocktestimonialadmin')
      ->set('site_url', trim( $form_state->getValue('site_url'), $trim_mask ) )
      ->set('site_path', trim( $form_state->getValue('site_path'), $trim_mask ) )
      ->set('log_calls', trim( $form_state->getValue('log_calls'), $trim_mask ) )
      ->set('campus_filter', trim( $form_state->getValue('campus_filter'), $trim_mask ) )
      ->set('area_filter', trim( $form_state->getValue('area_filter'), $trim_mask ) )
      ->set('program_filter', trim( $form_state->getValue('program_filter'), $trim_mask ) )
      ->save();
  }

}
