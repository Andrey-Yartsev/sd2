<?php

class SdPageBlockEditForm extends Form {

  /**
   * @var ConfigItems
   */
  protected $items;

  /**
   * @var integer
   */
  protected $id;

  /**
   * @var array
   */
  protected $item;

  protected $ownPageId;

  function __construct($id, SdPageBlockItems $items) {
    $this->id = $id;
    $this->items = $items;
    $this->item = $this->items->getItemE($id);
    if (!empty($this->item['content'])) $this->defaultData = $this->item['content'];
    $fields = [
      'text'  => [
        [
          'type' => 'wisiwigSimple2',
          'name' => 'text'
        ]
      ],
      'font'  => [
        [
          'type' => 'textareaTypo',
          'name' => 'text'
        ],
      ],
      'image' => [
        [
          'type' => 'image',
          'name' => 'image'
        ],
      ],
      'button' => [
        [
          'title' => 'Текст',
          'type' => 'text',
          'name' => 'text'
        ],
        [
          'title' => 'Ссылка',
          'type' => 'text',
          'name' => 'link'
        ],
        [
          'title' => 'Цвет текста',
          'type' => 'color',
          'name' => 'color'
        ],
        [
          'title' => 'Цвет фона кнопки',
          'type' => 'color',
          'name' => 'bgColor'
        ],
        [
          'title' => 'Открывать в новом окне',
          'type' => 'bool',
          'name' => 'newWindow'
        ],
      ],
      'auth' => [
        [
          'title' => 'Текст кнопки регистрации',
          'type' => 'text',
          'name' => 'regBtnText'
        ],
        [
          'title' => 'Ссылка для перехода',
          'type' => 'text',
          'name' => 'presonalUrl'
        ],
        [
          'title' => 'Текст кнопки перехода',
          'type' => 'text',
          'name' => 'presonalBtnText'
        ],
        [
          'title' => 'Цвет текста',
          'type' => 'color',
          'name' => 'color'
        ],
        [
          'title' => 'Цвет фона фона кнопки',
          'type' => 'color',
          'name' => 'bgColor'
        ],
      ],
      'tpl' => [
        [
          'title' => 'Имя',
          'type' => 'name',
          'name' => 'name'
        ],
        [
          'title' => 'HTML',
          'type' => 'textarea',
          'name' => 'html'
        ]
      ],
      'svg' => [
        ['type' => 'col'],
        [
          'title' => 'Картинка',
          'type' => 'svgSelect',
          'name' => 'name'
        ],
        ['type' => 'col'],
        [
          'title' => 'Цвет',
          'type' => 'color',
          'name' => 'color'
        ],
        [
          'title' => 'Размер',
          'name' => 'size',
          'type' => 'select',
          'options' => [
            30,
            50,
            80,
            120,
            200,
            300
          ]
        ],
      ],
      'menu' => [
        [
          'title' => 'Ширина ячейки',
          'name' => 'itemWidth',
          'type' => 'pixels'
        ],
        [
          'title' => 'Высота ячейки',
          'name' => 'itemHeight',
          'type' => 'pixels'
        ],
        /*
        [
          'type' => 'fieldSet',
          'name' => 'menu',
          'fields' => [
            [
              'title' => 'Текст ссылки',
              'name' => 'title'
            ],
            [
              'title' => 'Ссылка',
              'name' => 'link'
            ],
            [
              'title' => 'В новом окне',
              'name' => 'newWindow',
              'type' => 'boolCheckbox'
            ],
          ]
        ],
        */
      ],
    ];
    parent::__construct($fields[$this->item['data']['type']]);
    UploadTemp::extendFormOptions($this, "/{$this->req->param(0)}/json_updateImage/{$this->req->param(2)}");
  }

  function _update(array $d) {
    //prr([$this->req->r, $d]);
    $this->items->updateContent($this->id, $d);
  }

}