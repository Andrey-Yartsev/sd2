<?php

class SdPageBlockEditFormAbstract extends Form {

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

  function _update(array $d) {
  }

  function _getDefaultData() {
  }

  function __construct($id, SdPageBlockItems $items) {
    $this->id = $id;
    $this->items = $items;
    $this->item = $this->items->getItemE($id);
    $this->defaultData = $this->_getDefaultData();
    $fields = [
      'text'    => [
        [
          'type' => 'wisiwigSimpleLinks',
          'name' => 'text'
        ]
      ],
      'font'    => [
        [
          'type' => 'textareaTypo',
          'name' => 'text'
        ],
      ],
      'image'   => [
        [
          'type' => 'image',
          'name' => 'image'
        ],
      ],
      'button'  => [
        [
          'title' => 'Текст',
          'type'  => 'text',
          'name'  => 'text'
        ],
        [
          'title' => 'Ссылка',
          'type'  => 'text',
          'name'  => 'link'
        ],
        [
          'title' => 'Цвет текста',
          'type'  => 'color',
          'name'  => 'color'
        ],
        [
          'title' => 'Цвет фона кнопки',
          'type'  => 'color',
          'name'  => 'bgColor'
        ],
        [
          'title' => 'Открывать в новом окне',
          'type'  => 'bool',
          'name'  => 'newWindow'
        ],
      ],
      'auth'    => [
        [
          'title' => 'Текст кнопки регистрации',
          'type'  => 'text',
          'name'  => 'regBtnText'
        ],
        [
          'title' => 'Ссылка для перехода',
          'type'  => 'text',
          'name'  => 'presonalUrl'
        ],
        [
          'title' => 'Текст кнопки перехода',
          'type'  => 'text',
          'name'  => 'presonalBtnText'
        ],
        [
          'title' => 'Цвет текста',
          'type'  => 'color',
          'name'  => 'color'
        ],
        [
          'title' => 'Цвет фона фона кнопки',
          'type'  => 'color',
          'name'  => 'bgColor'
        ],
      ],
      'tpl'     => [
        [
          'title' => 'Имя',
          'type'  => 'name',
          'name'  => 'name'
        ],
        [
          'title' => 'HTML',
          'type'  => 'textarea',
          'name'  => 'html'
        ]
      ],
      'svg'     => [
        ['type' => 'col'],
        [
          'title' => 'Картинка',
          'type'  => 'svgSelect',
          'name'  => 'name'
        ],
        ['type' => 'col'],
        [
          'title' => 'Цвет',
          'type'  => 'color',
          'name'  => 'color'
        ],
        [
          'title'   => 'Размер',
          'name'    => 'size',
          'type'    => 'select',
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
      'menu'    => [
        [
          'title' => 'Расстояние между ячейками',
          'name'  => 'hDistance',
          'help'  => 'по горизонтали',
          'type'  => 'slider',
          'range' => [0, 100]
        ],
        [
          'title' => 'Отступ по горизонтали',
          'name'  => 'hPadding',
          'help'  => 'от текста до границы ячейки',
          'type'  => 'slider',
          'range' => [0, 100]
        ],
        [
          'title' => 'Отступ по вертикали',
          'name'  => 'vPadding',
          'help'  => 'от текста до границы ячейки',
          'type'  => 'slider',
          'steps' => 20,
          'range' => [1, 40]
        ],
        [
          'title' => 'Фон активной ячейки',
          'name'  => 'activeBgColor',
          'type'  => 'color',
        ],
        [
          'title' => 'Фон ячейки при наведении мыши',
          'name'  => 'overBgColor',
          'type'  => 'color',
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
      'gallery' => [
        [
          'title' => 'Картинки',
          'type'  => 'image',
          'multiple' => true,
          'name' => 'images'
        ]
      ]
    ];
    parent::__construct($fields[$this->item['data']['type']]);
    if ($this->item['data']['type'] == 'gallery') {
      UploadTemp::extendFormOptions($this, "/{$this->req->param(0)}/json_updateImages/{$this->req->param(2)}");
    } else {
      UploadTemp::extendFormOptions($this, "/{$this->req->param(0)}/json_updateImage/{$this->req->param(2)}");
    }
  }

}