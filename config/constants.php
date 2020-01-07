<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Global Constants
    |--------------------------------------------------------------------------
    |
    | Global Constants are used to define variables used on a global scale
    | these can be referenced anywhere in the application.
    |
    */

    'global' => [
        'framework_name' => 'xcs_int',
        'application_name' => 'Antelope',
        'application_subname' => 'PHP',
        'application_version' => 'canary',
        'application_footer' => 'Department of Justice RP',
        'application_icon' => 'fab fa-asymmetrik',
    ],

    /*
    |--------------------------------------------------------------------------
    | Department Constants
    |--------------------------------------------------------------------------
    |
    | The magic of Antelope happens here, changing this will change the system-
    | wide setting for which department this system is meant for.
    |
    */
    'department' => [
        'department_name' => 'Civilian Operations',
        'department_short_name' => 'Civilians',
        'department_unit_name' => 'Civilian',
        'department_callsign' => 'Civilian Number',
        'department_director' => 'Ryan S. Civ-1',
    ],

    /*
    |--------------------------------------------------------------------------
    | Page Name Constants
    |--------------------------------------------------------------------------
    |
    | Page Name Constants are used to define page names within the application
    | that will reflect the changes throughout the website.
    |
    */
    'pages' => [
        'dashboard' => 'Dashboard',
        'member_admin' => 'Member Settings',
        'activity_database' => 'Activity Database',
    ],

    /*
    |--------------------------------------------------------------------------
    | Antelope Member Status Colors
    |--------------------------------------------------------------------------
    |
    | Antelope Member Status Colors Constant defines the type of color that
    | that would reflect a member when access is marked as either active or
    | inactive on the website.
    |
    */
    'antelope_status_color' => [
        true => 'success',
        false => 'danger',
    ],

    /*
    |--------------------------------------------------------------------------
    | Antelope Member Status Text
    |--------------------------------------------------------------------------
    |
    | Antelope Member Status Colors Constant defines the type of text that
    | would appear on the website when searching up a member.
    |
    */
    'antelope_status_text' => [
        true => 'Active Profile',
        false => 'Inactive Profile',
    ],

    /*
    |--------------------------------------------------------------------------
    | Role Level Constants
    |--------------------------------------------------------------------------
    |
    | Role Level Constants are the names of the Antelope Access Level
    | abilities that are reflected through the website. 
    | (!) -> DB::TABLE 'role_user' MUST BE REBUILT UPON CHANGE
    |
    */
    'role' => [
        'superadmin' => 'Antelope Developer',
        'admin' => 'Administration Access',
        'seniorstaff' => 'Senior Staff Access',
        'staff' => 'Staff Access',
        'sit' => 'Staff in Training Access',
        'intern' => 'Intern Access',
        'member' => 'Member Access',
        'guest' => 'Guest Access',
    ],

    /*
    |--------------------------------------------------------------------------
    | Auth Levels
    |--------------------------------------------------------------------------
    |
    | Auth Levels show what type of level each role is, this should only be
    | changed if you really know what you are doing. 
    |
    */
    'access_level' => [
        'superadmin' => 8,
        'admin' => 7,
        'seniorstaff' => 6,
        'staff' => 5,
        'sit' => 4,
        'intern' => 3,
        'member' => 2,
        'guest' => 1,
    ],

    /*
    |--------------------------------------------------------------------------
    | Rank Constants
    |--------------------------------------------------------------------------
    |
    | Rank Constants are the names of the Chain of Command ranks in the
    | community that are also reflected through the website.
    |
    */
    'rank' => [
        'director' => 'Civilian Director',
        'deputy_director' => 'Civilian Deputy Director',
        'chief_of_staff' => 'Civilian Chief of Staff',
        'deputy_chief_of_staff' => 'Civilian Deputy Chief of Staff',
        'secretary_of_staff' => 'Civilian Secretary of Staff',
        'manager' => 'Civilian Manager',
        'assistant_manager' => 'Civilian Assistant Manager',
        'senior_supervisor' => 'Civilian Senior Supervisor',
        'supervisor' => 'Civilian Supervisor',
        'assistant_supervisor' => 'Civilian Assistant Supervisor',
        'senior_advisor' => 'Civilian Senior Advisor',
        'advisor' => 'Civilian Advisor',
        'intern' => 'Civilian Intern',
        'senior_civilian' => 'Senior Civilian',
        'civilian3' => 'Civilian III',
        'civilian2' => 'Civilian II',
        'civilian1' => 'Civilian I',
        'probationary_civilian' => 'Probationary Civilian',
        'reserve_senior' => 'Senior Civilian Reserve',
        'reserve_civilian' => 'Civilian Reserve',
        'reserve_probationary' => 'Probationary Civilian Reserve',
    ],

    /*
    |--------------------------------------------------------------------------
    | Patrol Types
    |--------------------------------------------------------------------------
    |
    | Types of patrols that civilians are able to choose from, all these patrols
    | are logged on specific endpoints on the system.
    |
    */
    'patrol_type' => [
        'normal' => 'Normal Patrol',
        'subdivisional' => 'Business Patrol',
        'fto' => 'Field Training',
    ],

    /*
    |--------------------------------------------------------------------------
    | Global IDs
    |--------------------------------------------------------------------------
    |
    | Global IDs are abbriviations that are put before the actual ID of an
    | item that is within the system.
    |
    */
    'global_id' => [
        'patrol_log' => 'PL-',
    ],
];