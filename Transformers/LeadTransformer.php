<?php

namespace Modules\Iforms\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class LeadTransformer extends CrudResource
{
  /**
   * Method to merge values with response
   *
   * @return array
   */
  public function modelAttributes($request)
  {


    $form = $this->form;
    $fields = $form->fields ?? [];

    $data = ["values" => []];
    foreach ($fields as $field) {
      if ($field->type == 12) { //FILE
        $data["values"][$field->name] = url($this->values[$field->name] ?? '');
      }else $data["values"][$field->name] = $this->values[$field->name] ?? '';
    }

    return $data;

  }
}
