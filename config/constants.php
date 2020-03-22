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
        // ENV CONFIG:
        'framework_name' => env('FRAMEWORK_NAME', 'Laravel'),
        'application_name' => env('APP_NAME', 'Antelope'),
        'application_subname' => env('APP_SUBNAME', 'PHP'),
        'application_version' => '1.0.0',
        'application_footer' => env('APP_FOOTER', 'Department of Justice RP'),
        'application_enviroment' => env('APP_ENV', 'local'),
        'application_color' => env('APP_COLOR', 'success'),
        // NON-ENV CONFIG:
        'application_icon' => 'fab fa-asymmetrik',
        'application_favicon' => 'favicon.png',
    ],

    /*
    |--------------------------------------------------------------------------
    | Global Website Announcement
    |--------------------------------------------------------------------------
    |
    | This controls the global website announcement that will be shown on every
    | page of the website.
    |
    */
    'announcement' => [
        'enabled' => false,
        'visible' => [
            'main_application' => false,
            'public_roster' => false,
            'login_page' => false,
        ],
        'content' => [
            'icon' => 'fab fa-asymmetrik rotate-n-15',
            'background-color' => 'info',
            'content' => 'Enter the contect for the announcement here!',
        ],
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
        'min_requirements_logs' => 1, // 1 logs required
        'min_requirements_hours' => 28800, // 5 hours required
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
        'department_name' => env('DEPARTMENT_NAME', 'San Andreas Highway Patrol'),
        'department_short_name' => env('DEPARTMENT_SHORT_NAME', 'SAHP'),
        'department_unit_name' => env('DEPARTMENT_UNIT_NAME', 'Trooper'),
        'department_callsign' => env('DEPARTMENT_CALLSIGN', 'Unit Number'),
        'department_director' => env('DEPARTMENT_DIRECTOR', 'Devon C. 5E-1'),
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
        'public_roster' => 'Public Roster',
        'internal_roster' => 'Internal Roster',
        'investigative_search' => 'Investigative Search',
        'notification_center' => 'Notification Center',
    ],

    /*
    |--------------------------------------------------------------------------
    | Antelope Status
    |--------------------------------------------------------------------------
    |
    | Antelope Status defines their ANTELOPE profile status, this usually
    | means if the profile is activated or deactivated.
    |
    */
    'antelope_status_text' => [
        true => 'Profile Activated',
        false => 'Profile Deactivated',
    ],

    'antelope_status_color' => [
        true => 'success',
        false => 'danger',
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
        'cmt' => 'Chief Master Trooper Access',
        'member' => 'Member Access',
        'guest' => 'Guest Access',
    ],

    'access_level' => [
        'superadmin' => 8,
        'admin' => 7,
        'seniorstaff' => 6,
        'staff' => 5,
        'sit' => 4,
        'cmt' => 3,
        'member' => 2,
        'guest' => 1,
    ],

    'access_color' => [
        'superadmin' => 'info',
        'admin' => 'danger',
        'seniorstaff' => 'danger',
        'staff' => 'warning',
        'sit' => 'primary',
        'cmt' => 'primary',
        'member' => 'primary',
        'guest' => 'light',
    ],

    /*
    |--------------------------------------------------------------------------
    | Rank Constants
    |--------------------------------------------------------------------------
    |
    | Rank Constants are the names of the Chain of Command ranks in the
    | community that are also reflected through the website.
    | Do not change the 'probationary_civilian' key otherwise it will break stuff!
    |
    */
    'rank' => [
        'commissioner' => 'Commissioner',
        'deputy_commissioner' => 'Deputy Commissioner',
        'asst_commissioner' => 'Assistant Commissioner',
        'chief' => 'Chief',
        'asst_chief' => 'Assistant Chief',
        'captain' => 'Captain',
        'lieutenant' => 'Lieutenant',
        'master_sergeant' => 'Master Sergeant',
        'staff_sergeant' => 'Staff Sergeant',
        'sergeant' => 'Sergeant',
        'senior_corporal' => 'Senior Corporal',
        'corporal' => 'Corporal',
        'chief_master_trooper' => 'Chief Master Trooper',
        //'master_civilian' => 'Master Trooper',
        'master_trooper' => 'Master Trooper',
        'senior_trooper' => 'Senior Trooper',
        'trooper_first_class' => 'Trooper First Class',
        'trooper' => 'Trooper',
        'probationary' => 'Probationary Trooper',
        'reserve_master' => 'Master Auxiliary Trooper',
        'reserve_senior' => 'Senior Auxiliary Trooper',
        'reserve_probationary' => 'Auxiliary Trooper',
        'media_four' => 'SAHP Media IV',
        'media_three' => 'SAHP Media III',
        'media_two' => 'SAHP Media II',
        'media_one' => 'SAHP Media I',
        'other_admin' => 'DoJ Administration',
        'ia' => 'Internal Affairs',
        'other_guest' => 'Highway Guest',
    ],

    'rank_groups' => [

        'admin' => [
            'commissioner',
            'deputy_commissioner',
            'asst_commissioner',
            'chief',
            'asst_chief',
        ],

        'senior_staff' => [
            'captain',
            'lieutenant',
        ],

        'staff' => [
            'master_sergeant',
            'staff_sergeant',
            'sergeant',
        ],

        'sit' => [
            'senior_corporal',
            'corporal',
        ],

        'senior_member' => [
            'chief_master_trooper',
            //'master_civilian',
        ],

        'member' => [
	    'master_trooper',
            'senior_trooper',
            'trooper_first_class',
            'trooper',
        ],

        'probationary_member' => [
            'probationary',
        ],

        'reserve' => [
            'reserve_master',
            'reserve_senior',
            'reserve_probationary',
        ],

        'media' => [
            'media_four',
            'media_three',
            'media_two',
            'media_one',
        ],

        'other' => [
            'other_admin',
            'ia',
            'other_guest',
        ],
    ],

    'rank_level' => [
        'commissioner' => 999,
        'deputy_commissioner' => 170,
        'asst_commissioner' => 160,
        'chief' => 150,
        'asst_chief' => 140,
        'captain' => 130,
        'lieutenant' => 120,
        'master_sergeant' => 110,
        'staff_sergeant' => 100,
        'sergeant' => 90,
        'senior_corporal' => 80,
        'corporal' => 70,
        'chief_master_trooper' => 60,
        'master_civilian' => 50,
        'master_trooper' => 40,
        'senior_trooper' => 30,
        'trooper_first_class' => 20,
        'trooper' => 10,
        'probationary' => 0,
        // Reserve Ranks
        'reserve_master' => 40,
        'reserve_senior' => 20,
        'reserve_probationary' => 0,
        // Media Ranks
        'media_four' => 40,
        'media_three' => 30,
        'media_two' => 20,
        'media_one' => 10,
        // Other Ranks
        'other_admin' => 0,
        'ia' => 0,
        'other_guest' => 0,
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
    | Avatars
    |--------------------------------------------------------------------------
    |
    | Types of avatars that can be accessed by everyone through member setings
    | BE CAREFUL WHEN EDIITNG THIS!.
    |
    */
    'avatars' => [
        'antelope' => 'Antelope User',
        'gnomed' => 'Morris Gnome',
        'coolpepe' => 'Pepe',
        'bobross' => 'Bob Ross',
    ],

    'avatar_filename' => [
        'antelope' => 'antelope.png',
        'gnomed' => 'morris.png',
        'coolpepe' => 'coolpepe.png',
        'bobross' => 'bobross.png',
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
        'LS1' => 'LS - Del Perro, Vespucci, Rockford, Little Seoul',
        'LS2' => 'LS - Richman, Vinewood Hills, Vinewood',
        'LS3' => 'LS - East Los Santos, Palomino, Tataviam',
        'LS4' => 'LS - LSIA, Port of Los Santos, La Puerta',
        'LS5' => 'LS - Downtown & South Los Santos',
        'BC1' => 'BC - Chumash & The West Coast',
        'BC2' => 'BC - Paleto Bay, Chiliad & Josiah',
        'BC3' => 'BC - Grapeseed, San Chianski & Gordo',
        'BC4' => 'BC - The Town of Sandy Shores',
        'BC5' => 'BC - Senora, Harmony, Great Chaparral',
    ],

    'quicklink_types' => [
        'document' => [
            'name' => 'Document Link',
            'icon' => 'mdi mdi-file-document',
            'color' => 'primary',
        ],
        'policy' => [
            'name' => 'Policy Link',
            'icon' => 'mdi mdi-file-lock',
            'color' => 'danger',
        ],
    ],

    'font_colors' => [
        'info',
        'danger',
        'warning',
        'success',
        'primary',
        'light',
    ],
];
