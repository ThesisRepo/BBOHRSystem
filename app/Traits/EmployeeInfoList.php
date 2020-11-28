<?php
namespace App\Traits;
use Hash;

trait EmployeeInfoList
{
  public function employee_info_list() {
    return  [
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Shin',
            'last_name' => 'Shan',
            'email' => 'marionjay.balugo@student.passerellesnumeriques.org',
            'password' => Hash::make('123456789')
          ],
          'user_info' => null,
          // 'user_info' => [
          //   'department_id' => 2,
          //   'shift_time_id'=> 1,
          //   'gender'=> 1,
          //   'company_number'=> '1234652',
          //   // 'profile_url'=> null
          //   // 'company_position'=> 'Customer Support Leader',
          //   'date_hired'=> '2018-3-6',
          //   // 'contact_number'=> 
          //   'civil_status_id'=> 1,
          //   'company_status_id'=> '3',
          //   'birthday'=>'1984-4-13',
          //   'address'=> 'Sta. Cruz, Liloan, Cebu',
          //   // 'tin_number'=> 
          //   // 'sss_number'=>
          //   // 'pag_ibig_number'=>
          //   // 'philhealth_number'=>
          //   // 'allowed_leave_number'=>
          // ],
          'user_roles' => [1, 2, 5],
          'user_company_positions' => null,
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]
          // 'user_company_positions' => [15]
        ],
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Fenella',
            'last_name' => 'Corrine',
            'email' => 'Fenella@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => null,
          // 'user_info' => [
          //   'department_id' => 2,
          //   'shift_time_id'=> 1,
          //   'gender'=> 1,
          //   'company_number'=> '1234652',
          //   // 'profile_url'=> null
          //   // 'company_position'=> 'Customer Support Leader',
          //   'date_hired'=> '2018-3-6',
          //   // 'contact_number'=> 
          //   'civil_status_id'=> 1,
          //   'company_status_id'=> '3',
          //   'birthday'=>'1984-4-13',
          //   'address'=> 'Sta. Cruz, Liloan, Cebu',
          //   // 'tin_number'=> 
          //   // 'sss_number'=>
          //   // 'pag_ibig_number'=>
          //   // 'philhealth_number'=>
          //   // 'allowed_leave_number'=>
          // ],
          'user_roles' => [1, 2, 4],
          'user_company_positions' => null,
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]
          // 'user_company_positions' => [15]
        ],
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Claire',
            'last_name' => 'khan',
            'email' => 'balugomarionjay@gmail.com',
            'password' => Hash::make('123456789')
          ],
          'user_info' => null,
          // 'user_info' => [
          //   'department_id' => 2,
          //   'shift_time_id'=> 1,
          //   'gender'=> 1,
          //   'company_number'=> '1234652',
          //   // 'profile_url'=> null
          //   // 'company_position'=> 'Customer Support Leader',
          //   'date_hired'=> '2018-3-6',
          //   // 'contact_number'=> 
          //   'civil_status_id'=> 1,
          //   'company_status_id'=> 3,
          //   'birthday'=>'1984-4-13',
          //   'address'=> 'Sta. Cruz, Liloan, Cebu',
          //   // 'tin_number'=> 
          //   // 'sss_number'=>
          //   // 'pag_ibig_number'=>
          //   // 'philhealth_number'=>
          //   // 'allowed_leave_number'=>
          // ],
          'user_roles' => [1,2,3],
          'user_company_positions' => null,
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]

          // 'user_company_positions' => [15]
        ],
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Cielo Fe Sasing',
            'last_name' => 'Atis',
            'email' => 'Cielofe@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 1,
            'shift_time_id'=> 1,
            'gender'=> 1,
            'company_number'=> '1234652',
            // 'profile_url'=> null
            // 'company_position'=> 'Customer Support Leader',
            'date_hired'=> '2018-3-6',
            // 'contact_number'=> 
            'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sta. Cruz, Liloan, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            // 'allowed_leave_number'=>
          ],
          'user_roles' => [1,2],
          'user_company_positions' => [15],
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]
        ],
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Gerard Winston Villegas',
            'last_name' => 'Hamoy',
            'email' => 'GerardHamoy@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 4,
            'shift_time_id'=> 1,
            'gender'=> 0,
            'company_number'=> '1236652',
            // 'profile_url'=> null
            // 'company_position'=> 'Apps Developer', 
            'date_hired'=> '2018-3-6',
            // 'contact_number'=> 
            'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sta. Cruz, Liloan, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            // 'allowed_leave_number'=>
          ],
          'user_roles' => [1,2],
          'user_company_positions' => [11],
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]
        ],
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Brisbane Jr Real',
            'last_name' => 'Bacalla',
            'email' => 'BrisbaneBacalla@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 5,
            'shift_time_id'=> 1,
            'gender'=> 0,
            'company_number'=> '1236652',
            // 'profile_url'=> null
            // 'company_position'=> 'PHP DEV',
            'date_hired'=> '2018-3-6',
            // 'contact_number'=> 
            'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sta. Cruz, Liloan, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            // 'allowed_leave_number'=>
          ],
          'user_roles' => [1,2],
          'user_company_positions' => [2],
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]
        ],
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Dianen',
            'last_name' => 'Gemarino',
            'email' => 'DianenGemarino@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 1,
            'shift_time_id'=> 1,
            'gender'=> 0,
            'company_number'=> '1236652',
            // 'profile_url'=> null
            // 'company_position'=> 'MKTG. Assistant',
            'date_hired'=> '2018-3-6',
            // 'contact_number'=> 
            'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sta. Cruz, Liloan, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            // 'allowed_leave_number'=>
          ],
          'user_roles' => [1],
          'user_company_positions' => [13],
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]
        ],
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Nina Rose Autida',
            'last_name' => 'Lapiz',
            'email' => 'NinaLapiz@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 1,
            'shift_time_id'=> 1,
            'gender'=> 0,
            'company_number'=> '1236652',
            // 'profile_url'=> null
            // 'company_position'=> 'Sales & Support',
            'date_hired'=> '2018-3-6',
            // 'contact_number'=> 
            'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sta. Cruz, Liloan, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            // 'allowed_leave_number'=>
          ],
          'user_roles' => [1],
          'user_company_positions' => [12],
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]
        ],
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Jocel Redotco',
            'last_name' => 'Mendoza',
            'email' => 'JocelMendoza@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 1,
            'shift_time_id'=> 1,
            'gender'=> 0,
            'company_number'=> '1236652',
            // 'profile_url'=> null
            // 'company_position'=> 'Online Sales Associate',
            'date_hired'=> '2018-3-6',
            // 'contact_number'=> 
            'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sta. Cruz, Liloan, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            // 'allowed_leave_number'=>
          ],
          'user_roles' => [1],
          'user_company_positions' => [10],
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]

        ],   
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Jake Ellema',
            'last_name' => 'Sasing',
            'email' => 'JakeSasing@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 1,
            'shift_time_id'=> 1,
            'gender'=> 0,
            'company_number'=> '1236652',
            // 'profile_url'=> null
            // 'company_position'=> 'Utility/Messenger',
            'date_hired'=> '2018-3-6',
            // 'contact_number'=> 
            'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sta. Cruz, Liloan, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            // 'allowed_leave_number'=>
          ],
          'user_roles' => [1],
          'user_company_positions' => [4],
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]
        ],
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Mary Diane',
            'last_name' => 'Salasayo',
            'email' => 'MarySalasayo@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 1,
            'shift_time_id'=> 1,
            'gender'=> 0,
            'company_number'=> '1236652',
            // 'profile_url'=> null
            // 'company_position'=> 'Marketng Staff',
            'date_hired'=> '2018-3-6',
            // 'contact_number'=> 
            'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sta. Cruz, Liloan, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            // 'allowed_leave_number'=>
          ],
          'user_roles' => [1],
          'user_company_positions' => [1],
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]
        ],
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Pretty Jean Mission',
            'last_name' => 'Salut',
            'email' => 'PrettySalut@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 3,
            'shift_time_id'=> 1,
            'gender'=> 0,
            'company_number'=> '1236652',
            // 'profile_url'=> null
            // 'company_position'=> 'Accounting Assistant',
            'date_hired'=> '2018-3-6',
            // 'contact_number'=> 
            'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sta. Cruz, Liloan, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            // 'allowed_leave_number'=>
          ],
          'user_roles' => [1],
          'user_company_positions' => [5],
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]
        ],
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Elbert Estardo',
            'last_name' => 'Luta',
            'email' => 'ElbertLuta@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 4,
            'shift_time_id'=> 1,
            'gender'=> 0,
            'company_number'=> '1236652',
            // 'profile_url'=> null
            // 'company_position'=> 'App Developer',
            'date_hired'=> '2018-3-6',
            // 'contact_number'=> ,
            'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sta. Cruz, Liloan, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            // 'allowed_leave_number'=>
          ],
          'user_roles' => [1],
          'user_company_positions' => [11],
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]
        ],
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Joy Marie Lupague',
            'last_name' => 'Navales',
            'email' => 'JoyNavales@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 4,
            'shift_time_id'=> 1,
            'gender'=> 0,
            'company_number'=> '1236652',
            // 'profile_url'=> null
            // 'company_position'=> 'Android Dev',
            'date_hired'=> '2018-3-6',
            // 'contact_number'=> 
            'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sta. Cruz, Liloan, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            // 'allowed_leave_number'=>
          ],
          'user_roles' => [1],
          'user_company_positions' => [3],
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]
        ],
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Nathaniel Cala',
            'last_name' => 'Terdes',
            'email' => 'NathanielTerdes@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 4,
            'shift_time_id'=> 1,
            'gender'=> 0,
            'company_number'=> '1236652',
            // 'profile_url'=> null
            // 'company_position'=> 'Android Dev',
            'date_hired'=> '2018-3-6',
            // 'contact_number'=> 
            'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sta. Cruz, Liloan, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            // 'allowed_leave_number'=>
          ],
          'user_roles' => [1],
          'user_company_positions' => [3],
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]
        ],
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Burt Karl Jusayan',
            'last_name' => 'Cabigas',
            'email' => 'BurtCabigas@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 5,
            'shift_time_id'=> 1,
            'gender'=> 0,
            'company_number'=> '1236652',
            // 'profile_url'=> null,
            // 'company_position'=> 'PHP DEV',
            'date_hired'=> '2018-3-6',
            // 'contact_number'=> 
            'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sta. Cruz, Liloan, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            // 'allowed_leave_number'=>
          ],
          'user_roles' => [1],
          'user_company_positions' => [2],
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]
        ],
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Fellow James',
            'last_name' => 'Camporaso',
            'email' => 'FellowCamporaso@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 5,
            'shift_time_id'=> 1,
            'gender'=> 0,
            'company_number'=> '1236652',
            // 'profile_url'=> null
            // 'company_position'=> 'Designer',
            'date_hired'=> '2018-3-6',
            // 'contact_number'=> 
            'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sta. Cruz, Liloan, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            // 'allowed_leave_number'=>
          ],
          'user_roles' => [1],
          'user_company_positions' => [15],
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]
        ],
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Cris Villaflores',
            'last_name' => 'Casipe',
            'email' => 'CrisCasipe@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 5,
            'shift_time_id'=> 1,
            'gender'=> 0,
            'company_number'=> '1236652',
            // 'profile_url'=> null
            // 'company_position'=> 'Reseller Support',
            'date_hired'=> '2018-3-6',
            // 'contact_number'=> 
            'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sta. Cruz, Liloan, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            // 'allowed_leave_number'=>
          ],
          'user_roles' => [1],
          'user_company_positions' => [14],
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]
        ],
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Ivan Kirby Taghoy',
            'last_name' => 'Colina',
            'email' => 'IvanColina@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 5,
            'shift_time_id'=> 1,
            'gender'=> 0,
            'company_number'=> '1236652',
            // 'profile_url'=> null
            // 'company_position'=> 'PHP DEV',
            'date_hired'=> '2018-3-6',
            // 'contact_number'=> ,
            'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sta. Cruz, Liloan, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            // 'allowed_leave_number'=>
          ],
          'user_roles' => [1],
          'user_company_positions' => [2],
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]
        ],
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Carl Wyner Velasco',
            'last_name' => 'Javier',
            'email' => 'CarlJavier@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 5,
            'shift_time_id'=> 1,
            'gender'=> 0,
            'company_number'=> '1236652',
            // 'profile_url'=> null
            // 'company_position'=> 'PHP DEV',
            'date_hired'=> '2018-3-6',
            // 'contact_number'=> ,
            'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sta. Cruz, Liloan, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            // 'allowed_leave_number'=>
          ],
          'user_roles' => [1],
          'user_company_positions' => [2],
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]
        ],
        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Jhonnel Bagayas',
            'last_name' => 'Rosales',
            'email' => 'JhonnelRosales@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 5,
            'shift_time_id'=> 1,
            'gender'=> 0,
            'company_number'=> '1236652',
            // 'profile_url'=> null
            // 'company_position'=> 'PHP DEV',
            'date_hired'=> '2018-3-6',
            // 'contact_number'=> 
            'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sta. Cruz, Liloan, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            // 'allowed_leave_number'=>
          ],
          'user_roles' => [1],
          'user_company_positions' => [2],
          'event_types' => [
            [
              'event_name' => 'holiday',
              'color' => 'red'
            ],
            [
              'event_name' => 'work',
              'color' => 'yellow'
            ]
          ]
        ],
    ];
  } 
}


// Marketing 
// Atis, Cielo Fe Sasing
// Gemarino, Dianen
// Lapiz,Nina Rose Autida
// Mendoza, Jocel Redotco
// Sasing, Jake Ellema

// Admin
// Rosales, Fenella Corinne Real

// Podador, April Claire Chagas

// Mobile Development
// Hamoy, Gerard Winston Villegas
// Luta, Elbert Estardo
// Navales, Joy Marie Lupague
// Terdes, Nathaniel Cala

// Web Development
// Bacalla, Brisbane Jr Real
// Cabigas, Burt Karl Jusayan
// Camporaso, Fellow James
// Casipe, Cris Villaflores
// Colina, Ivan Kirby Taghoy
// Javier, Carl Wyner Velasco

// Finance
// Salut,  Pretty Jean Mission
