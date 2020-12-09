<?php
namespace App\Traits;

trait HolidayList {
  public function get_holiday_list() {
    return  [
      [
        'user_id' => 2,
        'title' => 'New Year',
        'content' => 'Regular Holiday',
        'start_date' => '2020-01-1',
        'end_date' => '2020-01-1',
        'is_public' => 1,
        'event_type_id' => 1,
        'is_yearly' => 1
      ],
      //dli fixed ang day niya
      [
        'user_id' => 2,
        'title' => 'Chinese Lunar New Year',
        'content' => 'Special Non-working Holiday',
        'start_date' => '2020-12-8',
        'end_date' => '2020-12-8',
        'is_public' => 1,
        'event_type_id' => 1,
        'is_yearly' => 1
      ],
       [
        'user_id' => 2,
        'title' => 'EDSA Revolution Anniversary',
        'content' => 'Special Non-working Holiday',
        'start_date' => '2020-02-25',
        'end_date' => '2020-02-25',
        'is_public' => 1,
        'event_type_id' => 1,
        'is_yearly' => 1
      ],
        [
        'user_id' => 2,
        'title' => 'Araw ng Kagitingan',
        'content' => 'Special Non-working Holiday',
        'start_date' => '2020-04-9',
        'end_date' => '2020-04-9',
        'is_public' => 1,
        'event_type_id' => 1,
        'is_yearly' => 1
      ],
          //dli fixed ang day niya
          [
            'user_id' => 2,
            'title' => 'Maundy Thursday',
            'content' => 'Regular Holiday',
            'start_date' => '2020-04-9',
            'end_date' => '2020-04-9',
            'is_public' => 1,
            'event_type_id' => 1,
            'is_yearly' => 1
          ],
          //dli fixed ang day niya
           [
            'user_id' => 2,
            'title' => 'Good Friday',
            'content' => 'Regular Holiday',
            'start_date' => '2020-04-10',
            'end_date' => '2020-04-10',
            'is_public' => 1,
            'event_type_id' => 1,
            'is_yearly' => 1
          ],
           //dli fixed ang day niya
        [
          'user_id' => 2,
          'title' => 'Black Saturday',
          'content' => 'Regular Holiday',
          'start_date' => '2020-04-11',
          'end_date' => '2020-04-11',
          'is_public' => 1,
          'event_type_id' => 1,
          'is_yearly' => 1
        ],
        //dli fixed ang day niya
        [
          'user_id' => 2,
          'title' => 'Easter Sunday',
          'content' => 'Observance',
          'start_date' => '2020-04-11',
          'end_date' => '2020-04-11',
          'is_public' => 1,
          'event_type_id' => 1,
          'is_yearly' => 1
        ],
         [
          'user_id' => 2,
          'title' => 'Labor Day',
          'content' => 'Regular Holiday',
          'start_date' => '2020-05-1',
          'end_date' => '2020-05-1',
          'is_public' => 1,
          'event_type_id' => 1,
          'is_yearly' => 1
        ],
        //dli fixed ang day niya
         [
          'user_id' => 2,
          'title' => 'Eid al-Fitr',
          'content' => 'Regular Holiday',
          'start_date' => '2020-05-25',
          'end_date' => '2020-05-25',
          'is_public' => 1,
          'event_type_id' => 1,
          'is_yearly' => 1
        ],
         [
          'user_id' => 2,
          'title' => 'Independence Day',
          'content' => 'Regular Holiday',
          'start_date' => '2020-06-12',
          'end_date' => '2020-06-12',
          'is_public' => 1,
          'event_type_id' => 1,
          'is_yearly' => 1
        ],
        //dli fixed ang days
          [
          'user_id' => 2,
          'title' => 'Eid al-Aldha',
          'content' => 'Regular Holiday',
          'start_date' => '2020-07-31',
          'end_date' => '2020-07-31',
          'is_public' => 1,
          'event_type_id' => 1,
          'is_yearly' => 1
        ],
         [
          'user_id' => 2,
          'title' => 'Ninoy Aquino Day',
          'content' => 'Special Non-working Holiday',
          'start_date' => '2020-08-21',
          'end_date' => '2020-08-21',
          'is_public' => 1,
          'event_type_id' => 1,
          'is_yearly' => 1
        ],
        [
          'user_id' => 2,
          'title' => 'National Heroes Day',
          'content' => 'Regular Holiday'  ,
          'start_date' => '2020-08-31',
          'end_date' => '2020-08-31',
          'is_public' => 1,
          'event_type_id' => 1,
          'is_yearly' => 1
        ],
        [
          'user_id' => 2,
          'title' => 'All Saints Day',
          'content' => 'Special Non-Working Holiday'  ,
          'start_date' => '2020-11-1',
          'end_date' => '2020-11-1',
          'is_public' => 1,
          'event_type_id' => 1,
          'is_yearly' => 1
        ],
         [
          'user_id' => 2,
          'title' => 'All Souls Day',
          'content' => 'Additional Special (Non-Working) Days'  ,
          'start_date' => '2020-11-2',
          'end_date' => '2020-11-2',
          'is_public' => 1,
          'event_type_id' => 1,
          'is_yearly' => 1
        ],
         [
          'user_id' => 2,
          'title' => 'Bonifacio Day',
          'content' => 'Regular Holiday'  ,
          'start_date' => '2020-11-30',
          'end_date' => '2020-11-30',
          'is_public' => 1,
          'event_type_id' => 1,
          'is_yearly' => 1
        ],
        [
          'user_id' => 2,
          'title' => 'Feast of the Immaculate Conception',
          'content' => 'Special Non-Working Holiday'  ,
          'start_date' => '2020-12-08',
          'end_date' => '2020-12-08',
          'is_public' => 1,
          'event_type_id' => 1,
          'is_yearly' => 1
        ],
        [
          'user_id' => 2,
          'title' => 'Christmas Eve',
          'content' => 'Additional Special (Non-Working) Days' ,
          'start_date' => '2020-12-24',
          'end_date' => '2020-12-24',
          'is_public' => 1,
          'event_type_id' => 1,
          'is_yearly' => 1
        ],
         [
          'user_id' => 2,
          'title' => 'Christmas Day',
          'content' => 'Regular Holiday'  ,
          'start_date' => '2020-12-25',
          'end_date' => '2020-12-25',
          'is_public' => 1,
          'event_type_id' => 1,
          'is_yearly' => 1
        ],
        [
          'user_id' => 2,
          'title' => 'Rizal Day',
          'content' => 'Regular Holiday'  ,
          'start_date' => '2020-12-30',
          'end_date' => '2020-12-30',
          'is_public' => 1,
          'event_type_id' => 1,
          'is_yearly' => 1
        ],
        [
          'user_id' => 2,
          'title' => 'New Years Eve',
          'content' => 'Special Non-working Holiday'  ,
          'start_date' => '2020-12-31',
          'end_date' => '2020-12-31',
          'is_public' => 1,
          'event_type_id' => 1,
          'is_yearly' => 1
        ],
    ];
  }
}
