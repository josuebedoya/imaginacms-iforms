<?php

namespace Modules\Iforms\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class FieldTransformer extends CrudResource
{
  /**
  * Method to merge values with response
  *
  * @return array
  */
  public function modelAttributes($request)
  {

    $data = [
      'typeObject' => $this->when($this->type, $this->present()->type)
    ];

    //simplifying the type value variable
    $fieldType = $this->present()->type["value"] ?? "";

    $vIf = true;
    if(isset($filter->renderLocation) && !empty($filter->renderLocation)){
      if(Str::contains($this->system_type,$filter->renderLocation)){
        if(Str::contains($this->system_type, 'internalHidden'))
          $vIf = false;
      }
    }
    /**
     * creating the dynamic field to the iadmin
     * values correlations
     * type ($fieldType):
     *    ['text', 'textarea', 'number', 'email', 'phone'] => "input"
     *    'file' => 'media'
     *    'selectmultiple' => 'select'
     *    default => $fieldType
     *
     * name ($fieldType):
     *    'file' => 'mediasSingle'
     *    default => $this->name // field name
     *
     * value ($fieldType): // default value
     *    ['selectmultiple','radio'] => []
     *    ['checkbox'] => false
     *
     * props.type ($fieldType):
     *    'phone' => 'tel'
     *    'file' => 'media'
     *    default => $fieldType
     *
     * props.multiple ($fieldType):
     *    'selectmultiple' => true
     *    default => false
     */
    $data['dynamicField'] = [
      'type' => in_array($fieldType, ['text', 'textarea', 'number', 'email', 'phone']) ? 'input' :
        ($fieldType === 'file' ? 'media' :
          ($fieldType == 'selectmultiple' ? 'select' : $fieldType)
        ),
      'name' => $fieldType === 'file' ? "mediasSingle" : $this->name,
      'required' => $this->required ? true : false,
      "value" => in_array($fieldType, ['selectmultiple', 'radio']) ? [] :
        (in_array($fieldType, ['checkbox']) ? false : ""),
      'colClass' => "col-12 col-sm-" . ($field->width ?? '12'),
      'vIf' => $vIf,
      'props' => [
        'label' => $this->label,
        'entity' => $this->options["entity"] ?? "",
        'multiple' => $fieldType === 'selectmultiple' ? true : false
      ]
    ];

    //props type
    $availableTypes = ["number", "email"];
    (in_array($fieldType, $availableTypes)) ? $data['dynamicField']['props']['type'] = $fieldType : false;

    //Options for ['selectmultiple', 'select', 'radio', 'treeSelect'] field types
    if (in_array($fieldType, ['selectmultiple', 'select', 'radio', 'treeSelect'])) {

      // getting the options from the selectable attribute for old sites created with the Iform before Dec, 2021
      $options = json_decode($this->selectable) ?? [];

      //if already exist the loadOptions saved in DB
      if (isset($this->options["loadOptions"]) && !empty($this->options["loadOptions"])) {
        $data['dynamicField']['loadOptions'] = $this->options["loadOptions"];
      }

      //getting the fieldOptions saved in DB for old sites created with the Iform before Dec, 2021
      if (empty($options) && isset($this->options["fieldOptions"]) && !empty($this->options["fieldOptions"])) {

        $data['dynamicField']['props']['options'] = [];

        $options = $this->options["fieldOptions"];
      }

      //Added options in the format label: value, expected for the frontend standard
      foreach ($options as $option) {
        $data['dynamicField']['props']['options'][] = ["label" => $option->name ?? $option, "value" => $option->name ?? $option];
      }

    }

    //Add options for texare
    if ($fieldType == "textarea") {
      $data['dynamicField']['props']['type'] = "textarea";
      $data['dynamicField']['props']['rows'] = 3;
    }


    return $data;
  }
}
