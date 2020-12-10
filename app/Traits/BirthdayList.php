<?php
namespace App\Traits;

trait BirthdayList {
  public function get_birthday_list() {
    return  [
      [
        'user_id' => 2,
        'title' => 'Birthday of Eren',
        'content' => 'The day of Katipunan',
        'start_date' => '2020-12-8',
        'end_date' => '2020-12-8',
        'is_public' => 1,
        'event_type_id' => 2,
        'is_yearly' => 1
      ],
      [
        'user_id' => 2,
        'title' => 'Birthday of Max',
        'content' => 'bday of me',
        'start_date' => '2020-12-9',
        'end_date' => '2020-12-9',
        'is_public' => 1,
        'event_type_id' => 2,
        'is_yearly' => 1
      ],
    ];
  }
}
