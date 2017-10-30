<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

if (!isset($GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['type'])) {
    if (file_exists($GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['dynamicConfigFile'])) {
        require_once $GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['dynamicConfigFile'];
    }
    // no type field defined, so we define it here. This will only happen the first time the extension is installed!!
    $GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['type'] = 'tx_extbase_type';
    $tempColumns = [];
    $tempColumns[$GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['type']] = [
        'exclude' => 1,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews.tx_extbase_type',
        'config'  => [
            'type'     => 'select',
            'items'    => [],
            'size'     => 1,
            'maxitems' => 1,
        ],
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news', $tempColumns, 1);
}
// Extension manager configuration
$configuration = \GeorgRinger\News\Utility\EmConfiguration::getSettings();

$tmp_dated_news_columns = [
    'js' => [
        'exclude' => 0,
        'label'   => '',
        'config'  => [
            'type'       => 'user',
            'size'       => '0',
            'userFunc'   => 'FalkRoeder\\DatedNews\\Tca\\Tca->injectJs',
            'parameters' => [
                'color' => 'blue',
            ],
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'application' => [
        'exclude' => 1,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.application',
        'config'  => [
            'type'              => 'inline',
            'foreign_table'     => 'tx_datednews_domain_model_application',
            'MM'                => 'tx_datednews_news_application_mm',
            'maxitems'          => 9999,
            'appearance'        => [
                'collapseAll'                     => 1,
                'levelLinksPosition'              => 'top',
                'showSynchronizationLink'         => 1,
                'showPossibleLocalizationRecords' => 1,
                'useSortable'                     => 1,
                'showAllLocalizationLink'         => 1,
            ],
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'showincalendar' => [
        'exclude' => 0,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.showincalendar',
        'config'  => [
            'type'    => 'check',
            'default' => 0,
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'enable_application' => [
        'exclude' => 0,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.enable_application',
        'config'  => [
            'type'    => 'check',
            'default' => 0,
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'fulltime' => [
        'exclude' => 0,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.fulltime',
        'config'  => [
            'type'    => 'check',
            'default' => 0,
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'eventstart' => [
        'exclude' => 0,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.eventstart',
        'config'  => [
            'type' => 'input',
            'size' => 16,
            'max'  => 20,
            'eval' => 'datetime',
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'eventend' => [
        'exclude' => 0,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.eventend',
        'config'  => [
            'type' => 'input',
            'size' => 16,
            'max'  => 20,
            'eval' => 'datetime',
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'eventlocation' => [
        'exclude' => 0,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.eventlocation',
        'config'  => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim',
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'eventtype' => [
        'exclude' => 0,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.eventtype',
        'config'  => [
            'type'       => 'select',
            'renderType' => 'selectSingle',
            'items'      => [
                ['is not an event', ''],
                ['Event', 'Event'],
                ['Publication Event', 'PublicationEvent'],
                ['Exhibition', 'ExhibitionEvent'],
                ['Visual Arts Event', 'VisualArtsEvent'],
                ['Business Event', 'BusinessEvent'],
                ['Education Event', 'EducationEvent'],
            ],
            'size'     => 1,
            'maxitems' => 1,
        ],
        'onChange' => 'reload',
    ],
    'textcolor' => [
        'exclude' => 0,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.textcolor',
        'config'  => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim',
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'backgroundcolor' => [
        'exclude' => 0,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.backgroundcolor',
        'config'  => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim',
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'targetgroup' => [
        'exclude' => 0,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.targetgroup',
        'config'  => [
            'type' => 'text',
            'cols' => 60,
            'rows' => 5,
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'slots' => [
        'exclude' => 0,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.slots',
        'config'  => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim',
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'price' => [
        'exclude' => 0,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.price',
        'config'  => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim',
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'early_bird_price' => [
        'exclude' => 0,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.early_bird_price',
        'config'  => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim',
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'early_bird_date' => [
        'exclude' => 0,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.early_bird_date',
        'config'  => [
            'type' => 'input',
            'size' => 16,
            'max'  => 20,
            'eval' => 'datetime',
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'locations' => [
        'exclude' => 0,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.locations',
        'config'  => [
            'type'          => 'select',
            'renderType'    => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_datednews_domain_model_location',
            'MM'            => 'tx_datednews_news_location_mm',
            'size'          => 10,
            'autoSizeMax'   => 30,
            'maxitems'      => 9999,
            'multiple'      => 0,
            'wizards'       => [
                '_PADDING'  => 1,
                '_VERTICAL' => 1,
                'edit'      => [
                    'module' => [
                        'name' => 'wizard_edit',
                    ],
                    'type'                     => 'popup',
                    'title'                    => 'Edit',
                    'icon'                     => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_edit.gif',
                    'popup_onlyOpenIfSelected' => 1,
                    'JSopenParams'             => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                ],
                'add' => [
                    'module' => [
                        'name' => 'wizard_add',
                    ],
                    'type'   => 'script',
                    'title'  => 'Create new',
                    'icon'   => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_add.gif',
                    'params' => [
                        'table'    => 'tx_datednews_domain_model_location',
                        'pid'      => '###CURRENT_PID###',
                        'setValue' => 'prepend',
                    ],
                ],
            ],
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'persons' => [
        'exclude' => 1,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.persons',
        'config'  => [
            'type'          => 'select',
            'renderType'    => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_datednews_domain_model_person',
            'MM'            => 'tx_datednews_news_person_mm',
            'size'          => 10,
            'autoSizeMax'   => 30,
            'maxitems'      => 9999,
            'multiple'      => 0,
            'wizards'       => [
                '_PADDING'  => 1,
                '_VERTICAL' => 1,
                'edit'      => [
                    'module' => [
                        'name' => 'wizard_edit',
                    ],
                    'type'                     => 'popup',
                    'title'                    => 'Edit',
                    'icon'                     => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_edit.gif',
                    'popup_onlyOpenIfSelected' => 1,
                    'JSopenParams'             => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                ],
                'add' => [
                    'module' => [
                        'name' => 'wizard_add',
                    ],
                    'type'   => 'script',
                    'title'  => 'Create new',
                    'icon'   => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_add.gif',
                    'params' => [
                        'table'    => 'tx_datednews_domain_model_person',
                        'pid'      => '###CURRENT_PID###',
                        'setValue' => 'prepend',
                    ],
                ],
            ],
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],

    'recurrence' => [
        'exclude' => false,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.recurrence',
        'config'  => [
            'type'       => 'select',
            'renderType' => 'selectSingle',
            'items'      => [
                ['-- none --', 0],
                ['daily', 1],
                ['weekly', 2],
                ['workdays', 3],
                ['every other week', 4],
                ['monthly', 5],
                ['yearly', 6],
                ['user defined', 7],
            ],
            'size'     => 1,
            'maxitems' => 1,
            'eval'     => '',
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'recurrence_type' => [
        'exclude' => false,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.recurrence_type',
        'config'  => [
            'type'       => 'select',
            'renderType' => 'selectSingle',
            'items'      => [
                ['-- choose --', 0],
                ['create events until', 1],
                ['create specific number of events', 2],
            ],
            'size'     => 1,
            'maxitems' => 1,
            'eval'     => '',
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'recurrence_until' => [
        'exclude' => false,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.recurrence_until',
        'config'  => [
            'type'    => 'input',
            'size'    => 16,
            'max'     => 20,
            'eval'    => 'datetime',
            'default' => mktime(date('H'), date('i'), 0, date('m'), date('d'), date('Y')),
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'recurrence_count' => [
        'exclude' => false,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.recurrence_count',
        'config'  => [
            'type'  => 'input',
            'size'  => 10,
            'eval'  => 'trim,int',
            'range' => [
                'lower' => 1,
                'upper' => 365,
            ],
            'default' => 1,
            'slider'  => [
                'step'  => 1,
                'width' => 100,
            ],
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],

    'ud_type' => [
        'exclude' => false,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.ud_type',
        'config'  => [
            'type'       => 'select',
            'renderType' => 'selectSingle',
            'items'      => [
                ['-- choose --', 0],
                ['daily', 1],
                ['weekly', 2],
                ['monthly', 3],
                ['yearly', 4],
            ],
            'size'     => 1,
            'maxitems' => 1,
            'eval'     => '',
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],

    'ud_daily_everycount' => [
        'exclude' => false,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.ud_daily_everycount',
        'config'  => [
            'type'  => 'input',
            'size'  => 4,
            'eval'  => 'int',
            'range' => [
                'lower' => 1,
                'upper' => 364,
            ],
            'default' => 1,
            'slider'  => [
                'step'  => 1,
                'width' => 100,
            ],

        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],

    'ud_weekly_everycount' => [
        'exclude' => false,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.ud_weekly_everycount',
        'config'  => [
            'type'  => 'input',
            'size'  => 4,
            'eval'  => 'int',
            'range' => [
                'lower' => 1,
                'upper' => 51,
            ],
            'default' => 1,
            'slider'  => [
                'step'  => 1,
                'width' => 100,
            ],
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'ud_weekly_weekdays' => [
        'exclude' => false,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.ud_weekly_weekdays',
        'config'  => [
            'type'  => 'check',
            'items' => [
                ['Monday', 0],
                ['Tuesday', 1],
                ['Wednesday', 2],
                ['Thursday', 3],
                ['Friday', 4],
                ['Saturday', 5],
                ['Sunday', 6],
            ],
            'cols' => 'inline',
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],

    'ud_monthly_base' => [
        'exclude' => false,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.ud_monthly_base',
        'config'  => [
            'type'       => 'select',
            'renderType' => 'selectSingle',
            'items'      => [
                ['-- choose --', 0],
                ['per day', 1],
                ['per date', 2],
            ],
            'size'     => 1,
            'maxitems' => 1,
            'eval'     => '',
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'ud_monthly_everycount' => [
        'exclude' => false,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.ud_monthly_everycount',
        'config'  => [
            'type'  => 'input',
            'size'  => 4,
            'eval'  => 'int',
            'range' => [
                'lower' => 1,
                'upper' => 11,
            ],
            'default' => 1,
            'slider'  => [
                'step'  => 1,
                'width' => 100,
            ],
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'ud_monthly_perday' => [
        'exclude' => false,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.ud_monthly_perday',
        'config'  => [
            'type'  => 'check',
            'items' => [
                ['1st', 0],
                ['2nd', 1],
                ['3rd', 2],
                ['4th', 3],
                ['5th', 4],
                ['last', 5],
            ],
            'cols' => 'inline',
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'ud_monthly_perday_weekdays' => [
        'exclude' => false,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.ud_monthly_perday_weekdays',
        'config'  => [
            'type'       => 'select',
            'renderType' => 'selectSingle',
            'items'      => [
                ['Monday', 0],
                ['Tuesday', 1],
                ['Wednesday', 2],
                ['Thursday', 3],
                ['Friday', 4],
                ['Saturday', 5],
                ['Sunday', 6],
            ],
            'size'     => 1,
            'maxitems' => 1,
            'eval'     => '',
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'ud_monthly_perdate_day' => [
        'exclude' => false,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.ud_monthly_perdate_day',
        'config'  => [
            'type'  => 'check',
            'items' => [
                ['1', 1],
                ['2', 2],
                ['3', 3],
                ['4', 4],
                ['5', 5],
                ['6', 6],
                ['7', 7],
                ['8', 8],
                ['9', 9],
                ['10', 10],
                ['11', 11],
                ['12', 12],
                ['13', 13],
                ['14', 14],
                ['15', 15],
                ['16', 16],
                ['17', 17],
                ['18', 18],
                ['19', 19],
                ['20', 20],
                ['21', 21],
                ['22', 22],
                ['23', 23],
                ['24', 24],
                ['25', 25],
                ['26', 26],
                ['27', 27],
                ['28', 28],
                ['29', 29],
                ['30', 30],
                ['31', 31],
            ],
            'cols' => 'inline',
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'ud_monthly_perdate_lastday' => [
        'exclude' => false,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.ud_monthly_perdate_lastday',
        'config'  => [
            'type'  => 'check',
            'items' => [
                ['last day of month', 1],
            ],
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],

    'ud_yearly_everycount' => [
        'exclude' => false,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.ud_yearly_everycount',
        'config'  => [
            'type'  => 'input',
            'size'  => 4,
            'eval'  => 'int',
            'range' => [
                'lower' => 1,
                'upper' => 10,
            ],
            'default' => 1,
            'slider'  => [
                'step'  => 1,
                'width' => 100,
            ],
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'ud_yearly_perday' => [
        'exclude' => false,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.ud_yearly_perday',
        'config'  => [
            'type'  => 'check',
            'items' => [
                ['1st', 0],
                ['2nd', 1],
                ['3rd', 2],
                ['4th', 3],
                ['5th', 4],
                ['last', 5],
                ['every day', 6],
            ],
            'cols' => 'inline',
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'ud_yearly_perday_weekdays' => [
        'exclude' => false,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.ud_yearly_perday_weekdays',
        'config'  => [
            'type'       => 'select',
            'renderType' => 'selectSingle',
            'items'      => [
                ['Monday', 0],
                ['Tuesday', 1],
                ['Wednesday', 2],
                ['Thursday', 3],
                ['Friday', 4],
                ['Saturday', 5],
                ['Sunday', 6],
            ],
            'size'     => 1,
            'maxitems' => 1,
            'eval'     => '',
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],
    'ud_yearly_perday_month' => [
        'exclude' => false,
        'label'   => 'LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.ud_yearly_perday_month',
        'config'  => [
            'type'       => 'select',
            'renderType' => 'selectSingle',
            'items'      => [
                ['January', 1],
                ['February', 2],
                ['March', 3],
                ['April', 4],
                ['May', 5],
                ['June', 6],
                ['Jule', 7],
                ['August', 8],
                ['September', 9],
                ['October', 10],
                ['November', 11],
                ['December', 12],
            ],
            'size'     => 1,
            'maxitems' => 1,
            'eval'     => '',
            'default'  => 1,
        ],
        'displayCond' => 'FIELD:eventtype:REQ:TRUE',
    ],

    'recurrence_updated_behavior' => [
        'exclude' => false,
        'label'   => 'Behavior of building and overriding recurring events. Handle carefully!',
        'config'  => [
            'type'       => 'select',
            'renderType' => 'selectSingle',
            'items'      => [
                ['-- choose --', ''],
                ['do nothing (standard save behavior of TYPO3 records)', 1],
                ['build/overwrite all (existing applications for recurring events will be lost!)', 2],
                ['rebuild all none modified recurring events', 3],
                ['overwrite all fields in all recurring events', 4],
                ['overwrite all fields in none modified recurring events', 5],
                ['overwrite only changed fields in all recurring events', 6],
                ['overwrite only changed fields in none modified recurring events', 7],
            ],
            'size'     => 1,
            'maxitems' => 1,
            'eval'     => 'required',
            'default'  => '',
        ],
    ],

    'newsrecurrence' => [
        'config'  => [
            'type'              => 'inline',
            'foreign_table'     => 'tx_datednews_domain_model_newsrecurrence',
            'MM'                => 'tx_datednews_news_newsrecurrence_mm',
            'foreign_field'     => 'parent_event', //zum anlegen muss es auskommentiert sein, zum anzeigen einkommentiert?
            'foreign_default_sortby'    => 'ORDER BY eventstart DESC',
//            'foreign_sortby'    => 'eventstart',
            'maxitems'          => 9999,
            'appearance'        => [
                'collapseAll'                     => 1,
                'levelLinksPosition'              => 'top',
                'showSynchronizationLink'         => 1,
                'showPossibleLocalizationRecords' => 1,
                'useSortable'                     => 0,
                'showAllLocalizationLink'         => 1,
                'enabledControls'                 => [
                    'info'     => true,
                    'new'      => false,
                    'dragdrop' => true,
                    'sort'     => false,
                    'hide'     => true,
                    'delete'   => false,
                    'localize' => true,
                ],
            ],
        ],
    ],
];
$GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['tx_datednews_general'] = [
    'showitem' => 'showincalendar,enable_application,textcolor,backgroundcolor',
];
$GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['tx_datednews_time'] = [
    'showitem' => 'eventstart,eventend,fulltime',
];
$GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['tx_datednews_slotsprices'] = [
    'showitem' => 'slots,price,early_bird_price,early_bird_date',
];
$GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['tx_datednews_targetgroup'] = [
    'showitem' => 'targetgroup',
];
$GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['tx_datednews_additionals'] = [
    'showitem' => 'locations,persons',
];
$GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['tx_datednews_applications'] = [
    'showitem' => 'application',
];
$GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['tx_datednews_js'] = [
    'showitem' => 'js',
];

$GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['tx_datednews_recurrence'] = [
    'showitem' => 'recurrence,recurrence_type,recurrence_until,recurrence_count',
];
$GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['tx_datednews_recurrence_overrides'] = [
    'showitem' => 'recurrence_updated_behavior,newsrecurrence',
];
$GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['tx_datednews_udtype'] = [
    'showitem' => 'ud_type',
];
$GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['tx_datednews_daily'] = [
    'showitem' => 'ud_daily_everycount',
];
$GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['tx_datednews_weekly'] = [
    'showitem' => 'ud_weekly_everycount,ud_weekly_weekdays',
];
$GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['tx_datednews_monthly'] = [
    'showitem' => 'ud_monthly_base,ud_monthly_everycount,ud_monthly_perday,ud_monthly_perday_weekdays,ud_monthly_perdate_day,ud_monthly_perdate_lastday',
];
$GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['tx_datednews_yearly'] = [
    'showitem' => 'ud_yearly_everycount,ud_yearly_perday,ud_yearly_perday_weekdays,ud_yearly_perday_month',
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news', $tmp_dated_news_columns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_news',
    ',--div--;LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news,
    --palette--;LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.tx_datednews_palette_general;tx_datednews_general,
    --palette--;LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.tx_datednews_palette_time;tx_datednews_time,
    --palette--;LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.tx_datednews_palette_recurrence;tx_datednews_recurrence,
    --palette--;LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.tx_datednews_palette_targetgroup;tx_datednews_targetgroup,
    --palette--;LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.tx_datednews_palette_slotsprices;tx_datednews_slotsprices,
    --palette--;LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.tx_datednews_palette_additionals;tx_datednews_additionals,
    --palette--;LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.tx_datednews_palette_applications;tx_datednews_applications,
    
    ,--div--;LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_recurrences,
    --palette--;LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.tx_datednews_palette_udtype;tx_datednews_udtype,
    --palette--;LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.tx_datednews_palette_daily;tx_datednews_daily,
    --palette--;LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.tx_datednews_palette_weekly;tx_datednews_weekly,
    --palette--;LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.tx_datednews_palette_monthly;tx_datednews_monthly,
    --palette--;LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.tx_datednews_palette_yearly;tx_datednews_yearly,
    --palette--;LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.tx_datednews_palette_yearly;tx_datednews_js,
    
    ,--div--;LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_recurrences_overrides,
    --palette--;LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_datednews_domain_model_news.tx_datednews_recurrence_overrides;tx_datednews_recurrence_overrides,
	'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tx_news_domain_model_news', 'eventtype', '', 'after:istopnews');

//$GLOBALS['TCA']['tx_news_domain_model_news']['columns'][$TCA['tx_news_domain_model_news']['ctrl']['type']]['config']['items'][] = ['LLL:EXT:dated_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_extbase_type.Tx_DatedNews_News','Tx_DatedNews_News'];
//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
//	$_EXTKEY,
//	'tx_news_domain_model_news'
//);

$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['orderByNews'] .= ',eventstart';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_datednews_domain_model_application', 'EXT:dated_news/Resources/Private/Language/locallang_csh_tx_datednews_domain_model_application.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_datednews_domain_model_application');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_datednews_domain_model_location', 'EXT:dated_news/Resources/Private/Language/locallang_csh_tx_datednews_domain_model_location.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_datednews_domain_model_location');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_datednews_domain_model_person', 'EXT:dated_news/Resources/Private/Language/locallang_csh_tx_datednews_domain_model_person.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_datednews_domain_model_person');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    'tt_content.pi_flexform.news_pi1.list',
    'EXT:dated_news/Resources/Private/Language/locallang_csh_flexform_dated_news.xlf'
);
