<?php

return [
    'name' => 'Iforms',
    /*
|--------------------------------------------------------------------------
| Define label of the required fields
|--------------------------------------------------------------------------
*/
    'requiredFieldLabel' => ' * ',

    /*
|--------------------------------------------------------------------------
| Define all the exportable available
|--------------------------------------------------------------------------
*/
    'exportable' => [
    "leads" => [
      'moduleName' => "Iforms",
      'exportName' => "LeadsPerFormExport",
      'fileName' => "Leads",
            'exportFields' => [
        "formId" => [
          "value" => null,
          "type" => 'select',
          "required" => true,
          "props" => [
            "label" => 'Formulario*',
                    ],
          "loadOptions" => [
            "apiRoute" => 'apiRoutes.qform.forms',
            "select" => ["label" => 'title', "id" => 'id'],
          ]
        ]
      ]
            //'repositoryName' => "UserApiRepository",
            //'fields' => ['id', 'first_name', 'last_name', 'email', 'last_login', 'created_at', 'updated_at'],
            //'headings' => ['id', 'Nombre', 'Apellido', 'Email', 'Fecha Ultima Sesión', 'Fecha de Creación', 'Fecha Ultima Actualización']
        ],
        'leadsItem' => [
            'moduleName' => 'Iforms',
            'exportName' => "LeadsItemFormExport",
            'fileName' => 'Leads-item',
            'fileType' => 'pdf',
            'content' => 'iforms::pdf.leadItem', // to customize use the crud-field customLeadPDFTemplate
            'repositoryName' => 'LeadRepository',
            //"layout" => "custom.layout.pdf",
            //'fields' => ['id', 'first_name', 'last_name', 'email', 'last_login', 'created_at', 'updated_at'],
            //'headings' => ['id', 'Nombre', 'Apellido', 'Email', 'Fecha Ultima Sesión', 'Fecha de Creación', 'Fecha Ultima Actualización']
        ],

    ],

    /*Translate keys of each entity. Based on the permission string*/
    'documentation' => [
        'forms' => 'iforms::cms.documentation.forms',
        'leads' => 'iforms::cms.documentation.leads',
    ],
];
