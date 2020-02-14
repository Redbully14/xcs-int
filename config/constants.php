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
        'application_favicon' => 'favicon.png',
    ],

    /*
    |--------------------------------------------------------------------------
    | System Calculations
    |--------------------------------------------------------------------------
    |
    | These are calculations that will be made on the system, all inputs here
    | are and must be numbers.
    |
    */
    'calculation' => [
        'time_to_inactive' => 2592000, // 30 days without patrol logs
        'account_is_new' => 604800, // 7 days from the account being made
        'custom_one_week' => 604800, // Set one week here (default 7 days)
        'custom_one_month' => 2678400, // Set one month here (default 31 days)
        'custom_two_month' => 5356800, // Set two month here (default 62 days)
        'min_requirements_logs' => 4, // 4 logs required
        'min_requirements_hours' => 14400, // 4 hours required
        'patrol_restriction_90' => 604800, // 1 week
        'patrol_restriction_93' => 1209600, // 2 weeks
        'recent_loa' => 604800, // 1 week
        'absence_admin_approval' => 2592000, // 1 month (30 days)
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
        'absence_database' => 'Absence Database',
        'account_settings' => 'Account Settings',
        'user_profile' => 'User Profile',
        'personal_profile' => 'My Profile',
        'discipline_database' => 'Discipline Database',
        'superadmin' => 'SuperAdmin',
        'settings_admin' => 'Administrator Settings',
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
        true => 'Profile Activated',
        false => 'Profile Deactivated',
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
    | Auth Colors
    |--------------------------------------------------------------------------
    |
    | Auth Colors are mainly for customization only, it doesn't use RGB so
    | don't change anything if you really know what you are doing. 
    |
    */
    'access_color' => [
        'superadmin' => 'info',
        'admin' => 'danger',
        'seniorstaff' => 'danger',
        'staff' => 'warning',
        'sit' => 'primary',
        'intern' => 'primary',
        'member' => 'primary',
        'guest' => 'bright',
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
    | Patrol Constants
    |--------------------------------------------------------------------------
    |
    | Constants for use in patrol logs.
    |
    */
    'patrol_type' => [
        'normal' => 'Normal Patrol',
        'subdivisional' => 'Business Patrol',
        'fto' => 'Field Training',
    ],

    'soft_patrol_hour_limit' => 12, // hours

    /*
    |--------------------------------------------------------------------------
    | Department Status
    |--------------------------------------------------------------------------
    |
    | Types of status that will be displayed on the roster, profile and on
    | other pages of the website.
    |
    */
    'department_status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'new' => 'New',
        'exempt' => 'Exempt',
        'absent' => 'LOA',
    ],

    /*
    |--------------------------------------------------------------------------
    | Department Status Colors
    |--------------------------------------------------------------------------
    |
    | Colors for status that will be displayed on users profiles, this is not
    | RGB so do not change it if you don't know what you're doing.
    |
    */
    'department_status_colors' => [
        'active' => 'success',
        'inactive' => 'danger',
        'new' => 'warning',
        'exempt' => 'info',
        'absent' => 'primary',
    ],

    /*
    |--------------------------------------------------------------------------
    | Leave of Absences
    |--------------------------------------------------------------------------
    |
    | Here is the configuration for Leave of Absences on the website, this
    | takes global effect for the entire system..
    |
    */
    'absence_status' => [
        0 => 'Pending Review',
        1 => 'Active',
        2 => 'Archived',
    ],

    /*
    |--------------------------------------------------------------------------
    | Disciplinary Actions
    |--------------------------------------------------------------------------
    |
    | Here is the configuration for Disciplinary Actions on the website, this
    | takes global effect for the entire system..
    |
    */
    'disciplinary_actions' => [
        1 => 'Warning',
        2 => '10-90',
        3 => '10-93',
        4 => 'Re-Certification',
        5 => 'Suspension',
        6 => 'Demotion',
        7 => 'Termination',
    ],

    'disciplinary_action_active' => [
        1 => 1209600, // 14 days
        2 => 2592000, // 30 days
        3 => 5184000, // 60 days
        4 => 2592000, // 30 days
        5 => 5184000, // 60 days
        6 => 2592000, // 30 days
        7 => 2592000, // 30 days
    ],

    'disciplinary_action_status' => [
        'active' => 'Active',
        'overturned' => 'Overturned',
        'disputed_active' => 'Disputed & Active',
        'expired' => 'Expired'
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
        'disciplinary_action' => 'DA-',
        'absence' => 'LOA-'
    ],

    /*
    |--------------------------------------------------------------------------
    | Avatar Names
    |--------------------------------------------------------------------------
    |
    | Types of avatars that can be accessed by everyone through member setings
    | BE CAREFUL WHEN EDIITNG THIS!.
    |
    */
    'avatars' => [
        'antelope' => 'Antelope Default Avatar',
        'antelope2' => 'Antelope Better Avatar',
        'gnomed' => 'Get gnomed',
        'coolpepe' => 'Cool Pepe',
    ],

    /*
    |--------------------------------------------------------------------------
    | Avatar Files
    |--------------------------------------------------------------------------
    |
    | Avatar files inside public/assets/xcs-info/avatars/
    | BE CAREFUL WHEN EDIITNG THIS!.
    |
    */
    'avatar_filename' => [
        'antelope' => 'antelope.png',
        'antelope2' => 'antelope2.jpg',
        'gnomed' => 'morris.png',
        'coolpepe' => 'coolpepe.png',
    ],

    /*
    |--------------------------------------------------------------------------
    | Website Customization
    |--------------------------------------------------------------------------
    |
    | All the customization fields can be found here
    |
    */
    'requirements' => [
        'met' => 'Met',
        'not_met' => 'Not Met',
        'new' => 'New',
        'exempt' => 'Exempt',
    ],

    'requirements_colors' => [
        'met' => 'success',
        'not_met' => 'danger',
        'new' => 'warning',
        'exempt' => 'info',
    ],
    
    'backgrounds' => [
      'login' => '/assets/images/auth/civ_backdrop.png',
      'inactive' => '/assets/images/auth/civ_backdrop.png',
      'registration' => '/assets/images/auth/civ_backdrop.png',
    ],
    
    'patrol_area' => [
        'BC' => 'Blaine County',
        'LS' => 'Los Santos',
    ],

    'quicklink_types' => [
        'document' => 'Documentation Link',
        'policy' => 'Policy Link',
    ],
];
