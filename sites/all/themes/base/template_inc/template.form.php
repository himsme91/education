<?php
  // $Id: template.form.php 14596 2012-02-17 19:05:14Z jmehta $


  /**
   * Overwrite a themed form.
   *
   */
  function  base_form ($element) {
    global $form_has_errors;
    $action = $element['#action'] ? 'action="' . check_url ($element['#action']) . '" ' : '';
    $error_msg = '';
    $form_id = $element['form_id']['#value'];

    if ($form_has_errors[$form_id] === true) {
      //Set a general error message within the form tag.
      $message = filter_xss_admin (variable_get ('ife_general_message', 'Please correct all highlighted errors and try again.'));
      $error_msg = '<p class="notification negative">' . $message . '</p>';
    }
    return '<form ' . $action . ' accept-charset="UTF-8" method="' . $element['#method'] . '" id="' . $element['#id'] . '"' . drupal_attributes ($element['#attributes']) . ">\n" . $error_msg . "\n" . $element['#children'] . "\n</form>\n";
  }


  /**
   * Overwrite a themed form element.
   *
   * We want to only return the form element -- no extra wrappers or labels
   */
  function base_form_element ($element, $value) {

    if (!isset($element['#wrapper'])) $element['#wrapper'] = true;

    if ($element['#wrapper']) {

      // This is also used in the installer, pre-database setup.
      $t = get_t ();

      $wrapper_class = 'form-item';
      if ($element['#wrapper_class']) $wrapper_class .= ' ' . $element["#wrapper_class"];

      $output = '<div class="' . $wrapper_class . '"';
      if (!empty($element['#id'])) {
        $output .= ' id="' . $element['#id'] . '-wrapper"';
      }
      $output .= ">\n";
      $required = !empty($element['#required']) ? '<span class="form-required" title="' . $t('This field is required.') . '"></span>' : '';


      if (!empty($element['#title'])) {

        $title = $element['#title'];
        if (!empty($element['#id'])) {
          $output .= ' <label for="' . $element['#id'] . '">' . $t('!title !required', array('!title'    => filter_xss_admin ($title),
                                                                                             '!required' => $required)) . "</label>\n";
        }
        else {
          $output .= ' <label>' . $t('!title !required', array('!title'    => filter_xss_admin ($title),
                                                               '!required' => $required)) . "</label>\n";
        }

      }

      $output .= " $value\n";

      if (!empty($element['#description'])) {
        $output .= ' <div class="description">' . $element['#description'] . "</div>\n";
      }

      $output .= "</div>\n";

    } else {

      $output = " $value\n";

    }

    check_form_errors ($element);

    return $output;
  }


  /**
   * Check for form error and add to global array if true
   */
  function check_form_errors ($element) {
    global $form_has_errors;

    if ($error_message = form_get_error ($element)) {
      $form_id = $element['#post']['form_id'];
      $form_has_errors[$form_id] = TRUE;
    }

  }


  /**
   * Format a radio button.
   */
  function base_radio ($element) {
    if (!isset($element['#label'])) $element['#label'] = true;

    _form_set_class ($element, array('form-radio'));
    $output = '<input type="radio" ';
    $output .= 'id="' . $element['#id'] . '" ';
    $output .= 'name="' . $element['#name'] . '" ';
    $output .= 'value="' . $element['#return_value'] . '" ';
    $output .= (check_plain ($element['#value']) == $element['#return_value']) ? ' checked="checked" ' : ' ';
    $output .= drupal_attributes ($element['#attributes']) . ' />';
    if (!is_null ($element['#title']) && $element['#label']) {
      $output = '<label class="option" for="' . $element['#id'] . '">' . $output . ' <span class="label-text">' . $element['#title'];
      if (isset($element['#help'])) {
        $output .= '<a class="jqm-tip-trigger help-tip" href="#' . $element['#id'] . '-help"><img src="/sites/all/themes/usgbc/lib/img/help-hint.gif"></a></span>';
        $output .= '<div id="' . $element['#id'] . '-help" class="modal-tip" style="display: none;">';
        $output .= '<p>' . $element['#help'] . '</p>';
        $output .= '</div>';
      } else {
        $output .= '</span>';
      }
      $output .= '</label>';
    }

    unset($element['#title']);
    return theme ('form_element', $element, $output);
  }


  /**
   * Format a checkbox.
   */
  function base_checkbox ($element) {
    if (!isset($element['#label'])) $element['#label'] = true;

    _form_set_class ($element, array('form-checkbox'));
    $output = '<input ';
    $output .= 'type="checkbox" ';
    $output .= 'name="' . $element['#name'] . '" ';
    $output .= 'id="' . $element['#id'] . '" ';
    $output .= 'value="' . $element['#return_value'] . '" ';
    $output .= $element['#value'] ? ' checked="checked" ' : ' ';
    $output .= drupal_attributes ($element['#attributes']) . ' />';

    if (!is_null ($element['#title']) && $element['#label']) {
      $output = '<label class="option" for="' . $element['#id'] . '">' . $output . ' <span class="label-text">' . $element['#title'];
      if (isset($element['#help'])) {
        $output .= '<a class="jqm-tip-trigger help-tip" href="#' . $element['#id'] . '-help"><img src="/sites/all/themes/usgbc/lib/img/help-hint.gif"></a></span>';
        $output .= '<div id="' . $element['#id'] . '-help" class="modal-tip">';
        $output .= '<p>' . $element['#help'] . '</p>';
        $output .= '</div>';
      } else {
        $output .= '</span>';
      }
      $output .= '</label>';
    }

    unset($element['#title']);
    return theme ('form_element', $element, $output);
  }

  /**
   * Format a textfield.
   */
  function base_textfield ($element) {
    $size = empty($element['#size']) ? '' : ' size="' . $element['#size'] . '"';
    $maxlength = empty($element['#maxlength']) ? '' : ' maxlength="' . $element['#maxlength'] . '"';
    $class = array('form-text', 'field');
    $extra = '';
    $output = '';

    if ($element['#autocomplete_path'] && menu_valid_path (array('link_path' => $element['#autocomplete_path']))) {
      drupal_add_js ('misc/autocomplete.js');
      $class[] = 'form-autocomplete';
      $element['#wrapper'] = true;
      $element['#wrapper_class'] = 'form-autocomplete';
      $extra = '<input class="autocomplete" type="hidden" id="' . $element['#id'] . '-autocomplete" value="' . check_url (url ($element['#autocomplete_path'], array('absolute' => TRUE))) . '" disabled="disabled" />';
    }
    _form_set_class ($element, $class);

    if (isset($element['#field_prefix'])) {
      $output .= '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ';
    }

    $output .= '<input type="text"' . $maxlength . ' name="' . $element['#name'] . '" id="' . $element['#id'] . '"' . $size . ' value="' . check_plain ($element['#value']) . '"' . drupal_attributes ($element['#attributes']) . ' />';

    if (isset($element['#field_suffix'])) {
      $output .= ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>';
    }

    return theme ('form_element', $element, $output) . $extra;
  }

  /**
   * Format a textarea.
   */
  function base_textarea ($element) {
    $class = array('form-textarea');

    // Add teaser behavior (must come before resizable)
    if (!empty($element['#teaser'])) {
      drupal_add_js ('misc/teaser.js');
      // Note: arrays are merged in drupal_get_js().
      drupal_add_js (array('teaserCheckbox' => array($element['#id'] => $element['#teaser_checkbox'])), 'setting');
      drupal_add_js (array('teaser' => array($element['#id'] => $element['#teaser'])), 'setting');
      $class[] = 'teaser';
    }

    // Add resizable behavior
    if ($element['#resizable'] !== FALSE) {
      drupal_add_js ('misc/textarea.js');
      $class[] = 'resizable';
    }

    $class[] = 'field';

    _form_set_class ($element, $class);
    return theme ('form_element', $element, '<textarea cols="' . $element['#cols'] . '" rows="' . $element['#rows'] . '" name="' . $element['#name'] . '" id="' . $element['#id'] . '" ' . drupal_attributes ($element['#attributes']) . '>' . check_plain ($element['#value']) . '</textarea>');
  }

  /**
   * Format a password field.
   */
  function base_password ($element) {
    $size = $element['#size'] ? ' size="' . $element['#size'] . '" ' : '';
    $maxlength = $element['#maxlength'] ? ' maxlength="' . $element['#maxlength'] . '" ' : '';
    $class = array('form-text', 'field');

    _form_set_class ($element, $class);
    $output = '<input type="password" name="' . $element['#name'] . '" id="' . $element['#id'] . '" ' . $maxlength . $size . drupal_attributes ($element['#attributes']) . ' />';
    return theme ('form_element', $element, $output);
  }


  /**
   * Theme an individual form element.
   *
   * Combine multiple values into a table with drag-n-drop reordering.
   */
  function base_content_multiple_values($element) {
    $field_name = $element['#field_name'];
    $field = content_fields($field_name);
    $output = '';

    if ($field['multiple'] >= 1) {
      $table_id = $element['#field_name'] .'_values';
      $order_class = $element['#field_name'] .'-delta-order';
      $required = !empty($element['#required']) ? '<span class="form-required" title="'. t('This field is required.') .'">*</span>' : '';

      $header = array(
        array(
          'data' => t('!title !required', array('!title' => $element['#title'], '!required' => $required)),
          'colspan' => 2
        ),
        t('Order'),
      );
      $rows = array();

      // Sort items according to '_weight' (needed when the form comes back after
      // preview or failed validation)
      $items = array();
      foreach (element_children($element) as $key) {
        if ($key !== $element['#field_name'] .'_add_more') {
          $items[] = &$element[$key];
        }
      }
      usort($items, '_content_sort_items_value_helper');

      // Add the items as table rows.
      foreach ($items as $key => $item) {
        $item['_weight']['#attributes']['class'] = $order_class;
        $delta_element = drupal_render($item['_weight']);
        $cells = array(
          array('data' => '', 'class' => 'content-multiple-drag'),
          drupal_render($item),
          array('data' => $delta_element, 'class' => 'delta-order'),
        );
        $rows[] = array(
          'data' => $cells,
          'class' => 'draggable',
        );
      }

      $output .= theme('table', $header, $rows, array('id' => $table_id, 'class' => 'content-multiple-table'));
      $output .= $element['#description'] ? '<div class="description">'. $element['#description'] .'</div>' : '';
      $output .= drupal_render($element[$element['#field_name'] .'_add_more']);

      drupal_add_tabledrag($table_id, 'order', 'sibling', $order_class);
    }
    else {
      foreach (element_children($element) as $key) {
        $output .= drupal_render($element[$key]);
      }
    }

    return $output;
  }

  /**
   * Return a themed Hierarchical Select form element.
   *
   */
  function base_hierarchical_select_form_element($element, $value) {
    $output = '<div class="form-item hierarchical-select-wrapper-wrapper"';
    if (!empty($element['#id'])) {
      $output .= ' id="'. $element['#id'] .'-wrapper"';
    }
    $output .= ">\n";
    $required = !empty($element['#required']) ? '<span class="form-required" title="'. t('This field is required.') .'">*</span>' : '';

    if (!empty($element['#title'])) {
      $title = $element['#title'];
      if (!empty($element['#id'])) {
        $output .= ' <label for="'. $element['#id'] .'">'. t('!title !required', array('!title' => filter_xss_admin($title), '!required' => $required)) ."</label>\n";
      }
      else {
        $output .= ' <label>'. t('!title !required', array('!title' => filter_xss_admin($title), '!required' => $required)) ."</label>\n";
      }
    }

    $output .= " $value\n";

    if (!empty($element['#description'])) {
      $output .= ' <div class="description">'. $element['#description'] ."</div>\n";
    }

    $output .= "</div>\n";

    return $output;
  }
