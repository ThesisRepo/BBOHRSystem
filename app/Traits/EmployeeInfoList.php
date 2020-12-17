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
            'email' => 'shin@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            //   'department_id' => 2,
            //   'shift_time_id'=> 1,
            'gender'=> 1,
            // 'company_number'=> '1234652',
            // 'profile_url'=> null
            // 'company_position'=> 'General Manager',
          //   'date_hired'=> '2018-3-6',
          //   // 'contact_number'=> 
          //   'civil_status_id'=> 1,
            'company_status_id'=> 3,
          //   'birthday'=>'1984-4-13',
          //   'address'=> 'Sta. Cruz, Liloan, Cebu',
          //   // 'tin_number'=> 
          //   // 'sss_number'=>
          //   // 'pag_ibig_number'=>
          //   // 'philhealth_number'=>
          //   // 'allowed_leave_number'=>
          ],
          'user_roles' => [1, 2, 5],
          'user_company_positions' => [16],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Fenella Corinne Real',
            'last_name' => 'Rosales',
            'email' => 'fenella@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          // 'user_info' => null,
          'user_info' => [
            'department_id' => 2,
            'shift_time_id'=> 1,
            'gender'=> 0,
            'company_number'=> '10092018AU1',
          //   // 'profile_url'=> null
            // 'company_position'=> 'Customer Support Leader',
            'date_hired'=> '2018-10-9',
            // 'contact_number'=> 
          //   'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1989-7-16',
            'address'=> 'MOQ6 PC Hills, Apas, Cebu City 6000',
          //   // 'tin_number'=> 
          //   // 'sss_number'=>
          //   // 'pag_ibig_number'=>
          //   // 'philhealth_number'=>
            'allowed_leave_number'=> 7
          ],
          'user_roles' => [1, 2, 4],
          'user_company_positions' => [7, 8],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'April Claire Chagas',
            'last_name' => 'Podador',
            'email' => 'claire@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          // 'user_info' => null,
          'user_info' => [
            'department_id' => 2,
            'shift_time_id'=> 3,
            'gender'=> 0,
            'company_number'=> '01162018AF1',
          //   // 'profile_url'=> null
          //   // 'company_position'=> 'Customer Support Leader',
            'date_hired'=> '2018-6-16',  
            'contact_number'=> '09270798523',
          //   'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1991-4-29',
            'address'=> 'Lahug, Cebu City',
          //   // 'tin_number'=> 
          //   // 'sss_number'=>
          //   // 'pag_ibig_number'=>
          //   // 'philhealth_number'=>
            'allowed_leave_number'=> 7
          ],
          'user_roles' => [1,2,3],
          'user_company_positions' => [6, 7, 9],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Cielo Fe Sasing',
            'last_name' => 'Atis',
            'email' => 'cielo@bluebeeone.com',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 1,
            'shift_time_id'=> 3,
            'gender'=> 0,
            'company_number'=> '03062018AA1',
            // 'profile_url'=> null
            'date_hired'=> '2018-3-6',
            'contact_number'=> '09178404130',
            // 'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sta. Cruz, Liloan, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            'allowed_leave_number'=> 7
          ],
          'user_roles' => [1, 2],
          'user_company_positions' => [17],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Gerard Winston Villegas',
            'last_name' => 'Hamoy',
            'email' => 'gerard@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 6,
            'shift_time_id'=> 3,
            'gender'=> 1,
            'company_number'=> '09102019EA1',
            // 'profile_url'=> null
            // 'company_position'=> 'Apps Developer', 
            'date_hired'=> '2019-9-10',
            'contact_number'=> '09611320592',
            // 'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1989-2-18',
            'address'=> 'Unit 7, 20 Rahmann San Jose St, Brgy. Zapatera, Cebu City, Cebu, Philippines,6000',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            'allowed_leave_number'=> 7
          ],
          'user_roles' => [1,2],
          'user_company_positions' => [2],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Brisbane Jr Real',
            'last_name' => 'Bacalla',
            'email' => 'Brisbane@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 6,
            'shift_time_id'=> 3,
            'gender'=> 1,
            'company_number'=> '11252019DA1',
            // 'profile_url'=> null
            // 'company_position'=> 'PHP DEV',
            'date_hired'=> '2019-11-25',
            'contact_number'=> '09499305201',
            // 'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1997-3-31',
            'address'=> 'Deca Homes 5 Blk 19 Lot 19 Basak Lapu Lapu City Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            'allowed_leave_number'=> 7
          ],
          'user_roles' => [1, 2],
          'user_company_positions' => [2],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Dianen',
            'last_name' => 'Gemarino',
            'email' => 'dianen@bluebeeone.com',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 1,
            'shift_time_id'=> 3,
            'gender'=> 0,
            'company_number'=> '08242020B11',
            // 'profile_url'=> null
            // 'company_position'=> 'MKTG. Assistant',
            'date_hired'=> '2020-8-24',
            // 'contact_number'=> ''
            // 'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1990-11-27',
            'address'=> 'Dionisio Jakosalem St., Cebu City',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            'allowed_leave_number'=> 7
          ],
          'user_roles' => [1],
          'user_company_positions' => [13],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Nina Rose Autida',
            'last_name' => 'Lapiz',
            'email' => 'nina@bluebeeone.com',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 1,
            'shift_time_id'=> 3,
            'gender'=> 0,
            'company_number'=> '09072018AM1',
            // 'profile_url'=> null
            // 'company_position'=> 'Sales & Support',
            'date_hired'=> '2018-7-9',
            'contact_number'=> '09954664744',
            // 'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1995-1-15',
            'address'=> 'Buenavista Homes Jugan Consolacion Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            'allowed_leave_number'=> 1
          ],
          'user_roles' => [1],
          'user_company_positions' => [12],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Jocel Redotco',
            'last_name' => 'Mendoza',
            'email' => 'jocel@bluebeeone.com',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 1,
            'shift_time_id'=> 3,
            'gender'=> 0,
            'company_number'=> '10292018AW1',
            // 'profile_url'=> null
            // 'company_position'=> 'Online Sales Associate',
            'date_hired'=> '2018-10-9',
            'contact_number'=> '09276545179',
            'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1992-10-6',
            'address'=> 'Lot 38/39 Blk 11 Sariville Subd., Gen. Luna St., Brgy. Poblacion, Talisay City, Cebu, 6045',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            'allowed_leave_number'=> 7
          ],
          'user_roles' => [1],
          'user_company_positions' => [10],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]

        ],  

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Jake Ellema',
            'last_name' => 'Sasing',
            'email' => 'JakeSasing@bbo.com.ph', // not existing
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 1,
            'shift_time_id'=> 3,
            'gender'=> 1,
            'company_number'=> '04052019Z1',
            // 'profile_url'=> null
            // 'company_position'=> 'Utility/Messenger',
            'date_hired'=> '2018-3-6',
            'contact_number'=> '09223955790',
            // 'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-3-27',
            'address'=> 'Casuntingan, Mandaue City',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            'allowed_leave_number'=> 7
          ],
          'user_roles' => [1],
          'user_company_positions' => [4],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Mary Diane',
            'last_name' => 'Salasayo',
            'email' => 'marydiane@bluebeeone.com',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 1,
            'shift_time_id'=> 3,
            'gender'=> 0,
            'company_number'=> '09142020C11',
            // 'profile_url'=> null
            // 'company_position'=> 'Marketng Staff',
            'date_hired'=> '2020-9-17',
            // 'contact_number'=> ,
            // 'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1997-11-18',
            'address'=> 'Leyte',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            'allowed_leave_number'=> 7
          ],
          'user_roles' => [1],
          'user_company_positions' => [1],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Pretty Jean Mission',
            'last_name' => 'Salut',
            'email' => 'pretty@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 3,
            'shift_time_id'=> 3,
            'gender'=> 0,
            'company_number'=> '01062020AA1',
            // 'profile_url'=> null
            // 'company_position'=> 'Accounting Assistant',
            'date_hired'=> '2020-1-6',
            // 'contact_number'=> 
            // 'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1989-8-25',
            'address'=> 'Cambiohan, consolacion, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            'allowed_leave_number'=> 7
          ],
          'user_roles' => [1],
          'user_company_positions' => [5],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Elbert Estardo',
            'last_name' => 'Luta',
            'email' => 'elbert@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 5,
            'shift_time_id'=> 3,
            'gender'=> 0,
            'company_number'=> '06102019BA1',
            // 'profile_url'=> null
            // 'company_position'=> 'App Developer',
            'date_hired'=> '2019-6-10',
            'contact_number'=> '09957341173',
            // 'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1998-5-5',
            'address'=> 'Bout Punta Engano Lapu-lapu City, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            'allowed_leave_number'=> 7
          ],
          'user_roles' => [1],
          'user_company_positions' => [11],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Joy Marie Lupague',
            'last_name' => 'Navales',
            'email' => 'joy@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 5,
            'shift_time_id'=> 3,
            'gender'=> 0,
            'company_number'=> '01142019AV1',
            // 'profile_url'=> null
            // 'company_position'=> 'Android Dev',
            'date_hired'=> '2019-1-14',
            'contact_number'=> '09062982298',
            // 'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1994-4-12',
            'address'=> 'Zn. 5 109 Artville, San Isidro, Talisay City, Cebu 6045',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            'allowed_leave_number'=> 7
          ],
          'user_roles' => [1],
          'user_company_positions' => [3],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Nathaniel Cala',
            'last_name' => 'Terdes',
            'email' => 'nathaniel@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 5,
            'shift_time_id'=> 3,
            'gender'=> 1,
            'company_number'=> '03192018AI1',
            // 'profile_url'=> null
            // 'company_position'=> 'Android Dev',
            'date_hired'=> '2018-3-19',
            'contact_number'=> '09999826473',
            // 'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1991-11-28',
            'address'=> 'Punta Princesa, Cebu City, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            'allowed_leave_number'=> 7
          ],
          'user_roles' => [1],
          'user_company_positions' => [3],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Burt Karl Jusayan',
            'last_name' => 'Cabigas',
            'email' => 'burt@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 6,
            'shift_time_id'=> 3,
            'gender'=> 1,
            'company_number'=> '03202019AX1',
            // 'profile_url'=> null,
            // 'company_position'=> 'PHP DEV',
            'date_hired'=> '2019-4-20',
            'contact_number'=> '09453311165',
            // 'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1992-9-13',
            'address'=> 'Greenbelt Drive, Quiot, Cebu City',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            'allowed_leave_number'=> 7
          ],
          'user_roles' => [1],
          'user_company_positions' => [2],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Fellow James',
            'last_name' => 'Camporaso',
            'email' => 'fellow@bluebeeone.com',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 6,
            'shift_time_id'=> 1,
            'gender'=> 0,
            'company_number'=> '08272020AJ1',
            // 'profile_url'=> null
            // 'company_position'=> 'Designer',
            'date_hired'=> '2020-8-27',
            // 'contact_number'=> 
            // 'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1995-2-20',
            'address'=> 'Lusimba, Pardo, Cebu City',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            'allowed_leave_number'=> 7
          ],
          'user_roles' => [1],
          'user_company_positions' => [15],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Cris Villaflores',
            'last_name' => 'Casipe',
            'email' => 'cris@bluebeeone.com',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 4,
            'shift_time_id'=> 3,
            'gender'=> 1,
            'company_number'=> '09102018AN1',
            // 'profile_url'=> null
            // 'company_position'=> 'Reseller Support',
            'date_hired'=> '2018-9-7',
            // 'contact_number'=> 
            // 'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-11-03',
            'address'=> '909 Ines Ouano Pvt. Rd., A.S. Fortuna, Banilad, Mandue City, Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            'allowed_leave_number'=> 7
          ],
          'user_roles' => [1],
          'user_company_positions' => [14],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Ivan Kirby Taghoy',
            'last_name' => 'Colina',
            'email' => 'ivan@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 6,
            'shift_time_id'=> 3,
            'gender'=> 1,
            'company_number'=> '01152018AD1',
            // 'profile_url'=> null
            // 'company_position'=> 'PHP DEV',
            'date_hired'=> '2018-1-15',
            'contact_number'=> '09062255829',
            // 'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1995-6-15',
            'address'=> 'R. Duterte St., Banawa, Cebu City',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            'allowed_leave_number'=> 7
          ],
          'user_roles' => [1],
          'user_company_positions' => [2],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Carl Wyner Velasco',
            'last_name' => 'Javier',
            'email' => 'carl@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 6,
            'shift_time_id'=> 3,
            'gender'=> 1,
            'company_number'=> '10082018AT1',
            // 'profile_url'=> null
            // 'company_position'=> 'PHP DEV',
            'date_hired'=> '2018-10-8',
            'contact_number'=> '09306261832',
            // 'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1993-9-12',
            'address'=> 'Carreta, Cebu City',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            'allowed_leave_number'=> 7
          ],
          'user_roles' => [1],
          'user_company_positions' => [2],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],


        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Jhonnel Bagayas',
            'last_name' => 'Rosales',
            'email' => 'jhonnel@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            'department_id' => 6,
            'shift_time_id'=> 3,
            'gender'=> 1,
            'company_number'=> '01292018AH1',
            // 'profile_url'=> null
            // 'company_position'=> 'PHP DEV',
            'date_hired'=> '2018-1-29',
            'contact_number'=> '09436954687',
            // 'civil_status_id'=> 1,
            'company_status_id'=> 3,
            'birthday'=>'1984-4-13',
            'address'=> 'Sitio Fatima Lower Lipata Minglanilla Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            'allowed_leave_number'=> 7
          ],
          'user_roles' => [1],
          'user_company_positions' => [2],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
            ]
          ]
        ],

        [
          'user' => [
            // 'prp_assigned' => 3,
            // 'finance_assigned' => 4,
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@bbo.com.ph',
            'password' => Hash::make('123456789')
          ],
          'user_info' => [
            // 'department_id' => 6,
            // 'shift_time_id'=> 3,
            // 'gender'=> 1,
            // 'company_number'=> '01292018AH1',
            // 'profile_url'=> null
            // 'company_position'=> 'PHP DEV',
            // 'date_hired'=> '2018-1-29',
            // 'contact_number'=> '09436954687',
            // 'civil_status_id'=> 1,
            // 'company_status_id'=> 3,
            // 'birthday'=>'1984-4-13',
            // 'address'=> 'Sitio Fatima Lower Lipata Minglanilla Cebu',
            // 'tin_number'=> 
            // 'sss_number'=>
            // 'pag_ibig_number'=>
            // 'philhealth_number'=>
            // 'allowed_leave_number'=> 7
          ],
          'user_roles' => [1,2,4,6],
          'user_company_positions' => [],
          'event_types' => [
            [
              'event_name' => 'Holiday',
              'color' => '#FF0000'
            ],
            [
              'event_name' => 'Birthday',
              'color' => '#FFFF00'
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
